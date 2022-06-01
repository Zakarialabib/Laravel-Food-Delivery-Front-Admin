<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantSchedule;
use App\Models\Currency;
use App\Models\BusinessSetting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\Validator;

class BusinessSettingsController extends Controller
{

    private $restaurant;

    public function restaurant_index()
    {
        $restaurant = Helpers::get_restaurant_data();
        return view('vendor-views.business-settings.restaurant-index', compact('restaurant'));
    }

    public function restaurant_setup(Restaurant $restaurant, Request $request)
    {
        $request->validate([
            'gst' => 'required_if:gst_status,1',
        ], [
            'gst.required_if' => __('Gst can not be empty'),
        ]);

        $off_day = $request->off_day?implode('',$request->off_day):'';
        $restaurant->minimum_order = $request->minimum_order;
        $restaurant->opening_time = $request->opening_time;
        $restaurant->closeing_time = $request->closeing_time;
        $restaurant->off_day = $off_day;
        $restaurant->gst = json_encode(['status'=>$request->gst_status, 'code'=>$request->gst]);
        $restaurant->delivery_charge = $restaurant->self_delivery_system?$request->delivery_charge??0: $restaurant->delivery_charge;
        $restaurant->save();
        Toastr::success(__('Restaurant settings updated'));
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
        Toastr::success(__('Restaurant settings updated!'));
        return back();
    }

    public function active_status(Request $request)
    {
        $restaurant = Helpers::get_restaurant_data();
        $restaurant->active = $restaurant->active?0:1;
        $restaurant->save();
        return response()->json(['message' => $restaurant->active?__('Restaurant opened'):__('Restaurant temporarily closed')], 200);
    }

    public function add_schedule(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start_time'=>'required|date_format:H:i',
            'end_time'=>'required|date_format:H:i|after:start_time',
        ],[
            'end_time.after'=>__('End time must be after the start time')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        $temp = RestaurantSchedule::where('day', $request->day)->where('restaurant_id',Helpers::get_restaurant_id())
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

        $restaurant = Helpers::get_restaurant_data();
        $restaurant_schedule = RestaurantSchedule::insert(['restaurant_id'=>Helpers::get_restaurant_id(),'day'=>$request->day,'opening_time'=>$request->start_time,'closing_time'=>$request->end_time]);
        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('restaurant'))->render(),
        ]);
    }

    public function remove_schedule($restaurant_schedule)
    {
        $restaurant = Helpers::get_restaurant_data();
        $schedule = RestaurantSchedule::where('restaurant_id', $restaurant->id)->find($restaurant_schedule);
        if(!$schedule)
        {
            return response()->json([],404);
        }
        $schedule->delete();
        return response()->json([
            'view' => view('admin-views.vendor.view.partials._schedule', compact('restaurant'))->render(),
        ]);
    }
}
