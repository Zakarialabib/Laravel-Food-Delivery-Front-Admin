<div wire:init="loadItems">

    {{-- <div wire:loading class="w-full">
        <div class="flex justify-center items-center mt-32">
            <x-svg-spinner class="w-24 h-24 fill-primary-700 dark:fill-primary-400" />
        </div>
    </div> --}}
    <div class="my-2 px-4 flex sm:flex-row flex-col">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <x-select wire:model="perPage"
                    class="appearance-none h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </x-select>
            </div>
            <div class="relative">
                <x-select wire:model="sortBy"
                    class="appearance-none h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="asc">{{ __('ASC') }}</option>
                    <option value="desc">{{ __('DESC') }}</option>
                </x-select>
            </div>
            <div class="relative">
                <x-select wire:model="orderBy"
                    class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                    <option value="price">{{ __('Price') }}</option>
                    <option value="status">{{ __('Status') }}</option>
                    <option value="created_at">{{ __('Created at') }}</option>
                    <option value="updated_at">{{ __('Updated at') }}</option>
                </x-select>
            </div>

            <div class="block relative">
                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                        </path>
                    </svg>
                </span>
                <input wire:model="term" id="search" type="text"
                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
                    autocomplete="off" />
            </div>
        </div>
    </div>
    <div class="py-2 flex flex-wrap" wire:loading.remove>

        @forelse ($itemfoods as $item)
            @if ($restaurant->foods->contains($item->id))
                <div class="lg:w-1/2 sm:w-full px-4 my-2" wire:key="{{ $item->id }}">

                    @if ($item->status == 1)
                        <div class="food-item-card" onclick="quickView('{{ $item->id }}')" style="cursor: pointer;">
                            <div class="clickable p-0">
                                <div class="food-item-img"
                                    style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
                                </div>
                                <div class="food-item-body">
                                    <h5 class="card-title">
                                        {{ Str::limit($item['name'], 12, '...') }}
                                    </h5>
                                    <p class="text-sm">{{ Str::limit($item->category, 20, '...') }}</p>
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
                                            <span
                                                class="price">{{ \App\CentralLogics\Helpers::format_currency($item['price']) }}
                                            </span>
                                        </div>

                                        <div class="add-remove-button">

                                            <div class="input-group">

                                                <input wire:click="removeFromCart({{ $item->id }})" type="button"
                                                    value="-" class="button-minus changeQuantity" id="changeQuantity"
                                                    data-field="quantity" />
                                                <input type="number" step="1" min="1"
                                                    value="{{ $this->itemQuantity($item->id) }}" name="quantity"
                                                    readonly class="quantity-field qty-input" />
                                                <input wire:click="addToCart({{ $item->id }})" type="button"
                                                    value="+" class="button-plus " id="changeQuantity"
                                                    data-field="quantity" />

                                                {{-- <div class="input-group">
                                                    <a href="{{ route('removeFromCart', $item->id) }}" min="0"
                                                        class="number-button  minus">-</a>
                                                    <input type="number" step="1" max="" value="{{ $this->itemQuantity($item->id) }}"
                                                        name="quantity" class="quantity-field">
                                                    <a href="{{ route('addToCart', $item->id) }}"
                                                        class="number-button  plus">+</a>
                                                </div> --}}
                                            </div>
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
                                    {{ $item->name }}
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
            @endif
        @empty
            {{ __('No foods') }}
        @endforelse


        <div class="px-4 py-3 border-t dark:border-gray-700">
            {{ $itemfoods->links() }}
        </div>


    </div>
    <div class="modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>
</div>
