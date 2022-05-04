<?php

namespace App\Http\Livewire\Restaurant;

use Illuminate\Support\Collection;
use Livewire\Component;

class SidebarFilter extends Component
{
    public array $query;
    public Collection $collection;
    public string $group;
    public bool $showMore = false;

    public function mount(Collection $collection, string $group){
        $this->collection = $collection;
        $this->group = $group;
        $this->query = $_GET[$this->group] ?? [];
    }

    public function isChecked(string $value) : bool {
        return in_array($value, $this->query);
    }

    public function updatedQuery($value) : void {
        $this->emit('filterUpdate', array_fill_keys([$this->group], array_values($this->query)));
        $this->emitUp('updateFilters', $this->group, $this->query);
    }

    public function expand() : void {
        $this->showMore = !$this->showMore;
    }

    public function render()
    {
        return view('livewire.restaurant.sidebar-filter');
    }
}