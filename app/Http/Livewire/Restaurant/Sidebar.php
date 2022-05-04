<?php

namespace App\Http\Livewire\Restaurant;

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Component;

class Sidebar extends Component
{
    public array $cuisines = [];
    public Collection $cuisinesCollection;
    public array $refines = [];
    public Collection $refinesCollection;

    protected $queryString  = ['cuisines', 'refines'];
    protected $listeners    = ['updateFilters'];

    public function mount() {
        Category::all()->mapToGroups(function ($item, $key) {
            return [$item['group'] => $item];
        })->each(function ($item, $key) {
            $this->{$key . 'Collection'} = $item->sortBy('value');
        });
    }

    public function updateFilters(string $group, array $values) : void {
        $this->{$group} = $values;
    }

    public function render()
    {
        return view('livewire.restaurant.sidebar');
    }
}