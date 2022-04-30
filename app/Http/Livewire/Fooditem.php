<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Food;
use App\Models\Restaurant;
use Livewire\WithPagination;

class Fooditem extends Component
{
    use WithPagination;
    public string $itemfoods;
    public $restaurant=[];
    public $cart;
    public $sum=[];
    
    protected $listeners = ['some-event' => '$refresh'];
    
    public function mount($restaurant)
    {

        $this->itemfoods=Food::where('status', 1)->paginate(5);

        
        
    }

    public function addToCart($id)
    {
        $this->itemfoods = Food::findOrFail($id);
        $cartsession = session()->get('cartsession', []);
        
        if(isset($cartsession[$id]) && $cartsession[$id]['quantity'] == "1") {
                 unset($cartsession[$id]);
             } 
        $cart = session()->get('cart', []);
        
   
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id"=>$this->itemfoods->id,
                "food_item" => $this->itemfoods->food_item,
                "quantity" => 1,
                "order_amount" => $this->itemfoods->order_amount,
                
            ];
        }
          
        session()->put('cart', $cart);
       
       
        if(isset($cartsession[$id])) {
            $cartsession[$id]['quantity']++;
        } else {
            $cartsession[$id] = [
                "id"=>$this->itemfoods->id,
                "food_item" => $this->itemfoods->food_item,
                "quantity" => 1,
                "order_amount" => $this->itemfoods->order_amount,
                
            ];
        }
          
        session()->put('cartsession', $cartsession);
        
        $this->emit('increment');
        $this->emit('some-event');
    }
    
    public function removeFromCart($id)
    {
        $this->itemfoods = Food::findOrFail($id);
       
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
                "id"=>$this->itemfoods->id,
                "food_item" => $this->itemfoods->food_item,
                "quantity" => 1,
                "order_amount" => $this->itemfoods->order_amount,
            ];
        }
          
        session()->put('cart', $cart);
        $cartsession = session()->get('cartsession', []);
        $itemId=$cartsession[$id]['quantity'];
        if(isset($cartsession[$id]) && $cartsession[$id]['quantity'] > "1") {
            $cartsession[$id]['quantity']--;
        } elseif($itemId== 1) {           
            unset($cartsession[$id]);
        } else {
            $cartsession[$id] = [
                "id"=>$this->itemfoods->id,
                "food_item" => $this->itemfoods->food_item,
                "quantity" => 1,
                "order_amount" => $this->itemfoods->order_amount,            
                
            ];
        }
          
        session()->put('cartsession', $cartsession);
      
        $this->emit('decrement');
        $this->emit('some-event');
    }
     
    public function itemQuantity($id){
        $cart = session()->get('cart', []);
        if(isset($cart[$id]['quantity']))
        {
            $cartId=$cart[$id]['quantity'];
            return $cartId;
        }
        else{
            return 0;
        }    
  
    }

    public function render()
    {
        return view('livewire.fooditem');
    }
    
}