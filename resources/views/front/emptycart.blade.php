<x-app-layout>

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{__('Cart')}}</h3>
        </div>
    </div>

    <section class="py-60 min-window-height">
        <div class="container">

            <div class="empty-orders-div">
                <!-- <img src="assets/images/cart.svg" alt="" class="mt-0"> -->
                <i class="bx bx-shopping-bag"></i>
                <h4 class="mb-3">{{__(' Your cart is empty')}}</h4>
                <p class="mb-2">{{__("Looks like you haven't added anything to your cart yet")}}.</p>
                <a href="{{route('restaurant_listing')}}" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm mt-3">{{__('See Restaurants Near You')}}</a>
            </div>

        </div>
    </section>

</x-app-layout>