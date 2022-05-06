<div wire:init="loadItems">

    {{-- <div wire:loading class="w-full">
        <div class="flex justify-center items-center mt-32">
            <x-svg-spinner class="w-24 h-24 fill-primary-700 dark:fill-primary-400" />
        </div>
    </div> --}}
    <div class="py-12 flex flex-wrap" wire:loading.remove>

        {{-- <div class="flex flex-wrap items-center">
                    <div class="relative flex-row flex-1 w-full max-w-full px-4">

                        <div class="relative grid grid-cols-6 gap-6 mt-2 ">

                            <div class="col-span-3 md:col-span-2 lg:col-span-2">
                                <label class="text-xs" for="search" value="{{ __('search') }}">
                                    <input wire:model="term" id="search" type="text" class="block w-full mt-1"
                                        autocomplete="off" />
                            </div>

                            <div class="col-span-3 md:col-span-2 lg:col-span-1">
                                <label class="text-xs" for="select" value="{{ __('OrderBy') }}">
                                    <x-select wire:model="orderBy" class="mt-1">
                                        <option value="price">{{ __('price') }}</option>
                                        <option value="status">{{ __('status') }}</option>
                                        <option value="created_at">{{ __('created_at') }}</option>
                                        <option value="updated_at">{{ __('updated_at') }}</option>
                                    </x-select>
                            </div>

                            <div class="col-span-3 md:col-span-2 lg:col-span-1">
                                <label class="text-xs" for="select" value="{{ __('PerPage') }}">
                                    <x-select wire:model="perPage" class="mt-1">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </x-select>
                            </div>

                            <div class="col-span-3 md:col-span-2 lg:col-span-1">
                                <label class="text-xs" for="select" value="{{ __('SortBy') }}">
                                    <x-select wire:model="sortBy" class="mt-1">
                                        <option value="asc">{{ __('ASC') }}</option>
                                        <option value="desc">{{ __('DESC') }}</option>
                                    </x-select>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- @dd($itemfoods) --}}
        @foreach ($itemfoods as $item)
            {{-- @if ($restaurant->foods) --}}
                <div class="col-lg-6" wire:key="{{ $item->id }}">
                    @if ($item->status == 1)
                        <div class="food-item-card">
                            <div class="food-item-img"
                                style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
                            </div>
                            <div class="food-item-body">
                                <h5 class="card-title">
                                    {{ $item->food_item }}
                                </h5>
                                <div class="pricing">
                                    <div class="price-wrap">
                                        @if ($item->status == 1)
                                            <div class="non-div food-type-div">
                                                <i class="bx bxs-circle"></i>
                                            </div>
                                        @else
                                            <div class="veg-div food-type-div">
                                                <i class="bx bxs-circle"></i>
                                            </div>
                                        @endif
                                        <span class="price">{{ $item->price }} DH</span>
                                        {{-- <span class="actual-price">$180.99</span> --}}
                                    </div>

                                    <div class="add-remove-button">

                                        <div class="input-group">

                                            <input wire:click="removeFromCart({{ $item->id }})" type="button"
                                                value="-" class="button-minus changeQuantity" id="changeQuantity"
                                                data-field="quantity" />
                                            <input type="number" step="1" min="1"
                                                value="{{ $this->itemQuantity($item->id) }}" name="quantity" readonly
                                                class="quantity-field qty-input" />

                                            <input wire:click="addToCart({{ $item->id }})" type="button" value="+"
                                                class="button-plus " id="changeQuantity" data-field="quantity" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="food-item-card unavailable">
                            <div class="food-item-img"
                                style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
                            </div>
                            <div class="food-item-body">
                                <h5 class="card-title">
                                    {{ $item->food_item }}
                                </h5>
                                <div class="pricing">
                                    <div class="price-wrap">
                                        @if ($item->status == 1)
                                            <div class="non-div food-type-div">
                                                <i class="bx bxs-circle"></i>
                                            </div>
                                        @else
                                            <div class="veg-div food-type-div">
                                                <i class="bx bxs-circle"></i>
                                            </div>
                                        @endif
                                        <span class="price">{{ $item->price }} DH</span>
                                        {{-- <span class="actual-price">$180.99</span> --}}
                                    </div>

                                    <span class="unavailable-text">{{ __('Unavailable') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            {{-- @endif --}}
        @endforeach
        @if (!empty($itemsfood))
            <div class="px-4 py-3 border-t dark:border-gray-700">
                {{ $itemsfood->links() }}
            </div>
        @endif
    </div>
</div>
