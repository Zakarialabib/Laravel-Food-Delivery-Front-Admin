<x-app-layout>
    @section('title', __('Order Tracking'))

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Order Tracking') }}</h3>
        </div>
    </div>
    <section class="py-60">
        <div class="container">
            <div class="row cuisine-dish-wrap">
                <div class="w-full cuisine-col">
                    <div class="order-status flex flex-row w-full">

                        <div class="order-tracking-status-head lg:w-3/4 md:w-3/4 sm:w-full">
                            @if ($order->order_type == 'delivery')
                                <p class="mb-0 py-2">{{ __('Thanks for shopping! Your order number is') }}
                                    <strong>#{{ $order->id }}</strong>.
                                    {{ __('The restaurant will deliver your order by') }}
                                    {{ $order->created_at }} PM.</p>
                                <span>{{ __('For any questions, reach out to us on info@tiktak.ma') }}</span>
                                <h6 class="mt-3">{{ __('Delivery Address') }}</h6>
                                <div class="card address-card">
                                    <div class="card-body deliverable">
                                        <div class="delivery">
                                            <i class="bx bxs-check-circle"></i>
                                            <h5 class="card-title">{{ $order->address->contact_person_name }}</h5>
                                        </div>
                                        <h6>{{ Auth::user()->f_name }}, {{ Auth::user()->phone }}</h6>
                                        <p class="card-text">
                                            @if ($order->address)
                                                {{ $order->address->contact_person_number }},
                                                {{ $order->address->address }},
                                                {{ $order->address->location }},
                                                {{ $order->address->house_name }},
                                                {{ $order->address->area }},{{ $order->address->city }},
                                                {{ $order->address->pincode }}.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <p>{{ __('Thanks for shopping! Your order number is') }}
                                    <strong>#{{ $order->id }}</strong>.
                                    {{ __('Pickup the order from the') }}
                                    <strong>{{ $order->restaurant->name }}</strong> {{ _('by') }}
                                    <strong>{{ $order->created_at->format('H:m:i') }}</strong>
                                </p>
                            @endif
                        </div>
                        <!--
                             <div class="map-wrap">
                                <iframe width="100%" height="330" class="map"
                                    src="https://maps.google.com/maps?q=cedex%20technologies&amp;t=&amp;z=17&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            </div>
                        -->
                        <div class="lg:w-1/4 md:w-1/4 sm:w-full">
                            <ul class="timeline">
                                <li class="active">
                                    <div class="timeline-item">
                                        <h6 class="pl-4">{{ __('ORDER PLACED') }}</h6>
                                    </div>
                                </li>
                                <li class="next">
                                    <div class="timeline-item">
                                        <h6 class="pl-4">{{ __('ORDER ACCEPTED') }}</h6>
                                    </div>
                                </li>
                                <li class="next">
                                    <div class="timeline-item">
                                        <h6 class="pl-4">{{ __('ORDER ACCEPTED') }}</h6>
                                    </div>
                                </li>
                                <li class="next">
                                    <div class="timeline-item">
                                        <h6 class="pl-4">{{ __('ORDER READY') }}</h6>
                                    </div>
                                </li>
                                <li class="next">
                                    <div class="timeline-item">
                                        <h6 class="pl-4">{{ __('ORDER PICKEDUP') }}</h6>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 cuisine-col">
                    @if (session('cartsession'))
                        <div class="cart">

                            <div class="cart-head">
                                <span>{{ __('Your order') }}</span>
                            </div>
                            <div class="cart-body">
                                @foreach ($order->itemfoods as $item)
                                    <div class="cart-item">
                                        <div class="details">
                                            <h6>{{ $item->name }}</h6>
                                        </div>
                                        <div class="price">
                                            <h6>{{ \App\CentralLogics\Helpers::format_currency($item['price']) }}
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="cart-footer">
                                <ul>
                                    <li>
                                        <h5><span>{{ __('Subtotal') }}</span> <span class="float-right">
                                                {{ \App\CentralLogics\Helpers::format_currency($order->grand_total) }}
                                            </span></h5>
                                    </li>
                                    <li>
                                        @if ($order->order_type == 'delivery')
                                            <p><span>{{ __('Delivery fee') }}</span> <span
                                                    class="float-right">$00.00</span></p>
                                        @endif
                                    </li>
                                    <li>
                                        <p><span>{{ __('Tax') }}</span> <span class="float-right">$00.00</span>
                                        </p>
                                    </li>
                                    <li>
                                        <h4><span>{{ __('Total') }}</span> <span class="float-right">
                                                {{ \App\CentralLogics\Helpers::format_currency($order->grand_total) }}
                                            </span>
                                        </h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </section>
</x-app-layout>