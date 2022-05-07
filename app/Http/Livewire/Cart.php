<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Food;
use App\Models\Restaurant;
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
    public function addItemToCart($id, Request $request)
    {
       
        $itemfoods = Food::findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        $cartsession = session()->get('cartsession', []);
        
        if(isset($cartsession[$id])) {
                    unset($cartsession[$id]);
                } 
       
        
        
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
        
        session()->put('cartsession', $cart);
      
        if(isset($cartsession[$id])) {
            $cartsession[$id]['quantity']++;
        } else {
            $cartsession[$id] = [
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "order_amount" => $itemfoods->order_amount,
            ];
        }
        
        session()->put('cartsession', $cartsession);
        
        
        $this->emit('increment');
        $this->emit('some-event');
        
    }
    
    public function removeItemFromCart($id){
        $itemfoods = Food::findOrFail($id);
           
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
                "id"=>$itemfoods->id,
                "name" => $itemfoods->name,
                "quantity" => 1,
                "order_amount" => $itemfoods->order_amount,
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
                "name" => $itemfoods->name,
                "quantity" => 1,
                "order_amount" => $itemfoods->order_amount,
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