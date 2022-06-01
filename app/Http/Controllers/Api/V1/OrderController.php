<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\CentralLogics\OrderLogic;
use App\CentralLogics\CouponLogic;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetail;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\ItemCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function track_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $order = Order::with(['restaurant', 'delivery_man.rating'])->withCount('details')->where(['id' => $request['order_id'], 'user_id' => $request->user()->id])->Notpos()->first();
        if($order)
        {
            $order['restaurant'] = $order['restaurant']?Helpers::restaurant_data_formatting($order['restaurant']):$order['restaurant'];   
            $order['delivery_address'] = $order['delivery_address']?json_decode($order['delivery_address']):$order['delivery_address'];   
            $order['delivery_man'] = $order['delivery_man']?Helpers::deliverymen_data_formatting([$order['delivery_man']]):$order['delivery_man'];
            unset($order['details']);
        }
        else
        {
            return response()->json([
                'errors' => [
                    ['code' => 'schedule_at', 'message' => __('Not found')]
                ]
            ], 404);
        }
        return response()->json($order, 200);
    }

    public function place_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_amount' => 'required',
            'payment_method'=>'required|in:cash_on_delivery,digital_payment',
            'order_type' => 'required|in:take_away,delivery',
            'restaurant_id' => 'required',
            'distance' => 'required_if:order_type,delivery',
            'address' => 'required_if:order_type,delivery',
            'longitude' => 'required_if:order_type,delivery',
            'latitude' => 'required_if:order_type,delivery',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $coupon = null;
        $delivery_charge = null;
        $schedule_at = $request->schedule_at?\Carbon\Carbon::parse($request->schedule_at):now();
        if($request->schedule_at && $schedule_at < now())
        {
            return response()->json([
                'errors' => [
                    ['code' => 'order_time', 'message' => __('You can not schedule a order in past')]
                ]
            ], 406);
        }
        $restaurant = Restaurant::with('discount')->selectRaw('*, IF(((select count(*) from `restaurant_schedule` where `restaurants`.`id` = `restaurant_schedule`.`restaurant_id` and `restaurant_schedule`.`day` = '.$schedule_at->format('w').' and `restaurant_schedule`.`opening_time` < "'.$schedule_at->format('H:i:s').'" and `restaurant_schedule`.`closing_time` >"'.$schedule_at->format('H:i:s').'") > 0), true, false) as open')->where('id', $request->restaurant_id)->first();

        if(!$restaurant)
        {
            return response()->json([
                'errors' => [
                    ['code' => 'order_time', 'message' => __('Restaurant not_found')]
                ]
            ], 404);
        }

        if($request->schedule_at && !$restaurant->schedule_order)
        {
            return response()->json([
                'errors' => [
                    ['code' => 'schedule_at', 'message' => __('Schedule order not available')]
                ]
            ], 406);
        }
        

        if($restaurant->open == false)
        {
            return response()->json([
                'errors' => [
                    ['code' => 'order_time', 'message' => __('Restaurant is closed at order time')]
                ]
            ], 406);
        }
        

        // if(str_contains($restaurant->off_day, $schedule_at->dayOfWeek))
        // {
        //     return response()->json([
        //         'errors' => [
        //             ['code' => 'order_time', 'message' => __('Scheduled date is restaurant offday')]
        //         ]
        //     ], 406);
        // }

        if ($request['coupon_code']) {
            $coupon = Coupon::active()->where(['code' => $request['coupon_code']])->first();
            if (isset($coupon)) {
                $staus = CouponLogic::is_valide($coupon, $request->user()->id ,$request['restaurant_id']);
                if($staus==407)
                {
                    return response()->json([
                        'errors' => [
                            ['code' => 'coupon', 'message' => __('Coupon expire')]
                        ]
                    ], 407);
                }
                else if($staus==406)
                {
                    return response()->json([
                        'errors' => [
                            ['code' => 'coupon', 'message' => __('Coupon usage limit over')]
                        ]
                    ], 406);
                }
                else if($staus==404)
                {
                    return response()->json([
                        'errors' => [
                            ['code' => 'coupon', 'message' => __('Not found')]                            
                        ]
                    ], 404);
                }
                if($coupon->coupon_type == 'free_delivery')
                {
                    $delivery_charge = 0;
                    $coupon = null;
                }
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'coupon', 'message' => __('Not found')]
                    ]
                ], 401);
            }
        }
        $per_km_shipping_charge = (float)BusinessSetting::where(['key' => 'per_km_shipping_charge'])->first()->value;
        $minimum_shipping_charge = (float)BusinessSetting::where(['key' => 'minimum_shipping_charge'])->first()->value;
        $original_delivery_charge = ($request->distance * $per_km_shipping_charge > $minimum_shipping_charge) ? $request->distance * $per_km_shipping_charge : $minimum_shipping_charge;
        if($request['order_type'] != 'take_away' && !$restaurant->free_delivery && !isset($delivery_charge))
        {
            if($restaurant->self_delivery_system)
            {
                $delivery_charge = $restaurant->delivery_charge;
                $original_delivery_charge = $restaurant->delivery_charge;
            }
            else
            {
                $delivery_charge = ($request->distance * $per_km_shipping_charge > $minimum_shipping_charge) ? $request->distance * $per_km_shipping_charge : $minimum_shipping_charge;
            }
        }

        if($request->latitude && $request->longitude)
        {
            $point = new Point($request->latitude,$request->longitude);
            $zone = Zone::where('id', $restaurant->zone_id)->contains('coordinates', $point)->first();
            if(!$zone)
            {
                $errors = [];
                array_push($errors, ['code' => 'coordinates', 'message' => __('Out for coverage')]);
                return response()->json([
                    'errors' => $errors
                ], 403);
            }
        }

        $address = [
            'contact_person_name' => $request->contact_person_name?$request->contact_person_name:$request->user()->f_name.' '.$request->user()->f_name,
            'contact_person_number' => $request->contact_person_number?$request->contact_person_number:$request->user()->phone,
            'address_type' => $request->address_type?$request->address_type:'Delivery',
            'address' => $request->address,
            'longitude' => (string)$request->longitude,
            'latitude' => (string)$request->latitude,
        ];

        $total_addon_price = 0;
        $product_price = 0;
        $restaurant_discount_amount = 0;

        $order_details = [];
        $order = new Order();
        $order->id = 100000 + Order::all()->count() + 1;
        if (Order::find($order->id)) {
            $order->id = Order::orderBy('id','desc')->first()->id + 1;
        }
        $order->user_id = $request->user()->id;
        $order->order_amount = $request['order_amount'];
        $order->payment_status = 'unpaid';
        $order->order_status = $request['payment_method']=='digital_payment'?'failed':'pending';
        $order->coupon_code = $request['coupon_code'];
        $order->payment_method = $request->payment_method;
        $order->transaction_reference = null;
        $order->order_note = $request['order_note'];
        $order->order_type = $request['order_type'];
        $order->restaurant_id = $request['restaurant_id'];
        $order->delivery_charge = round($delivery_charge, config('round_up_to_digit'))??0;
        $order->original_delivery_charge = round($original_delivery_charge, config('round_up_to_digit'));
        $order->delivery_address = json_encode($address);
        $order->schedule_at = $schedule_at;
        $order->scheduled = $request->schedule_at?1:0;
        $order->otp = rand(1000, 9999);
        $order->zone_id = $restaurant->zone_id;
        $order->pending = now();
        $order->created_at = now();
        $order->updated_at = now();
        foreach ($request['cart'] as $c) {
            if ($c['item_campaign_id'] != null) {
                $product = ItemCampaign::active()->find($c['item_campaign_id']);
                if ($product) {
                    if (count(json_decode($product['variations'], true)) > 0) {
                        $price = Helpers::variation_price($product, json_encode($c['variation']));
                    } else {
                        $price = $product['price'];
                    }
                    $product->tax = $restaurant->tax;
                    $product = Helpers::product_data_formatting($product, false, false, app()->getLocale());
                    $addon_data = Helpers::calculate_addon_price(\App\Models\AddOn::whereIn('id',$c['add_on_ids'])->get(), $c['add_on_qtys']);
                    $or_d = [
                        'food_id' => null,
                        'item_campaign_id' => $c['item_campaign_id'],
                        'food_details' => json_encode($product),
                        'quantity' => $c['quantity'],
                        'price' => $price,
                        'tax_amount' => Helpers::tax_calculate($product, $price),
                        'discount_on_food' => Helpers::product_discount_calculate($product, $price, $restaurant),
                        'discount_type' => 'discount_on_product',
                        'variant' => json_encode($c['variant']),
                        'variation' => json_encode($c['variation']),
                        'add_ons' => json_encode($addon_data['addons']),
                        'total_add_on_price' => $addon_data['total_add_on_price'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    $order_details[] = $or_d;
                    $total_addon_price += $or_d['total_add_on_price'];
                    $product_price += $price*$or_d['quantity'];
                    $restaurant_discount_amount += $or_d['discount_on_food']*$or_d['quantity'];
                } else {
                    return response()->json([
                        'errors' => [
                            ['code' => 'campaign', 'message' => __('Product unavailable warning')]
                        ]
                    ], 401);
                }
            } else {
                $product = Food::active()->find($c['food_id']);
                if ($product) {
                    if (count(json_decode($product['variations'], true)) > 0) {
                        $price = Helpers::variation_price($product, json_encode($c['variation']));
                    } else {
                        $price = $product['price'];
                    }
                    $product->tax = $restaurant->tax;
                    $product = Helpers::product_data_formatting($product, false, false, app()->getLocale());
                    $addon_data = Helpers::calculate_addon_price(\App\Models\AddOn::whereIn('id',$c['add_on_ids'])->get(), $c['add_on_qtys']);
                    $or_d = [
                        'food_id' => $c['food_id'],
                        'item_campaign_id' => null,
                        'food_details' => json_encode($product),
                        'quantity' => $c['quantity'],
                        'price' => round($price, config('round_up_to_digit')),
                        'tax_amount' => round(Helpers::tax_calculate($product, $price), config('round_up_to_digit')),
                        'discount_on_food' => Helpers::product_discount_calculate($product, $price, $restaurant),
                        'discount_type' => 'discount_on_product',
                        'variant' => json_encode($c['variant']),
                        'variation' => json_encode($c['variation']),
                        'add_ons' => json_encode($addon_data['addons']),
                        'total_add_on_price' => round($addon_data['total_add_on_price'], config('round_up_to_digit')),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    $total_addon_price += $or_d['total_add_on_price'];
                    $product_price += $price*$or_d['quantity'];
                    $restaurant_discount_amount += $or_d['discount_on_food']*$or_d['quantity'];
                    $order_details[] = $or_d;
                } else {
                    return response()->json([
                        'errors' => [
                            ['code' => 'food', 'message' => __('Product unavailable warning')]
                        ]
                    ], 401);
                }
            }

        }
        $restaurant_discount = Helpers::get_restaurant_discount($restaurant);
        if(isset($restaurant_discount))
        {
            if($product_price + $total_addon_price < $restaurant_discount['min_purchase'])
            {
                $restaurant_discount_amount = 0;
            }

            if($restaurant_discount_amount > $restaurant_discount['max_discount'])
            {
                $restaurant_discount_amount = $restaurant_discount['max_discount'];
            }
        }
        $coupon_discount_amount = $coupon ? CouponLogic::get_discount($coupon, $product_price + $total_addon_price - $restaurant_discount_amount) : 0; 
        $total_price = $product_price + $total_addon_price - $restaurant_discount_amount - $coupon_discount_amount;

        $tax = $restaurant->tax;
        $total_tax_amount= ($tax > 0)?(($total_price * $tax)/100):0;

        if($restaurant->minimum_order > $product_price + $total_addon_price )
        {
            return response()->json([
                'errors' => [
                    ['code' => 'order_time', 'message' => __('you need to order at least', ['amount'=>$restaurant->minimum_order.' '.Helpers::currency_code()])]
                ]
            ], 406);
        }

        $free_delivery_over = BusinessSetting::where('key', 'free_delivery_over')->first()->value;
        if(isset($free_delivery_over))
        {
            if($free_delivery_over <= $product_price + $total_addon_price - $coupon_discount_amount - $restaurant_discount_amount)
            {
                $order->delivery_charge = 0;
            }
        }

        if($coupon)
        {
            $coupon->increment('total_uses');
        }
        try {
            $order->coupon_discount_amount = round($coupon_discount_amount, config('round_up_to_digit'));
            $order->coupon_discount_title = $coupon ? $coupon->title : ''; 

            $order->restaurant_discount_amount= round($restaurant_discount_amount, config('round_up_to_digit'));
            $order->total_tax_amount= round($total_tax_amount, config('round_up_to_digit'));
            $order->order_amount = round($total_price + $total_tax_amount + $order->delivery_charge , config('round_up_to_digit'));
            $order->save();
            foreach ($order_details as $key => $item) {
                $order_details[$key]['order_id'] = $order->id;
            }
            OrderDetail::insert($order_details);
            Helpers::send_order_notification($order);

            $customer = $request->user();
            $customer->zone_id = $restaurant->zone_id;
            $customer->save();

            $restaurant->increment('total_order');
    
            return response()->json([
                'message' => __('Order placed successfully'),
                'order_id' => $order->id,
                'total_ammount' => $total_price+$order->delivery_charge+$total_tax_amount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([$e], 403);
        }

        return response()->json([
            'errors' => [
                ['code' => 'order_time', 'message' => __('Failed to place order')]
            ]
        ], 403);
    }

    public function get_order_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $paginator = Order::with(['restaurant', 'delivery_man.rating'])->withCount('details')->where(['user_id' => $request->user()->id])->whereIn('order_status', ['delivered','canceled','refund_requested','refunded','failed'])->Notpos()->latest()->paginate($request['limit'], ['*'], 'page', $request['offset']);
        $orders = array_map(function ($data) {
            $data['delivery_address'] = $data['delivery_address']?json_decode($data['delivery_address']):$data['delivery_address'];   
            $data['restaurant'] = $data['restaurant']?Helpers::restaurant_data_formatting($data['restaurant']):$data['restaurant'];
            $data['delivery_man'] = $data['delivery_man']?Helpers::deliverymen_data_formatting([$data['delivery_man']]):$data['delivery_man'];
            return $data;
        }, $paginator->items());
        $data = [
            'total_size' => $paginator->total(),
            'limit' => $request['limit'],
            'offset' => $request['offset'],
            'orders' => $orders
        ];
        return response()->json($data, 200);
    }


    public function get_running_orders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $paginator = Order::with(['restaurant', 'delivery_man.rating'])->withCount('details')->where(['user_id' => $request->user()->id])->whereNotIn('order_status', ['delivered','canceled','refund_requested','refunded','failed'])->Notpos()->latest()->paginate($request['limit'], ['*'], 'page', $request['offset']);
        
        $orders = array_map(function ($data) {
            $data['delivery_address'] = $data['delivery_address']?json_decode($data['delivery_address']):$data['delivery_address'];   
            $data['restaurant'] = $data['restaurant']?Helpers::restaurant_data_formatting($data['restaurant']):$data['restaurant'];
            $data['delivery_man'] = $data['delivery_man']?Helpers::deliverymen_data_formatting([$data['delivery_man']]):$data['delivery_man'];
            return $data;
        }, $paginator->items());
        $data = [
            'total_size' => $paginator->total(),
            'limit' => $request['limit'],
            'offset' => $request['offset'],
            'orders' => $orders
        ];
        return response()->json($data, 200);
    }

    public function get_order_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $details = OrderDetail::whereHas('order', function($query)use($request){
            return $query->where('user_id', $request->user()->id);
        })->where(['order_id' => $request['order_id']])->get();
        if ($details->count() > 0) {
            $details = $details = Helpers::order_details_data_formatting($details);
            return response()->json($details, 200);
        } else {
            return response()->json([
                'errors' => [
                    ['code' => 'order', 'message' => __('Not found')]
                ]
            ], 401);
        }
    }

    public function cancel_order(Request $request)
    {
        $order = Order::where(['user_id' => $request->user()->id, 'id' => $request['order_id']])->Notpos()->first();
        if(!$order){
                return response()->json([
                    'errors' => [
                        ['code' => 'order', 'message' => __('Not found')]
                    ]
                ], 401);
        }
        else if ($order->order_status == 'pending') {

            $order->order_status = 'canceled';
            $order->canceled = now();
            $order->save();
            Helpers::send_order_notification($order);       
            return response()->json(['message' => __('Order canceled successfully')], 200);
        }
        return response()->json([
            'errors' => [
                ['code' => 'order', 'message' => __('You can not cancel after confirm')]
            ]
        ], 401);
    }

    public function refund_request(Request $request)
    {
        $order = Order::where(['user_id' => $request->user()->id, 'id' => $request['order_id']])->Notpos()->first();
        if(!$order){
                return response()->json([
                    'errors' => [
                        ['code' => 'order', 'message' => __('Not found')]
                    ]
                ], 401);
        }
        else if ($order->order_status == 'delivered') {

            $order->order_status = 'refund_requested';
            $order->refund_requested = now();
            $order->save();            
            return response()->json(['message' => __('Refund request placed successfully')], 200);
        }
        return response()->json([
            'errors' => [
                ['code' => 'order', 'message' => __('You can not request for refund after delivery')]
            ]
        ], 401);
    }

    public function update_payment_method(Request $request)
    {
        $config=Helpers::get_business_settings('cash_on_delivery');
        if($config['status']==0)
        {
            return response()->json([
                'errors' => [
                    ['code' => 'cod', 'message' => __('Cash on delivery order not available at this time')]
                ]
            ], 403);
        }
        $order = Order::where(['user_id' => $request->user()->id, 'id' => $request['order_id']])->Notpos()->first();
        if ($order) {
            Order::where(['user_id' => $request->user()->id, 'id' => $request['order_id']])->update([
                'payment_method' => 'cash_on_delivery', 'order_status'=>'pending', 'pending'=> now()
            ]);

            $fcm_token = $request->user()->cm_firebase_token;
            $value = Helpers::order_status_update_message('pending');
            try {
                if ($value) {
                    $data = [
                        'title' =>__('Order placed successfully'),
                        'description' => $value,
                        'order_id' => $order->id,
                        'image' => '',
                        'type'=>'order_status',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                    DB::table('user_notifications')->insert([
                        'data'=> json_encode($data),
                        'user_id'=>$request->user()->id,
                        'created_at'=>now(),
                        'updated_at'=>now()
                    ]);
                }
                if($order->order_type == 'delivery' && !$order->scheduled)
                {
                    $data = [
                        'title' =>__('Order placed successfully'),
                        'description' => __('New Order push description'),
                        'order_id' => $order->id,
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_topic($data, $order->restaurant->zone->deliveryman_wise_topic, 'order_request');
                }

            } catch (\Exception $e) {
                info($e);
            }
            return response()->json(['message' => __('payment').' '.__('method').' '.__('Updated successfully')], 200);
        }
        return response()->json([
            'errors' => [
                ['code' => 'order', 'message' => __('Not found')]
            ]
        ], 404);
    }
}
