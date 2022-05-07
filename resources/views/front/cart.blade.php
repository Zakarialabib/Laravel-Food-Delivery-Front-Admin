@extends('layouts.app')
@section('content')

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Cart</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container cart-page">
            <div class="table-responsive-lg">
                <table class="cart-table table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                @php
                                $total = 0;
                                $total += $details['price'] * $details['quantity']; 
                                @endphp

                                <tr data-id="{{ $id }}">
                                    <td class="product-item">
                                        <div class="dish-image">
                                            <a href="#"><img src="{{ asset('assets/images/img1.jpg') }}"
                                                    alt="product"></a>
                                        </div>
                                        <div class="product-name">
                                            <a href="#">{{ $details['name'] }}</a>
                                        </div>
                                    </td>
                                    <td>${{ $details['price'] }}</td>
                                    <td>
                                        <div class="add-remove-button">
                                            <div class="input-group">
                                                <a href="{{ route('removeFromCart', $id) }}" min="0"
                                                    class="number-button  minus">-</a>
                                                <input type="number" step="1" max="" value="{{ $details['quantity'] }}"
                                                    name="quantity" class="quantity-field">
                                                <a href="{{ route('addToCart', $id) }}"
                                                    class="number-button  plus">+</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $total }}</td>
                                    <td>
                                        <a href="{{ route('cartDelete', $id) }}" class="float-right"><i
                                                class='bx bx-trash'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6">
                    <form action="">
                        <div class="input-group coupon-group">
                            <input type="text" class="form-control" placeholder="Coupon Code"
                                aria-label="delivery location" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" id="find-food-btn">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">

                    <h4 class="mb-3 mt-4 mt-lg-0">Cart totals</h4>

                    <table class=" table-responsive-sm subtotal-table w-100">
                        <tbody>
                            @php $total = 0 @endphp
                            @foreach ((array) session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                            @endforeach
                            <tr>
                                <th>Sub Total</th>
                                <td>{{ $total }}</td>
                            </tr>
                            <tr>
                                <th>Tax</th>
                                <td>£ 0.00</td>
                            </tr>
                            <tr>
                                <th>Delivery Charge </th>
                                <td>£ 0.00</td>
                            </tr>
                            <tr>
                                <th>Order Total </th>
                                <td>{{ $total }}</td>
                            </tr>

                        </tbody>
                    </table>
                    <a href="login.html" class="btn btn-primary mt-3 float-right check-out-btn">Proceed to
                        checkout</a>

                </div>
            </div>

        </div>
    </section>

@endsection
