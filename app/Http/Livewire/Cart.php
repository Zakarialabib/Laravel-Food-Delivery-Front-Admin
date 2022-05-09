<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Food;
use App\Models\Restaurant;
use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
class Cart extends Component
{
    public $show = false;

    protected $listeners = [
        'increment' => 'refreshComponent',
        'decrement' => 'refreshComponent',

    ];

    public function refreshComponent(){
        $this->show=true;

    }
    public function addItemToCart($id)
    {
       
        $product = Food::findOrFail($id);
        
        $data['id'] = $product->id;

        $str = '';
        $variations = [];
        $price = 0;
        $addon_price = 0;

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode($product->choice_options) as $key => $choice) {
            $data[$choice->name] = $this[$choice->name];
            $variations[$choice->title] = $this[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $this[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $this[$choice->name]);
            }
        }
        $data['variations'] = $variations;
        $data['variant'] = $str;
        if ($this->session()->has('cart') && !isset($this->cart_item_key)) {
            if (count($this->session()->get('cart')) > 0) {
                foreach ($this->session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $this['id'] && $cartItem['variant'] == $str) {
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

        $data['quantity'] = $this['quantity'];
        $data['price'] = $price;
        $data['name'] = $product->name;
        $data['discount'] = Helpers::product_discount_calculate($product, $price,Helpers::get_restaurant_data());
        $data['image'] = $product->image;
        $data['add_ons'] = [];
        $data['add_on_qtys'] = [];
        
        if($this['addon_id'])
        {
            foreach($this['addon_id'] as $id)
            {
                $addon_price+= $this['addon-price'.$id]*$this['addon-quantity'.$id];
                $data['add_on_qtys'][]=$this['addon-quantity'.$id];
            } 
            $data['add_ons'] = $this['addon_id'];
        }

        $data['addon_price'] = $addon_price;

        if ($this->session()->has('cart')) {
            $cart = $this->session()->get('cart', collect([]));
            if(isset($this->cart_item_key))
            {
                $cart[$this->cart_item_key] = $data;
                $data = 2;
            }
            else
            {
                $cart->push($data);
            }

        } else {
            $cart = collect([$data]);
            $this->session()->put('cart', $cart);
        }
        
        $this->emit('increment');
        $this->emit('some-event');
        
    }
    
    public function removeItemFromCart($id){
        $product = Food::findOrFail($id);
           
        $cart = session()->get('cart', []);
        
        $cartsession = session()->get('cartsession', []);
       
        $itemId=$cart[$id]['quantity'];

        
   
        if(isset($cart[$id]) && $cart[$id]['quantity'] > "1") {
            $cart[$id]['quantity']--;
        } 
        elseif($itemId== 1){
           
                unset($cart[$id]);
            }
        
        
        else {
            $cart[$id] = [
                "id"=>$product->id,
                "name" => $product->name,
                "quantity" => 1,
                "order_amount" => $product->order_amount,
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
                "id"=>$product->id,
                "name" => $product->name,
                "quantity" => 1,
                "order_amount" => $product->order_amount,
            ];
        }
        session()->put('cartsession', $cartsession);
        
    $this->emit('decrement');
    
    $this->emit('some-event');
    
    }
    public function checkout()
    {
        return redirect()->to('/checkout');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}