<div class="col-lg-4 cart-col" id="cart">>
    <div class="cart d-none d-md-block">
        @if (count((array) session('cart')) != 0)
            <div class="cart-head">
                <span>{{ __('Your order') }}</span>
            </div>

            @php $total = 0 @endphp
            @if (session('cart'))

                @foreach (session('cart') as $id => $details)
                    {{-- @dd(session('cart')) --}}
                    @php
                        $total += $details['price'] * $details['quantity'];
                        $product_subtotal = $details['price'] * $details['quantity'];
                        $subtotal = 0;
                        $addon_price = 0;
                        $tax = \App\CentralLogics\Helpers::get_restaurant_data()->tax;
                        $discount = 0;
                        $discount_type = 'amount';
                        $discount_on_product = 0;
                    @endphp

                    <div class="cart-body">
                        <div class="cart-item">
                            <div class="details" class="media align-items-center cursor-pointer"
                                onclick="quickViewCartItem({{ $details['id'] }}, {{ $key }})">
                                <img class="avatar avatar-sm mr-1"
                                    src="{{ asset('storage/app/public/product') }}/{{ $details['image'] }}"
                                    onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                                    alt="{{ $details['name'] }} image">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0">{{ Str::limit($details['name'], 10) }}</h5>
                                    <small>{{ Str::limit($details['variant'], 20) }}</small>
                                </div>
                            </div>
                            <div class="price">
                                <h6> {{ \App\CentralLogics\Helpers::format_currency($product_subtotal) }}</h6>

                                <div class="add-remove-button">

                                    <div class="input-group">

                                        <input wire:click="removeItemFromCart({{ $id }})" type="button"
                                            value="-" class="button-minus changeQuantity" id="changeQuantity"
                                            data-field="quantity" />
                                        <input type="number" step="1" max="" value="{{ $details['quantity'] }}"
                                            name="quantity" class="quantity-field" />
                                        <input wire:click="addItemToCart({{ $id }})" type="button" value="+"
                                            class="button-plus changeQuantity" id="changeQuantity"
                                            data-field="quantity" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="cart-footer">
                @php
                $total = $subtotal + $addon_price;
                $discount_amount = $discount_type == 'percent' && $discount > 0 ? (($total - $discount_on_product) * $discount) / 100 : $discount;
                $total -= $discount_amount + $discount_on_product;
                $total_tax_amount = $tax > 0 ? ($total * $tax) / 100 : 0;
                @endphp
                <ul>
                    <li>
                        <h5>
                            <span>{{__('SubTotal')}}</span>
                            <span class="float-right">${{ $total }}.00</span>
                        </h5>
                    </li>
                    <li>
                        <p>
                            <span>{{__('Delivery fees')}}</span>
                            <span class="float-right">$00.00</span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span>{{__('Tax')}}</span> <span class="float-right">$00.00</span>
                        </p>
                    </li>
                    <li>
                        <h4>
                            <span>{{__('Total')}}</span>
                            <span class="float-right">${{ $total }}.00</span>
                        </h4>
                    </li>
                    <button
                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm mt-3 w-100"
                        onclick="window.location.href='{{ route('checkout') }}';">Proceed to Buy</button>
                </ul>
            </div>
    </div>
    <div class="col-lg-4 cart-col">
    @else
        <!-- Empty cart. Use this when the cart is empty -->

        <div class="cart">
            <div class="empty-cart text-center">
                <h4>{{__('Your cart is empty')}}</h4>
                <p class="mb-0">{{__('Add items to get started')}}.</p>
            </div>
        </div>

        <!-- Empty cart end  -->
    </div>
    @endif
</div>