<?php

namespace App\Http\Controllers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\CentralLogics\RestaurantLogic;
use App\Rules\MatchOldPassword;
use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\CustomerAddress;
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
    public function home(){
        
        return view('front.download');
    }
  
    public function aboutus()
    {
        return view('front.aboutus');
    }
    
    public function contact()
    {
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

    public function profile_update(Request $request,$id)
    {    
        $customer = User::findorFail($id);
        $customer->first_name=$request->first_name;
        $customer->last_name=$request->last_name;
        $customer->phone=$request->phone;
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

    ///////////// Customer Address///////////////////
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
    public function default(Request $request,$id)
    {   
        $address = CustomerAddress::find($id);
       
        CustomerAddress::where('default', 1)->update(['default' => 0]);
        
        CustomerAddress::where('id', $request->id)->update(['default' => 1]);
        return back();
    }

    public function removedefault($id)
    {
        $inputs = request()->validate([
            'default'=>['sometimes', 'in:1,0'],
        ]);
        $address = CustomerAddress::find($id);
        $address->default=0;
            
        $address->save();
        return back();
    }
      

    public function edit_address($id)
    {
        $address = CustomerAddress::find($id);
        
        return view('front.address',compact('address'));
    }

    public function update_address(Request $request, $id)
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

    public function address_destroy($id)
    {
        $address=CustomerAddress::find($id);
    
        $address->delete();
    
        return back();
    }

   
     ////////////// Home Search ///////////////

    public function search(Request $request)
    {    
        // $search_text = $request->location;
        
        $point = new Point($request->latitude, $request->longitude);
        $zone = Zone::contains('coordinates', $point)->first();

        $zone_id = $zone->id;
        $search_text = $request->search_text;
       
        // $type = $this->query('type', 'all');
        // $zone_id = $request->header('zoneId');
        $categories = Category::where(['position'=>0])->latest()->get();
        
        $rest = Restaurant::where('name','LIKE','%'.$search_text.'%')
                            ->orWhere('zone_id', $zone_id)
                            ->paginate(30);

        return view('front.restaurant_listing',[
            'restaurants'=>$rest,
            'categories'=>$categories,
        ],compact('zone_id','search_text'));
    }
     ////////////// Restaurant List ///////////////
     public function restaurant_listing()
     {    
         $itemfoods = Food::all();

         $restaurant = Restaurant::where('status', 1)->paginate(10);
      
         $categories = Category::where(['position'=>0])->latest()->get();
      
         return view('front.restaurant_listing',
                    [
                    'restaurants'=>$restaurant,
                    'categories'=>$categories,
                    ]);
     }
     public function restaurant_details($id,Request $request)
     {
         $restaurant = Restaurant::find($id);
         
 
         $category = $request->query('category_id', 0);
        // $sub_category = $request->query('sub_category', 0);
        $categories = Category::active()->get();
        $keyword = $request->query('keyword', false);
        $key = explode(' ', $keyword);
        $products = Food::withoutGlobalScope(\App\Scopes\RestaurantScope::class)
        ->where('restaurant_id', $restaurant->id)
        ->when($category, function($query)use($category){
            $query->whereHas('category',function($q)use($category){
                return $q->whereId($category)->orWhere('parent_id', $category);
            });
        })
        ->when($keyword, function($query)use($key){
            return $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        })->latest()->paginate(10);
 
         return view('front.restaurant_details', compact('categories', 'products','category', 'keyword','restaurant'));
     }

     //////////////Add to Cart///////////////
     public function cart()
    {
        return view('front.cart');   
    }

    public function quick_view(Request $request)
    {
        $product = Food::findOrFail($request->product_id);

        return response()->json([
            'success' => 1,
            'view' => view('front.quickview', compact('product'))->render(),
        ]);
    }
    public function quick_view_card_item(Request $request)
    {
        $product = Food::findOrFail($request->product_id);
        $item_key = $request->item_key;
        $cart_item = session()->get('cart')[$item_key];
        
        return response()->json([
            'success' => 1,
            'view' => view('front.quick-view-cart-item', compact('product', 'cart_item', 'item_key'))->render(),
        ]);
    }

    public function add_to_cart(Request $request)
    {
        $product = Food::find($request->id);

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $variations = [];
        $price = 0;
        $addon_price = 0;

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode($product->choice_options) as $key => $choice) {
            $data[$choice->name] = $request[$choice->name];
            $variations[$choice->title] = $request[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }
        $data['variations'] = $variations;
        $data['variant'] = $str;
        if ($request->session()->has('cart') && !isset($request->cart_item_key)) {
            if (count($request->session()->get('cart')) > 0) {
                foreach ($request->session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $request['id'] && $cartItem['variant'] == $str) {
                        return response()->json([
                            'data' => 1
                        ]);
                    }
                }

            }
        }
        //Check the string and decreases quantity for the stock
        if ($str != null) {
            $count = count(json_decode($product->variations));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variations)[$i]->type == $str) {
                    $price = json_decode($product->variations)[$i]->price;
                }
            }
        } else {
            $price = $product->price;
        }

        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['name'] = $product->name;
        $data['discount'] = Helpers::product_discount_calculate($product, $price,Helpers::get_restaurant_data());
        $data['image'] = $product->image;
        $data['add_ons'] = [];
        $data['add_on_qtys'] = [];
        
        if($request['addon_id'])
        {
            foreach($request['addon_id'] as $id)
            {
                $addon_price+= $request['addon-price'.$id]*$request['addon-quantity'.$id];
                $data['add_on_qtys'][]=$request['addon-quantity'.$id];
            } 
            $data['add_ons'] = $request['addon_id'];
        }

        $data['addon_price'] = $addon_price;
        
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            if(isset($request->cart_item_key))
            {
                $cart[$request->cart_item_key] = $data;
                $data = 2;
            }
            else
            {
                $cart->push($data);
            }

        } else {
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function removeFromCart($id)
    {
        $itemfoods = Food::findOrFail($id);
           
        if(isset($cart[$id]) && $cart[$id]['quantity'] > "1") {
            $cart[$id]['quantity']--;
        } elseif($itemId== 1){
            unset($cart[$id]);
        } else {
            $cart[$id] = [
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "price" => $itemfoods->price,
            ];
        }
          
        session()->put('cart', $cart);
        if(isset($cartsession[$id]) && $cartsession[$id]['quantity'] > "1") {
            $cartsession[$id]['quantity']--;
        } elseif($itemId== 1){
            unset($cartsession[$id]);
        } else {
            $cartsession[$id] = [
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "price" => $itemfoods->price,
            ];
        }
        session()->put('cartsession', $cartsession);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
   //removes from Cart
   public function remove_from_cart(Request $request)
   {
       if ($request->session()->has('cart')) {
           $cart = $request->session()->get('cart', collect([]));
           $cart->forget($request->key);
           $request->session()->put('cart', $cart);
       }

       return response()->json([],200);
   }

   //updated the quantity for a cart item
   public function updateQuantity(Request $request)
   {
       $cart = $request->session()->get('cart', collect([]));
       $cart = $cart->map(function ($object, $key) use ($request) {
           if ($key == $request->key) {
               $object['quantity'] = $request->quantity;
           }
           return $object;
       });
       $request->session()->put('cart', $cart);
       return response()->json([],200);
   }
   
     //empty Cart
     public function empty_cart(Request $request)
     {
         session()->forget('cart');
         return response()->json([],200);
     }
 
    public function cartDelete(Request $request,$id)
    {
        $cart = session()->get('cart');
        
        unset($cart[$id]);
        session()->put('cart', $cart);
        
        session()->flash('success', 'Product removed successfully');
    }

    public function cart2()
    {
        return view('front.cart2');       
    }

    public function emptycart()
    {
        return view('front.emptycart');
    }


    public function checkout(Restaurant $restaurant,Request $request)
    {
        $rest = $request->session()->get('restaurant');
        
        $cartsession = session()->get('cartsession',[]);
         
        $address = CustomerAddress::where('user_id',auth()->user()->id)->get();
        $itemfoods = Food::all();
        $restaurant = Restaurant::all();
        
        return view('front.checkout',compact('itemfoods','address'));
    }

     public function order(orderStore $order,$id)
     {
        $order = Order::findOrFail($id);
        
         return view('front.order',['order'=>$order]);
     }

     public function order_tracking(Order $order,Request $request)
     {
       
        $cartsession = session()->get('cartsession');
        $request->session()->forget('cart');
        $request->session()->forget('address');
           
         return view('front.order_tracking', compact('order'), ['Order'=>$order]);
     }

     public function addressStore($id,Request $request)
     {
         $address = CustomerAddress::findOrFail($id);
        
         $data = $request->session()->put(['address'=>[
            'id'=>$id,
            'location'=>$address->location,
             'home'=>$address->home,
             'house_name'=>$address->house_name,
            'area'=>$address->area,
            'pincode'=>$address->pincode,
            'city'=>$address->city]
            ]);  

         $store = $request->session()->get('address');         
            
         return redirect()->back()->with('success', 'Address selected successfully!');
     }

   
 
     public function variant_price(Request $request)
     {
         $product = Food::find($request->id);
         $str = '';
         $quantity = 0;
         $price = 0;
         $addon_price = 0;
 
         foreach (json_decode($product->choice_options) as $key => $choice) {
             if ($str != null) {
                 $str .= '-' . str_replace(' ', '', $request[$choice->name]);
             } else {
                 $str .= str_replace(' ', '', $request[$choice->name]);
             }
         }
 
         if($request['addon_id'])
         {
             foreach($request['addon_id'] as $id)
             {
                 $addon_price+= $request['addon-price'.$id]*$request['addon-quantity'.$id];
             } 
         }
 
         if ($str != null) {
             $count = count(json_decode($product->variations));
             for ($i = 0; $i < $count; $i++) {
                 if (json_decode($product->variations)[$i]->type == $str) {
                     $price = json_decode($product->variations)[$i]->price - Helpers::product_discount_calculate($product, json_decode($product->variations)[$i]->price,Helpers::get_restaurant_data());
                 }
             }
         } else {
             $price = $product->price - Helpers::product_discount_calculate($product, $product->price,Helpers::get_restaurant_data());
         }
 
         return array('price' => Helpers::format_currency(($price * $request->quantity)+$addon_price));
     }

     public function orderStore(Order $order,Request $request,CustomerAddress $address)
     {
        
        $address = CustomerAddress::where('default','1')
                                  ->first();

        $store = session()->get('address');
        $cart = session()->get('cart', []);
        
        $rest = session()->get('restaurant');
    
        $inputs = request()->validate(['delivery_method'=>'required',]);
        
        $restaurant_discount_amount = 0;

        $address_id = 0;
        if($request->delivery_method == "delivery") {
        
         $address_id = isset($store['id']) ? $store['id'] : ($address->id);
        }
        
        $restaurant_id = null;
        $restaurant_id = $rest['restaurant'];
        
        $total=0;
        

        foreach($cart as $cartitems){
                $total +=($cartitems['price'] * $cartitems['quantity']);       
        }
        
       
        $customer = Auth::user()->id;
        $order->order_amount = $total;
        $order->delivery_address = $address_id;
        $order->order_type = $inputs['delivery_method'];
        $order->order_status = 'pending';
        $order->payment_status = 'pending';
        $order->payment_method = 'cash on delivery';
        $order->user_id = $customer;
        $order->restaurant_id = $restaurant_id;
        $order->restaurant_discount_amount = $restaurant_discount_amount;
        $order->created_at = now();
        $order->updated_at = now();

        $order->save();
        
        $cartid=array();

        foreach($cart as $cartItem){
            // dd($cartItem);
            array_push($cartid,$cartItem);
            $quantity=$cartItem['quantity'];
            $name=$cartItem['name'];
            $order->transaction()->attach(['quantity'=>$quantity,'name'=>$name]);
        }    
        
        return view('front.order',['Order' => $order],compact('order'));
        
     }

     public function order_history(Order $order)
     {
         $order = Order::orderBy('created_at', 'DESC')->where('user_id',auth()->user()->id)->get();
         
         $itemfoods = Food::all();

         return view('front.orderhistory',['order'=>$order],compact('itemfoods'));
     }


     public function downloadPDF(Order $order,Request $request)
     {
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