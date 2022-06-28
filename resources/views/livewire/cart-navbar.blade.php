<div>
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Cart') }}</h3>
        </div>
    </div>

    @if (session('cart'))
        <section class="py-60">
            <div class="container cart-page-new">
                <div class="row cuisine-dish-wrap">
                    <div class="col-lg-8 cuisine-col">
                        <div class="rest-menus" id="rest-menus">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">

                                    <div class="food-item-cards-wrap">
                                        <div class="sub-cat mt-0" id="sub-cat1">
                                            <h4 class="mb-4 mt-0">{{ __('Your order') }}</h4>

                                            @php $total = 0 @endphp
                                            @if (session('cart'))
                                                @foreach (session('cart') as $id => $details)
                                                    @php
                                                        $total = 0;
                                                    $total += $details['price'] * $details['quantity']; @endphp
                                                    <div class="food-item-card my-4">
                                                        <div class="food-item-img ct-img"
                                                            style="background-image: url({{ asset('assets/images/img2.jpg') }});">
                                                        </div>
                                                        <div class="food-item-body">

                                                            <h5 class="card-title">
                                                                {{ $details['name'] }}
                                                            </h5>
                                                            {{-- <p class="description">description
                                                                Lorem ipsum dolor sit amet consectetur
                                                                adipisicing elit. Expedita?
                                                            </p> --}}
                                                            <div class="pricing">
                                                                <span
                                                                    class="price">${{ $details['price'] }}</span>
                                                                <div class="add-remove-button">

                                                                    <div class="input-group">

                                                                        <input {{-- wire:click="removeFromCartNav({{ $details['id'] }})" --}} type="button"
                                                                            value="-"
                                                                            class="button-minus changeQuantity"
                                                                            id="changeQuantity" data-field="quantity" />
                                                                        <input type="number" step="1" max=""
                                                                            value="{{ $details['quantity'] }}"
                                                                            name="quantity" class="quantity-field" />
                                                                        <input {{-- wire:click="addToCartNav({{ $details['id'] }})" --}} type="button"
                                                                            value="+" class="button-plus changeQuantity"
                                                                            id="changeQuantity" data-field="quantity" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <p class="text-to-kitchen">
                                                                Text to kitchen. Delete this if you are not
                                                                using.
                                                                adipisicing elit. Enim illum adipisci natus
                                                                ducimus,
                                                                voluptatem
                                                            </p> --}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-4 cart-col">
                        <div class="cart">
                            <div class="cart-head">
                                <span>{{ __('Price Details') }}</span>
                            </div>

                            <div class="cart-footer mt-4">
                                @php $total = 0 @endphp
                                @foreach ((array) session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                @endforeach
                                <ul>
                                    <li>
                                        <h5>
                                            <span>{{ __('Subtotal') }}</span>
                                            <span class="float-right">${{ $total }}</span>
                                        </h5>
                                    </li>
                                    <li>
                                        <p>
                                            <span>{{ __('Delivery fees') }}</span>
                                            <span class="float-right">$0.00</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <span>{{ __('Tax') }}</span> <span class="float-right">$0.00</span>
                                        </p>
                                    </li>
                                    <li>
                                        <h4>
                                            <span>Total</span>
                                            <span class="float-right">${{ $total }}</span>
                                        </h4>
                                    </li>
                                    <button
                                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm mt-3 w-100"
                                        onclick="window.location.href='{{ route('checkout') }}';">{{ __('Checkout') }}</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="py-60 min-window-height">
            <div class="container">

                <div class="empty-orders-div" style="align:center">
                    <!-- <img src="assets/images/cart.svg" alt="" class="mt-0"> -->
                    <i class="bx bx-shopping-bag"></i>
                    <h4 class="mb-3">{{ __('Your cart is empty') }}</h4>
                    <p class="mb-2">{{ __("Looks like you haven't added anything to your cart yet.") }}</p>
                    <a href="{{ route('restaurant_listing') }}"
                        class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm mt-3">See
                        {{ __('Restaurants Near You') }}</a>
                </div>

            </div>
        </section>
    @endif
</div>
