<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Restaurant;

class SearchRestaurant extends Component
{
    public $location;
    public $latitude;
    public $longitude;
    public $sortFilter;
    public $data;

    protected $queryString = ['location', 'latitude', 'longitude', 'sortFilter'];

    public function updatedData()
    {
        $point = new Point($this->latitude,$this->longitude);
        $zone = Zone::contains('coordinates', $point)->first();
       
        // $type = $this->query('type', 'all');
        $zone_id= $this->header('zoneId');
        
        $rest = Restaurant::where('zone_id', $zone)->
                            where('name','LIKE','%'.$search_text.'%')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.search-restaurant');
    }
}
