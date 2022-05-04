<?php

namespace App\Http\Controllers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\CentralLogics\RestaurantLogic;
use App\Rules\MatchOldPassword;
use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use App\Models\Cuisine;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Zone;
use Carbon\Carbon;
use Session;
Use PDF;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class FrontController extends Controller
{
    
    //
    public function index(){

        $restaurants = Restaurant::orderBy("order_count", 'desc')
        ->take(6)
        ->get();

        $top_sell = Food::withoutGlobalScopes()
            ->orderBy("order_count", 'desc')
            ->take(6)
            ->get();


        return view('front.index', compact('restaurants','top_sell'));
    }
  
    public function aboutus(){
        return view('front.aboutus');
    }
    public function contact(){
        return view('front.contact');
    }

    public function myaccount(User $customer,Request $request)
    {
        $customer = Auth::user();

        // $request->session()->forget('address');
        
        $request->session()->forget('cartsession');
        
        return view('front.my_account',['customer'=>$customer]);   
    }
    
    public function account(User $customer)
    {
        $customer = Auth::user();
        // dd($customer);
        return view('front.my_account', compact('customer'));
    }

    public function profile_update(Request $request,$id){
        $customer=User::findorFail($id);
        $customer->first_name=$request->first_name;
        $customer->last_name=$request->last_name;
        $customer->mobile=$request->mobile;
        $customer->email=$request->email;
        $save=$customer->save();
        if($save){
            return back()->with('success','Account Details Updated Successfully.');  
        }
        else{
            return back()->with('fail','Something went wrong');  

        }

    }
    
    ///////////Change Password///////////////
    public function show_password(){
        return view('front.change_password');
    }

    public function change_password(Request $request) {  
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return back()->with('success','Password Updated Successfully.');
    }
    /////////////Address///////////////////
    public function address(CustomerAddress $address)
    {
        $address = CustomerAddress::all();
        return view('front.address',['address'=>$address]);
    }

    public function address_store()
    {
   
        $inputs = request()->validate([
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ],[
            'contact_person_name.required' => 'Name is required',
            'address_type.required' =>'Adresse type is required',
            'contact_person_number.required' =>'Phone number is required',
            'address.required' =>'Address is required',
            'longitude.required' =>'Longitude is required',
            'latitude.required' =>'Latitude is required',
        ]);
        
        $zone = Zone::contains('coordinates', $point)->first();
        $point = new Point($request->latitude,$request->longitude);

        $address = new CustomerAddress;
        $address->contact_person_name=$inputs['contact_person_name'];
        $address->contact_person_number=$inputs['contact_person_number'];
        $address->address_type=$inputs['address_type'];
        $address->address=$inputs['address'];
        $address->longitude=$inputs['longitude'];
        $address->latitude=$inputs['latitude'];
        $address->zone_id = $zone->id;
        
        $address->save();

        return back();
        
    }
    public function default(Request $request,$id){
       
        $address=CustomerAddress::find($id);
       
        CustomerAddress::where('default', 1)->update(['default' => 0]);
        
        CustomerAddress::where('id', $request->id)->update(['default' => 1]);
        return back();

    }

    public function removedefault($id){

    $inputs=request()->validate([
        'default'=>['sometimes', 'in:1,0'],
    ]);
    $address=CustomerAddress::find($id);
    $address->default=0;
        
    $address->save();
    return back();

    }
      

    public function edit_address($id){
        $address=CustomerAddress::find($id);
        
        return view('front.address',compact('address'));

    }
    public function update_address(Request $request, $id){
        $inputs=request()->validate([
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        
        ],[
            'contact_person_name.required' => 'Name is required',
            'address_type.required' =>'Adresse type is required',
            'contact_person_number.required' =>'Phone number is required',
            'address.required' =>'Address is required',
            'longitude.required' =>'Longitude is required',
            'latitude.required' =>'Latitude is required',

        ]);
        $address = CustomerAddress::find($id);
        $address->contact_person_name=$inputs['contact_person_name'];
        $address->contact_person_number=$inputs['contact_person_number'];
        $address->address_type=$inputs['address_type'];
        $address->address=$inputs['address'];
        $address->longitude=$inputs['longitude'];
        $address->latitude=$inputs['latitude'];

        $address->update();
        return back();
    }

    public function address_destroy($id){
        $address=CustomerAddress::find($id);
        $address->delete();
        return back();
    }

    
    public function restaurant_listing()
    {    
        $restaurant = Restaurant::where('status', 1)->paginate(10);
     
        // dd($restaurant);
     
        return view('front.restaurant_listing',['restaurants'=>$restaurant]);
    }
    public function search(Request $request)
    {    
        // $search_text = $request->location;
        
        $point = new Point($request->latitude, $request->longitude);
        $zone = Zone::contains('coordinates', $point)->first();
       
        // $type = $this->query('type', 'all');
        // $zone_id = $request->header('zoneId');
        
        $rest = Restaurant::where('name','LIKE','%'.$postcode.'%')
                            ->orWhere('zone_id', $zone_id)
                            ->get();

        return view('front.restaurant_listing',['restaurants'=>$rest],compact('zone_id','search_text'));
    }


     //////////////Add to Cart///////////////
     public function cart()
    {
       
            return view('front.cart');
        
    }
     
    public function addToCart($id)
    {
        $itemfoods = Food::findOrFail($id);
           
        $cart = session()->get('cart', []);
        $cartsession = session()->get('cartsession', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "food_item" => $itemfoods->food_item,
                "quantity" => 1,
                "rate" => $itemfoods->rate,
            ];
        }
          
        session()->put('cart', $cart);
        if(isset($cartsession[$id])) {
            $cartsession[$id]['quantity']++;
        } else {
            $cartsession[$id] = [
                "id"=>$itemfoods->id,
                "food_item" => $itemfoods->food_item,
                "quantity" => 1,
                "rate" => $itemfoods->rate,
            ];
        }
        
        session()->put('cartsession', $cartsession);
        dd($cartsession);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
        

    }
    public function removeFromCart($id){
        $itemfoods = Food::findOrFail($id);
           
        if(isset($cart[$id]) && $cart[$id]['quantity'] > "1") {
            $cart[$id]['quantity']--;
        } 
        elseif($itemId== 1){
           
                unset($cart[$id]);
            }
        
        
        else {
            $cart[$id] = [
                "id"=>$itemfoods->id,
                "food_item" => $itemfoods->food_item,
                "quantity" => 1,
                "rate" => $itemfoods->rate,
            
                
            ];
        }
          
        session()->put('cart', $cart);
        if(isset($cartsession[$id]) && $cartsession[$id]['quantity'] > "1") {
            $cartsession[$id]['quantity']--;
        } 
        elseif($itemId== 1){
           
                unset($cartsession[$id]);
            }
        
        
        else {
            $cartsession[$id] = [
                "id"=>$itemfoods->id,
                "food_item" => $itemfoods->food_item,
                "quantity" => 1,
                "rate" => $itemfoods->rate,
            
                
            ];
        }
        session()->put('cartsession', $cartsession);
        return redirect()->back()->with('success', 'Product added to cart successfully!');

    }
    public function cartDelete(Request $request,$id)
    {
        
            $cart = session()->get('cart');
            
            unset($cart[$id]);
            session()->put('cart', $cart);
           
            session()->flash('success', 'Product removed successfully');
        
    }
    public function cart2(){

       
            return view('front.cart2');
            
        

    }
    public function emptycart(){
        return view('front.emptycart');
    }
    public function restaurant_details($id,Request $request)
    {

    $itemfoods=Food::all();
    $restaurant = Restaurant::find($id);
    // dd($restaurant);
    $data=$request->session()->put(['restaurant'=>['restaurant'=>$id,'name'=>$restaurant->name,'location'=>$restaurant->location,
    'addess'=>$restaurant->address,'mobile'=>$restaurant->mobile]]);  
    $rest=$request->session()->get('restaurant');

        
        
    return view('front.restaurant_details', ['restaurant'=>$restaurant], compact('itemfoods'));

    }

    public function checkout(Restaurant $restaurant,Request $request){
        $rest=$request->session()->get('restaurant');
        
        $cartsession=session()->get('cartsession',[]);
         
        $address=CustomerAddress::where('customer_id',auth()->user()->id)->get();
        $itemfoods=Food::all();
        $restaurant=Restaurant::all();
        
        // session()->put('rest',$rest);
        
        return view('front.checkout',compact('itemfoods','address'));
       
    }
     public function order(orderStore $order,$id){
        $order=Order::findOrFail($id);
        
         return view('front.order',['order'=>$order]);
     }
     public function order_tracking(Order $order,Request $request){
         
        //  $store=session()->get('address');
        
       
        $cartsession=session()->get('cartsession');
        $request->session()->forget('cart');
        $request->session()->forget('address');
           
         return view('front.order_tracking',['Order'=>$order],compact('order'));
         
        // $request->session()->forget('cart');
       
        // return redirect('/customer/my_home');
        
     }

     public function addressStore($id,Request $request)
     {
         $address = CustomerAddress::findOrFail($id);
            // dd($address->default);
        //  $store = session()->get('store');
        
         $data=$request->session()->put(['address'=>['id'=>$id,'location'=>$address->location,'home'=>$address->home,
         'house_name'=>$address->house_name,'area'=>$address->area,'pincode'=>$address->pincode,'city'=>$address->city]]);  
         $store=$request->session()->get('address');         
            
         return redirect()->back()->with('success', 'Address selected successfully!');
     }

     public function orderStore(Order $order,Request $request,Address $address){
        
       
        // $address=Address::where('customer_id',auth()->user()->id)->get();
        $address=CustomerAddress::where('default','1')->first();
       
        $store=session()->get('address');
        $cart = session()->get('cart', []);
        
        $rest=session()->get('restaurant');
        // dd($store);
       
        // $rest=$request->session()->get('restaurant');
    
        $inputs=request()->validate([
            'delivery_method'=>'required',]);
        
        
        $address_id=0;
        if($request->delivery_method == "delivery") {
        
         $address_id=isset($store['id']) ? $store['id'] : ($address->id);
        }
      dd($address_id);
        
        $restaurant_id=null;
        $restaurant_id=$rest['restaurant'];
       
        // foreach($rest as $restaurant){
        //     $restaurant_id=$restaurant['id'];
        // }
        
        $total=0;
        
            
        foreach($cart as $cartitems){
                $total +=($cartitems['rate'] * $cartitems['quantity']);       
        }
       
        $customer=Auth::user()->id;
       $customer1=Auth::user()->mobile;
        $order->order_date=Carbon::now();
        $order->mobile=$customer1;
        $order->item_total=$total;
        $order->sub_total=$total;
        $order->grand_total=$total;
        $order->address_id=$address_id;
        $order->order_type=$inputs['delivery_method'];
        $order->order_status='pending';
        $order->payment_status='pending';
        $order->payment_method='cash on delivery';
        $order->customer_id=$customer;
        $order->restaurant_id=$restaurant_id;
        
        // dd($cid);
        // dd($quantity);
        $order->save();
        
        $cartid=array();
        foreach($cart as $cartItem){
            array_push($cartid,$cartItem);
            $cid=$cartItem['id'];
            $quantity=$cartItem['quantity'];
            $name=$cartItem['food_item'];
            $order->itemfoods()->attach($cid,['quantity'=>$quantity,'food_item'=>$name]);
            
        }    
        
        return view('front.order',['Order' => $order],compact('order'));
        

     }
     public function order_history(Order $order){
         $order = Order::orderBy('created_at', 'DESC')->where('user_id',auth()->user()->id)->get();
         
         $itemfoods = Food::all();
         return view('front.orderhistory',['order'=>$order],compact('itemfoods'));
     }


     public function downloadPDF(Order $order,Request $request){
       
        
        $pdf = PDF::loadView('front.order_download',['Order' => $order],compact('order'))->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->download('order_download.pdf');
       
    }

    public function changeLanguage($locale)
    {
        Session::put('language_code', $locale);
        $language = Session::get('language_code');

        return redirect()->back();
    }

            
}