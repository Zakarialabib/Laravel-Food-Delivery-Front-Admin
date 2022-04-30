<div class="row">
    @php
        $this->restaurant = $restaurant->itemfoods;
    @endphp
    @foreach ($itemfoods as $item)
        {{-- @if ($restaurant->contains($item->id)) --}}
            <div class="col-lg-6" wire:key="{{ $item->id }}">
                @if ($item->status == 1)
                    <div class="food-item-card">
                        <div class="food-item-img" style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
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
                                    <span class="price">${{ $item->price }}</span>
                                    {{-- <span class="actual-price">$180.99</span> --}}
                                </div>

                                <div class="add-remove-button">

                                    <div class="input-group">

                                        <input wire:click="removeFromCart({{ $item->id }})" type="button" value="-"
                                            class="button-minus changeQuantity" id="changeQuantity"
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
                        <div class="food-item-img" style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
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
                                    <span class="price">${{ $item->price }}</span>
                                    {{-- <span class="actual-price">$180.99</span> --}}
                                </div>

                                <span class="unavailable-text">{{__('Unavailable')}}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        {{-- @endif --}}
    @endforeach
    {{ $itemfoods->links() }}
</div>
