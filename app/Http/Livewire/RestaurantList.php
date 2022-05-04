<?php

namespace App\Http\Livewire;

use App\Models\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RestaurantList extends Component
{
    public Collection $restaurants;
    public string $postcode;
    public array $cuisines = [];
    public array $refines = [];

    protected $listeners = ['filterUpdate'];

    public function mount(string $postcode) {
        foreach (request()->only(['cuisines', 'refines']) as $key => $value) {
            $this->$key = $value;
        }

        $this->postcode = $postcode;
        $this->restaurants = $this->filterRestaurants();
    }

    public function filterUpdate(array $filters) : void{
        $key = array_keys($filters)[0];
        $this->$key = $filters[$key];

        $this->restaurants = $this->filterRestaurants();
    }

    public function filterRestaurants() : Collection {
        $query = Restaurant::query();

        $query->when((!empty($this->cuisines) || !empty($this->refines)), function ($query) {
            return $query->whereHas('category', function ($query) {
                $query->whereIn('value', array_merge($this->cuisines, $this->refines));
            });
        }, function ($query) {
            return $query->with('category');
        });


        return $query->get();
    }

    public function render()
    {
        return view('livewire.restaurant-list');
    }
}