<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Currency;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConfigController extends Controller
{
    private $map_api_key;
    
    function __construct() 
    {
        $map_api_key_server=BusinessSetting::where(['key'=>'map_api_key_server'])->first();
        $map_api_key_server=$map_api_key_server?$map_api_key_server->value:null;
        $this->map_api_key = $map_api_key_server;
    }

    public function configuration()
    {
        $currency_symbol = Currency::where(['currency_code' => Helpers::currency_code()])->first()->currency_symbol;
        $cod = json_decode(BusinessSetting::where(['key' => 'cash_on_delivery'])->first()->value, true);
        $digital_payment = json_decode(BusinessSetting::where(['key' => 'digital_payment'])->first()->value, true);
        $default_location=\App\Models\BusinessSetting::where('key','default_location')->first();
        $default_location=$default_location->value?json_decode($default_location->value, true):0;
        $free_delivery_over = BusinessSetting::where('key', 'free_delivery_over')->first()->value;
        $free_delivery_over = $free_delivery_over?(float)$free_delivery_over:$free_delivery_over;
        $languages = Helpers::get_business_settings('language');
        $lang_array = [];
        foreach ($languages as $language) {
            array_push($lang_array, [
                'key' => $language,
                'value' => Helpers::get_language_name($language)
            ]);
        }
        // $social_login = [];
        // foreach (Helpers::get_business_settings('social_login') as $social) {
        //     $config = [
        //         'login_medium' => $social['login_medium'],
        //         'status' => (boolean)$social['status']
        //     ];
        //     array_push($social_login, $config);
        // }
        $dp = json_decode(BusinessSetting::where(['key' => 'digital_payment'])->first()->value, true);
        return response()->json([
            'business_name' => BusinessSetting::where(['key' => 'business_name'])->first()->value,
            // 'business_open_time' => BusinessSetting::where(['key' => 'business_open_time'])->first()->value,
            // 'business_close_time' => BusinessSetting::where(['key' => 'business_close_time'])->first()->value,
            'logo' => BusinessSetting::where(['key' => 'logo'])->first()->value,
            'address' => BusinessSetting::where(['key' => 'address'])->first()->value,
            'phone' => BusinessSetting::where(['key' => 'phone'])->first()->value,
            'email' => BusinessSetting::where(['key' => 'email_address'])->first()->value,
            // 'restaurant_location_coverage' => Branch::where(['id'=>1])->first(['longitude','latitude','coverage']),
            // 'minimum_order_value' => (float)BusinessSetting::where(['key' => 'minimum_order_value'])->first()->value,
            'base_urls' => [
                'product_image_url' => asset('storage/app/public/product'),
                'customer_image_url' => asset('storage/app/public/profile'),
                'banner_image_url' => asset('storage/app/public/banner'),
                'category_image_url' => asset('storage/app/public/category'),
                'review_image_url' => asset('storage/app/public/review'),
                'notification_image_url' => asset('storage/app/public/notification'),
                'restaurant_image_url' => asset('storage/app/public/restaurant'),
                'vendor_image_url' => asset('storage/app/public/vendor'),
                'restaurant_cover_photo_url' => asset('storage/app/public/restaurant/cover'),
                'delivery_man_image_url' => asset('storage/app/public/delivery-man'),
                'chat_image_url' => asset('storage/app/public/conversation'),
                'campaign_image_url' => asset('storage/app/public/campaign'),
                'business_logo_url' => asset('storage/app/public/business')
            ],
            'country' => BusinessSetting::where(['key' => 'country'])->first()->value,
            'default_location'=> [ 'lat'=> $default_location?$default_location['lat']:'23.757989', 'lng'=> $default_location?$default_location['lng']:'90.360587' ],
            'currency_symbol' => $currency_symbol,
            'currency_symbol_direction' => BusinessSetting::where(['key' => 'currency_symbol_position'])->first()->value,
            'app_minimum_version_android' => (integer)BusinessSetting::where(['key' => 'app_minimum_version_android'])->first()->value,
            'app_url_android' => BusinessSetting::where(['key' => 'app_url_android'])->first()->value,
            'app_minimum_version_ios' => (integer)BusinessSetting::where(['key' => 'app_minimum_version_ios'])->first()->value,
            'app_url_ios' => BusinessSetting::where(['key' => 'app_url_ios'])->first()->value,
            'customer_verification' => (boolean)BusinessSetting::where(['key' => 'customer_verification'])->first()->value,
            'schedule_order' => (boolean)BusinessSetting::where(['key' => 'schedule_order'])->first()->value,
            'order_delivery_verification' => (boolean)BusinessSetting::where(['key' => 'order_delivery_verification'])->first()->value,
            'cash_on_delivery' => (boolean)($cod['status'] == 1 ? true : false),
            'digital_payment' => (boolean)($digital_payment['status'] == 1 ? true : false),
            'terms_and_conditions' => BusinessSetting::where(['key' => 'terms_and_conditions'])->first()->value,
            'privacy_policy' => BusinessSetting::where(['key' => 'privacy_policy'])->first()->value,
            'about_us' => BusinessSetting::where(['key' => 'about_us'])->first()->value,
            'per_km_shipping_charge' => (double)BusinessSetting::where(['key' => 'per_km_shipping_charge'])->first()->value,
            'minimum_shipping_charge' => (double)BusinessSetting::where(['key' => 'minimum_shipping_charge'])->first()->value,
            'free_delivery_over'=>$free_delivery_over,
            'demo'=>(boolean)(env('APP_MODE')=='demo'?true:false),
            'maintenance_mode' => (boolean)Helpers::get_business_settings('maintenance_mode') ?? 0,
            'order_confirmation_model'=>config('order_confirmation_model'),
            'popular_food' => (double)BusinessSetting::where(['key' => 'popular_food'])->first()->value,
            'popular_restaurant' => (double)BusinessSetting::where(['key' => 'popular_restaurant'])->first()->value,
            'new_restaurant' => (double)BusinessSetting::where(['key' => 'new_restaurant'])->first()->value,
            'most_reviewed_foods' => (double)BusinessSetting::where(['key' => 'most_reviewed_foods'])->first()->value,
            'show_dm_earning' => (boolean)BusinessSetting::where(['key' => 'show_dm_earning'])->first()->value,
            'canceled_by_deliveryman' => (boolean)BusinessSetting::where(['key' => 'canceled_by_deliveryman'])->first()->value,
            'canceled_by_restaurant' => (boolean)BusinessSetting::where(['key' => 'canceled_by_restaurant'])->first()->value,
            'timeformat' => (string)BusinessSetting::where(['key' => 'timeformat'])->first()->value,
            'language' => $lang_array,
            // 'social_login' => $social_login,
            'toggle_veg_non_veg' => (boolean)BusinessSetting::where(['key' => 'toggle_veg_non_veg'])->first()->value,
            'toggle_dm_registration' => (boolean)BusinessSetting::where(['key' => 'toggle_dm_registration'])->first()->value,
            'toggle_restaurant_registration' => (boolean)BusinessSetting::where(['key' => 'toggle_restaurant_registration'])->first()->value,
            'schedule_order_slot_duration' => (int)BusinessSetting::where(['key' => 'schedule_order_slot_duration'])->first()->value,
            'digit_after_decimal_point' => (int)config('round_up_to_digit'),
        ]);
    }

    public function get_zone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $point = new Point($request->lat,$request->lng);
        $zones = Zone::contains('coordinates', $point)->latest()->get();
        if(count($zones)<1)
        {
            return response()->json([
                'errors'=>[
                    ['code'=>'coordinates','message'=>trans('messages.service_not_available_in_this_area')]
                ]
            ], 404);
        }
        foreach($zones as $zone)
        {
            if($zone->status)
            {
                return response()->json(['zone_id'=>$zone->id], 200);
            }
        }
        return response()->json([
            'errors'=>[
                ['code'=>'coordinates','message'=>trans('messages.we_are_temporarily_unavailable_in_this_area')]
            ]
        ], 403);
    }

    public function place_api_autocomplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.$request['search_text'].'&key='.$this->map_api_key);
        return $response->json();
    }


    public function distance_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$request['origin_lat'].','.$request['origin_lng'].'&destinations='.$request['destination_lat'].','.$request['destination_lng'].'&key='.$this->map_api_key.'&mode=walking');
        return $response->json();
    }


    public function place_api_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placeid' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$request['placeid'].'&key='.$this->map_api_key);
        return $response->json();
    }
    
    public function geocode_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$request->lat.','.$request->lng.'&key='.$this->map_api_key);
        return $response->json();
    }
}
