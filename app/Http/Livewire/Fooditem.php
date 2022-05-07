<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Food;
use App\Models\Restaurant;
use Livewire\WithPagination;
use DB;

class Fooditem extends Component
{
    use WithPagination;

    // public $itemfoods;
    
    public $restaurant=[];

    public $cart;
    
    public $sum=[];
    
    public ?string $term = null;

    public string $orderBy = 'id';
    
    public string $sortBy = 'asc';
    
    public int $perPage = 10;

    public $readyToLoad = false;

    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    public function updatingTerm(){
        $this->resetPage();
     }

    public function updatingOrderBy(){
        $this->resetPage();
    }

    public function updatingSortBy(){
        $this->resetPage();
    }

    public function updatingPerPage(){
        $this->resetPage();
    }

    protected $listeners = ['some-event' => '$refresh'];


    public function mount($restaurant)
    {
        // * Search
        // $resto = Restaurant::find($restaurant);
        // $itemfoods = Food::where('restaurant_id', $restaurant)->orderBy($this->orderBy, $this->sortBy)->paginate($this->perPage);

        if (!empty($this->term)&& $this->term != null){
            $itemfoods = $itemfoods->search(trim($this->term));
        }

    }

    public function render(Restaurant $restaurant)
    {
         if (!empty($this->term)&& $this->term != null){
            $itemfoods = $itemfoods->search(trim($this->term));
        }

         $itemfoods = Food::orderBy($this->orderBy, $this->sortBy)->paginate($this->perPage);
        // dd($itemfoods);
        return view('livewire.fooditem', [
            'itemfoods' => $itemfoods,
        ]);
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
                "name" => $this->itemfoods->name,
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
                "name" => $this->itemfoods->name,
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
                "name" => $this->itemfoods->name,
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
                "name" => $this->itemfoods->name,
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

  
    
}