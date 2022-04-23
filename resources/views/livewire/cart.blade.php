<div class="col-lg-4 cart-col">

    <div class="cart d-none d-md-block">
        @if (count((array) session('cart')) != 0)
            <div class="cart-head">
                <span>Your order</span>
            </div>

            @php $total = 0 @endphp
            @if (session('cart'))

                @foreach (session('cart') as $id => $details)
                    @php
                        
                        $total += $details['rate'] * $details['quantity'];
                    @endphp
                    <div class="cart-body">
                        <div class="cart-item">
                            <div class="details">
                                <h6> {{ $details['food_item'] }}</h6>


                            </div>
                            <div class="price">
                                <h6>${{ $details['rate'] }}.00</h6>

                                <div class="add-remove-button">

                                    <div class="input-group">

                                        <input wire:click="removeItemFromCart({{ $details['id'] }})" type="button"
                                            value="-" class="button-minus changeQuantity" id="changeQuantity"
                                            data-field="quantity" />
                                        <input type="number" step="1" max="" value="{{ $details['quantity'] }}"
                                            name="quantity" class="quantity-field" />
                                        <input wire:click="addItemToCart({{ $details['id'] }})" type="button"
                                            value="+" class="button-plus changeQuantity" id="changeQuantity"
                                            data-field="quantity" />

                                    </div>





                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach
            @endif


            <div class="cart-footer">
                @php $total = 0 @endphp
                @foreach ((array) session('cart') as $id => $details)
                    @php $total += $details['rate'] * $details['quantity'] @endphp
                @endforeach
                <ul>
                    <li>
                        <h5>
                            <span>SubTotal</span>
                            <span class="float-right">${{ $total }}.00</span>
                        </h5>
                    </li>
                    <li>
                        <p>
                            <span>Delivery fre</span>
                            <span class="float-right">$00.00</span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span>Tax</span> <span class="float-right">$00.00</span>
                        </p>
                    </li>
                    <li>
                        <h4>
                            <span>Total</span>
                            <span class="float-right">${{ $total }}.00</span>
                        </h4>
                    </li>
                    <button class="btn btn-primary mt-3 w-100"
                        onclick="window.location.href='{{ route('customer.checkout') }}';">Proceed to Buy</button>
                </ul>
            </div>
    </div>


</div>

</div>
</div>






<div class="col-lg-4 cart-col">
@else
    <div class="cart d-none d-md-block">

        <div class="cart-body">

        </div>


    </div>

    <!-- Empty cart. Use this when the cart is empty -->

    <div class="cart">
        <div class="empty-cart text-center">
            <h4>Your cart is empty</h4>
            <p class="mb-0">Add items to get started.</p>
        </div>
    </div>

    <!-- Empty cart end  -->
</div>
@endif
</div>
