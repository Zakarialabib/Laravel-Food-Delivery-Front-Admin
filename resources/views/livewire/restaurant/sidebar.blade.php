<div class="w-max">
    @livewire('restaurant.sidebar-filter', ['collection' => $cuisinesCollection, 'group' => $cuisinesCollection[0]->group], key(1))
    @livewire('restaurant.sidebar-filter', ['collection' => $refinesCollection, 'group' => $refinesCollection[0]->group], key(2))
</div>