<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Admin;
use App\Models\Discount;
use App\Models\Restaurant;
use App\Models\Zone;
use App\Models\AddOn;
use App\Models\WithdrawRequest;
use App\Models\RestaurantWallet;
use App\Models\AdminWallet;
use App\Models\AccountTransaction;
use App\Models\RestaurantSchedule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\Helpers;
use App\CentralLogics\RestaurantLogic;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Scopes\RestaurantScope;


class VendorController extends Controller
{
    public function index()
    {
        return view('admin-views.vendor.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'name' => 'required|max:191',
            'address' => 'required|max:1000',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' => 'required|unique:vendors',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:vendors',
            'minimum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
            'maximum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
            'password' => 'required|min:6',
            'zone_id' => 'required',
            'logo' => 'required',
            'tax' => 'required',
        ], [
            'f_name.required' => __('First name is required')
        ]);

        if($request->zone_id)
        {
            $point = new Point($request->latitude, $request->longitude);
            $zone = Zone::contains('coordinates', $point)->where('id', $request->zone_id)->first();
            if(!$zone){
                $validator->getMessageBag()->add('latitude', __('coordinates out of zone'));
                return back()->withErrors($validator)
                        ->withInput();
            }
        }
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $vendor = new Vendor();
        $vendor->f_name = $request->f_name;
        $vendor->l_name = $request->l_name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->password = bcrypt($request->password);
        $vendor->save();

        $restaurant = new Restaurant;
        $restaurant->name = $request->name;
        $restaurant->phone = $request->phone;
        $restaurant->email = $request->email;
        $restaurant->logo = Helpers::upload('restaurant/', 'png', $request->file('logo'));
        $restaurant->cover_photo = Helpers::upload('restaurant/cover/', 'png', $request->file('cover_photo'));
        $restaurant->address = $request->address;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->vendor_id = $vendor->id;
        $restaurant->zone_id = $request->zone_id;
        $restaurant->tax = $request->tax;
        $restaurant->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time;

        $restaurant->save();
        // $restaurant->zones()->attach($request->zone_ids);
        Toastr::success(__('vendor').__('added successfully'));
        return redirect('admin/vendor/list');
    }

    public function edit($id)
    {
        if(env('APP_MODE')=='demo' && $id == 2)
        {
            Toastr::warning(__('you can not edit this restaurant please add a new restaurant to edit'));
            return back();
        }
        $restaurant = Restaurant::find($id);
        return view('admin-views.vendor.edit', compact('restaurant'));
    }


    public function update(Request $request, Restaurant $restaurant)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'name' => 'required|max:191',
            'email' => 'required|unique:vendors,email,'.$restaurant->vendor->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:vendors,phone,'.$restaurant->vendor->id,
            'zone_id'=>'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tax' => 'required',
            'password' => 'nullable|min:6',
            'minimum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
            'maximum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
        ], [
            'f_name.required' => __('First name is required')
        ]);

        if($request->zone_id)
        {
            $point = new Point($request->latitude, $request->longitude);
            $zone = Zone::contains('coordinates', $point)->where('id', $request->zone_id)->first();
            if(!$zone){
                $validator->getMessageBag()->add('latitude', __('coordinates out of zone'));
                return back()->withErrors($validator)
                        ->withInput();
            }
        }
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $vendor = Vendor::findOrFail($restaurant->vendor->id);
        $vendor->f_name = $request->f_name;
        $vendor->l_name = $request->l_name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->password = strlen($request->password)>1?bcrypt($request->password):$restaurant->vendor->password;
        $vendor->save();

        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->logo = $request->has('logo') ? Helpers::update('restaurant/', $restaurant->logo, 'png', $request->file('logo')) : $restaurant->logo;
        $restaurant->cover_photo = $request->has('cover_photo') ? Helpers::update('restaurant/cover/', $restaurant->cover_photo, 'png', $request->file('cover_photo')) : $restaurant->cover_photo;
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->zone_id = $request->zone_id;
        $restaurant->tax = $request->tax;
        $restaurant->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time;
        // $restaurant->zones()->sync($request->zone_ids);
        $restaurant->save();
        Toastr::success(__('restaurant').__('updated_successfully'));
        return redirect('admin/vendor/list');
    }

    public function destroy(Request $request, Restaurant $restaurant)
    {
        if(env('APP_MODE')=='demo' && $restaurant->id == 2)
        {
            Toastr::warning(__('you can not edit this restaurant please add a new restaurant to edit'));
            return back();
        }
        if (Storage::disk('public')->exists('restaurant/' . $restaurant['logo'])) {
            Storage::disk('public')->delete('restaurant/' . $restaurant['logo']);
        }
        $restaurant->delete();

        $vendor = Vendor::findOrFail($restaurant->vendor->id);
        $vendor->delete();
        Toastr::success(__('restaurant').' '.__('removed'));
        return back();
    }

    public function view(Restaurant $restaurant, $tab=null, $sub_tab='cash')
    {
        $wallet = $restaurant->vendor->wallet;
        if(!$wallet)
        {
            $wallet= new RestaurantWallet();
            $wallet->vendor_id = $restaurant->vendor->id;
            $wallet->total_earning= 0.0;
            $wallet->total_withdrawn=0.0;
            $wallet->pending_withdraw=0.0;
            $wallet->created_at=now();
            $wallet->updated_at=now();
            $wallet->save();
        }
        if($tab == 'settings')
        {
            return view('admin-views.vendor.view.settings', compact('restaurant'));
        }
        else if($tab == 'order')
        {
            return view('admin-views.vendor.view.order', compact('restaurant'));
        }
        else if($tab == 'product')
        {
            return view('admin-views.vendor.view.product', compact('restaurant'));
        }
        else if($tab == 'discount')
        {
            return view('admin-views.vendor.view.discount', compact('restaurant'));
        }
        else if($tab == 'transaction')
        {
            return view('admin-views.vendor.view.transaction', compact('restaurant', 'sub_tab'));
        }

        else if($tab == 'reviews')
        {
            return view('admin-views.vendor.view.review', compact('restaurant', 'sub_tab'));
        }
        return view('admin-views.vendor.view.index', compact('restaurant', 'wallet'));
    }

    public function view_tab(Restaurant $restaurant)
    {

        Toastr::error(__('Unknown tab'));
        return back();
    }

    public function list(Request $request)
    {
        $zone_id = $request->query('zone_id', 'all');
        $type = $request->query('type', 'all');
        $restaurants = Restaurant::when(is_numeric($zone_id), function($query)use($zone_id){
                return $query->where('zone_id', $zone_id);
        })
        ->with('vendor')->type($type)->latest()->paginate(config('default_pagination'));
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        return view('admin-views.vendor.list', compact('restaurants', 'zone','type'));
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $restaurants=Restaurant::orWhereHas('vendor',function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })
        ->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })->get();
        $total=$restaurants->count();
        return response()->json([
            'view'=>view('admin-views.vendor.partials._table',compact('restaurants'))->render(), 'total'=>$total
        ]);
    }

    public function get_restaurants(Request $request){
        $zone_ids = isset($request->zone_ids)?(count($request->zone_ids)>0?$request->zone_ids:[]):0;
        $data = Restaurant::join('zones', 'zones.id', '=', 'restaurants.zone_id')
        ->when($zone_ids, function($query) use($zone_ids){
            $query->whereIn('restaurants.zone_id', $zone_ids);
        })->where('restaurants.name', 'like', '%'.$request->q.'%')->limit(8)->get([DB::raw('restaurants.id as id, CONCAT(restaurants.name, " (", zones.name,")") as text')]);
        if(isset($request->all))
        {
            $data[]=(object)['id'=>'all', 'text'=>'All'];
        }
        return response()->json($data);
    }

    public function status(Restaurant $restaurant, Request $request)
    {
        $restaurant->status = $request->status;
        $restaurant->save();
        $vendor = $restaurant->vendor;

        try
        {
            if($request->status == 0)
            {   $vendor->auth_token = null;
                if(isset($vendor->fcm_token))
                {
                    $data = [
                        'title' => __('suspended'),
                        'description' => __('Your account has been suspended'),
                        'order_id' => '',
                        'image' => '',
                        'type'=> 'block'
                    ];
                    Helpers::send_push_notif_to_device($vendor->fcm_token, $data);
                    DB::table('user_notifications')->insert([
                        'data'=> json_encode($data),
                        'vendor_id'=>$vendor->id,
                        'created_at'=>now(),
                        'updated_at'=>now()
                    ]);
                }

            }

        }
        catch (\Exception $e) {
            Toastr::warning(__('Push notification faild'));
        }

        Toastr::success(__('restaurant').__('status updated'));
        return back();
    }
    
    public function restaurant_status(Restaurant $restaurant, Request $request)
    {
        if($request->menu == "schedule_order" && !Helpers::schedule_order())
        {
            Toastr::warning(__('schedule order disabled warning'));
            return back();
        }

        if((($request->menu == "delivery" && $restaurant->take_away==0) || ($request->menu == "take_away" && $restaurant->delivery==0)) &&  $request->status == 0 )
        {
            Toastr::warning(__('can not disable both take away and delivery'));
            return back();
        }

        if((($request->menu == "veg" && $restaurant->non_veg==0) || ($request->menu == "non_veg" && $restaurant->veg==0)) &&  $request->status == 0 )
        {
            Toastr::warning(__('Veg non veg disable warning'));
            return back();
        }

        $restaurant[$request->menu] = $request->status;
        $restaurant->save();
        Toastr::success(__('restaurant').__('Settings updated'));
        return back();
    }

    public function discountSetup(Restaurant $restaurant, Request $request)
    {
        $message=__('discount');
        $message .= $restaurant->discount?__('updated_successfully'):__('added successfully');
        $restaurant->discount()->updateOrinsert(
        [
            'restaurant_id' => $restaurant->id
        ],
        [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'min_purchase' => $request->min_purchase != null ? $request->min_purchase : 0,
            'max_discount' => $request->max_discount != null ? $request->max_discount : 0,
            'discount' => $request->discount_type == 'amount' ? $request->discount : $request['discount'],
            'discount_type' => 'percent'
        ]
        );
        return response()->json(['message'=>$message], 200);
    }

    public function updateRestaurantSettings(Restaurant $restaurant, Request $request)
    {
        $request->validate([
            'minimum_order'=>'required',
            'comission'=>'required',
            'tax'=>'required',
            'minimum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
            'maximum_delivery_time' => 'required|regex:/^([0-9]{2})$/|min:2|max:2',
        ]);

        if($request->comission_status)
        {
            $restaurant->comission = $request->comission;
        }
        else{
            $restaurant->comission = null;
        }

        $restaurant->minimum_order = $request->minimum_order;
        $restaurant->opening_time = $request->opening_time;
        $restaurant->closeing_time = $request->closeing_time;
        $restaurant->tax = $request->tax;
        $restaurant->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time;

        $restaurant->save();
        Toastr::success(__('restaurant').__('Settings updated'));
        return back();
    }

    public function update_application(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->id);
        $restaurant->vendor->status = $request->status;
        $restaurant->vendor->save();
        if($request->status) $restaurant->status = 1;
        $restaurant->save();

        Toastr::success(__('Application status updated successfully'));
        return back();
    }

    public function cleardiscount(Restaurant $restaurant)
    {
        $restaurant->discount->delete();
        Toastr::success(__('restaurant').__('Discount cleared'));
        return back();
    }

    public function withdraw()
    {
        $all = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all' ? 1 : 0;
        $active = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved' ? 1 : 0;
        $denied = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied' ? 1 : 0;
        $pending = session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending' ? 1 : 0;

        $withdraw_req =WithdrawRequest::with(['vendor'])
            ->when($all, function ($query) {
                return $query;
            })
            ->when($active, function ($query) {
                return $query->where('approved', 1);
            })
            ->when($denied, function ($query) {
                return $query->where('approved', 2);
            })
            ->when($pending, function ($query) {
                return $query->where('approved', 0);
            })
            ->latest()
            ->paginate(config('default_pagination'));

        return view('admin-views.wallet.withdraw', compact('withdraw_req'));
    }

    public function withdraw_view($withdraw_id, $seller_id)
    {
        $wr = WithdrawRequest::with(['vendor'])->where(['id' => $withdraw_id])->first();
        return view('admin-views.wallet.withdraw-view', compact('wr'));
    }

    public function status_filter(Request $request){
        session()->put('withdraw_status_filter',$request['withdraw_status_filter']);
        return response()->json(session('withdraw_status_filter'));
    }

    public function withdrawStatus(Request $request, $id)
    {
        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->approved = $request->approved;
        $withdraw->transaction_note = $request['note'];
        if ($request->approved == 1) {
            RestaurantWallet::where('vendor_id', $withdraw->vendor_id)->increment('total_withdrawn', $withdraw->amount);
            RestaurantWallet::where('vendor_id', $withdraw->vendor_id)->decrement('pending_withdraw', $withdraw->amount);
            $withdraw->save();
            Toastr::success(__('Seller payment approved'));
            return redirect()->route('admin.vendor.withdraw_list');
        } else if ($request->approved == 2) {
            RestaurantWallet::where('vendor_id', $withdraw->vendor_id)->decrement('pending_withdraw', $withdraw->amount);
            $withdraw->save();
            Toastr::info(__('Seller payment denied'));
            return redirect()->route('admin.vendor.withdraw_list');
        } else {
            Toastr::error(__('Not found'));
            return back();
        }
    }

    public function get_addons(Request $request)
    {
        $cat = AddOn::withoutGlobalScope(RestaurantScope::class)->withoutGlobalScope('translate')->where(['restaurant_id' => $request->restaurant_id])->active()->get();
        $res = '';
        foreach ($cat as $row) {
            $res .= '<option value="' . $row->id.'"';
            if(count($request->data))
            {
                $res .= in_array($row->id, $request->data)?'selected':'';
            }
            $res .=  '>' . $row->name . '</option>';
        }
        return response()->json([
            'options' => $res,
        ]);
    }

    public function get_restaurant_data(Restaurant $restaurant)
    {
        return response()->json($restaurant);
    }

    public function restaurant_filter($id)
    {
        if ($id == 'all') {
            if (session()->has('restaurant_filter')) {
                session()->forget('restaurant_filter');
            }
        } else {
            session()->put('restaurant_filter', Restaurant::where('id', $id)->first(['id', 'name']));
        }
        return back();
    }

    public function get_account_data(Restaurant $restaurant)
    {
        $wallet = $restaurant->vendor->wallet;
        $cash_in_hand = 0;
        $balance = 0;

        if($wallet)
        {
            $cash_in_hand = $wallet->collected_cash;
            $balance = $wallet->total_earning - $wallet->total_withdrawn - $wallet->pending_withdraw - $wallet->collected_cash;
        }
        return response()->json(['cash_in_hand'=>$cash_in_hand, 'earning_balance'=>$balance], 200);

    }

    public function bulk_import_index()
    {
        return view('admin-views.vendor.bulk-import');
    }

    public function bulk_import_data(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('products_file'));
        } catch (\Exception $exception) {
            Toastr::error(__('you have uploaded a wrong format file'));
            return back();
        }
        $duplicate_phones = $collections->duplicates('phone');
        $duplicate_emails = $collections->duplicates('email');
        
        // dd(['Phone'=>$duplicate_phones, 'Email'=>$duplicate_emails]);
        if($duplicate_emails->isNotEmpty())
        {
            Toastr::error(__('Duplicate data on column',['field'=>__('email')]));
            return back();
        }

        if($duplicate_phones->isNotEmpty())
        {
            Toastr::error(__('Duplicate data on column',['field'=>__('phone')]));
            return back();
        }

        $vendors = [];
        $restaurants = [];
        $vendor = Vendor::orderBy('id', 'desc')->first('id');
        $vendor_id = $vendor?$vendor->id:0;
        foreach ($collections as $key=>$collection) {
                if ($collection['ownerFirstName'] === "" || $collection['restaurantName'] === "" || $collection['phone'] === "" || $collection['email'] === "" || $collection['latitude'] === "" || $collection['longitude'] === "" || empty($collection['openingTime']) === "" || empty($collection['closeingTime']) || $collection['zone_id'] === "") {
                    Toastr::error(__('please fill all required fields'));
                    return back();
                }


            array_push($vendors, [
                'id'=>$vendor_id+$key+1,
                'f_name' => $collection['ownerFirstName'],
                'l_name' => $collection['ownerLastName'],
                'password' => bcrypt(12345678),
                'phone' => $collection['phone'],
                'email' => $collection['email'],
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            array_push($restaurants, [
                'name' => $collection['restaurantName'],
                'logo' => $collection['logo'],
                'phone' => $collection['phone'],
                'email' => $collection['email'],
                'latitude' => $collection['latitude'],
                'longitude' => $collection['longitude'],
                'opening_time' => $collection['openingTime'],
                'closeing_time' => $collection['closeingTime'],
                'vendor_id' => $vendor_id+$key+1,
                'zone_id' => $collection['zone_id'],
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
        try{
            DB::beginTransaction();
            DB::table('vendors')->insert($vendors);
            DB::table('restaurants')->insert($restaurants);
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollBack();
            info($e);
            Toastr::error(__('Failed to import data'));
            return back();
        }

        Toastr::success(__('restaurant imported successfully',['count'=>count($restaurants)]));
        return back();
    }

    public function bulk_export_index()
    {
        return view('admin-views.vendor.bulk-export');
    }

    public function bulk_export_data(Request $request)
    {
        $request->validate([
            'type'=>'required',
            'start_id'=>'required_if:type,id_wise',
            'end_id'=>'required_if:type,id_wise',
            'from_date'=>'required_if:type,date_wise',
            'to_date'=>'required_if:type,date_wise'
        ]);
        $vendors = Vendor::with('restaurants')
        ->when($request['type']=='date_wise', function($query)use($request){
            $query->whereBetween('created_at', [$request['from_date'].' 00:00:00', $request['to_date'].' 23:59:59']);
        })
        ->when($request['type']=='id_wise', function($query)use($request){
            $query->whereBetween('id', [$request['start_id'], $request['end_id']]);
        })
        ->get();
        return (new FastExcel(RestaurantLogic::format_export_restaurants($vendors)))->download('Restaurants.xlsx');
    }

    public function add_schedule(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start_time'=>'required|date_format:H:i',
            'end_time'=>'required|date_format:H:i|after:start_time',
            'restaurant_id'=>'required',
        ],[
            'end_time.after'=>__('End time must be after the start time')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $temp = RestaurantSchedule::where('day', $request->day)->where('restaurant_id',$request->restaurant_id)
        ->where(function($q)use($request){
            return $q->where(function($query)use($request){
                return $query->where('opening_time', '<=' , $request->start_time)->where('closing_time', '>=', $request->start_time);
            })->orWhere(function($query)use($request){
                return $query->where('opening_time', '<=' , $request->end_time)->where('closing_time', '>=', $request->end_time);
            });
        })
        ->first();

        if(isset($temp))
        {
            return response()->json(['errors' => [
                ['code'=>'time', 'message'=>__('Schedule overlapping warning')]
            ]]);
        }

        $restaurant = Restaurant::find($request->restaurant_id);
        $restaurant_schedule = RestaurantSchedule::insert(['restaurant_id'=>$request->restaurant_id,'day'=>$request->day,'opening_time'=>$request->start_time,'closing_time'=>$request->end_time]);
        
        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('restaurant'))->render(),
        ]);
    }

    public function remove_schedule($restaurant_schedule)
    {
        $schedule = RestaurantSchedule::find($restaurant_schedule);
        if(!$schedule)
        {
            return response()->json([],404);
        }
        $restaurant = $schedule->restaurant;
        $schedule->delete();
        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('restaurant'))->render(),
        ]);
    }
}
