@extends('layouts.app')
@section('content')

    <!-- <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Status or info page</h3>
        </div>
    </div> -->

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Cart</h3>
        </div>
    </div>

    <section class="py-60 min-window-height">
        <div class="container">

            <div class="empty-orders-div">
                <!-- <img src="assets/images/cart.svg" alt="" class="mt-0"> -->
                <i class="bx bx-shopping-bag"></i>
                <h4 class="mb-3">Your Cart is Empty</h4>
                <p class="mb-2">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{route('restaurant_listing')}}" class="btn btn-primary mt-3">See Restaurants Near You</a>
            </div>

        </div>
    </section>

@endsection