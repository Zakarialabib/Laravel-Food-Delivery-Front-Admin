<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Itemfood;

class CartNavbar extends Component
{
    public function addToCartNav($id)
    {
        $itemfoods = Itemfood::findOrFail($id);
           
        $cart = session()->get('cart', []);
        
   
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "order_amount" => $itemfoods->order_amount,
                
            ];
        }
          
        session()->put('cart', $cart);
    
        
        
        $this->emit('increment');
        $this->emit('some-event');
        
    }
    
    public function removeFromCartNav($id){
        $itemfoods = Itemfood::findOrFail($id);
           
        $cart = session()->get('cart', []);
        $itemId=$cart[$id]['quantity'];

        
   
        if(isset($cart[$id]) && $cart[$id]['quantity'] > "1") {
            $cart[$id]['quantity']--;
        } 
        elseif($itemId== 1){
           
                unset($cart[$id]);
            }
        
        
        else {
            $cart[$id] = [
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "order_amount" => $itemfoods->order_amount,
            
                
            ];
        }
          
        session()->put('cart', $cart);


        $this->emit('decrement');
        $this->emit('some-event');
    }  
    public function render()
    {
        return view('livewire.cart-navbar');
    }
}