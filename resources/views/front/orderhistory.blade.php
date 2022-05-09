<x-app-layout>
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Order History') }}</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <div class="row">
                @include('partials.sidebar')
                <div class="col-lg-9">
                    <div class="tab-pane fade show" id="v-pills-orders" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <div class="my-account-content">
                            @if ($order->isEmpty())
                                <div class="empty-orders-div ">

                                    <i class="bx bx-shopping-bag"></i>

                                    <p class="mb-1">{{ __("Look like you haven't made any orders yet") }}.
                                    </p>

                                    <p class="mb-0"><a
                                            href="{{ route('home') }}">{{ __('Click here to continue shopping') }}.</a>
                                    </p>

                                </div>
                            @else
                                @foreach ($order as $orderstore)
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card order-card">
                                                <div class="card-body">
                                                    <div class="rest-delivery">
                                                        <h5>{{ $orderstore->restaurant->name }}</h5>
                                                        <!-- <h6>Delivered on {{ $orderstore->order_date }}</h6> -->
                                                    </div>
                                                    <p class="rest-address">

                                                        <i class="bx bx-location-plus"></i>
                                                        {{ $orderstore->restaurant->address }}
                                                    </p>
                                                    <div class="order-id-time">
                                                        <p>{{ __('Order') }} #{{ $orderstore->id }}</p>
                                                        <p>{{ $orderstore->order_date }}</p>
                                                    </div>
                                                    <div class="order-id-time">
                                                        @foreach ($orderstore->itemfoods as $item)
                                                            <p class="items">{{ $item->name }}</p>
                                                        @endforeach
                                                    </div>
                                                    <div class="total-buttons">
                                                        <h5>{{ __('Total Paid') }}:
                                                            ${{ $orderstore->grand_total }}</h5>
                                                        <div class="button-wrap">

                                                            <button type="button" data-toggle="modal"
                                                                class="btn btn-outline-primary btn-sm"
                                                                data-target="#exampleModal{{ $orderstore->id }}">
                                                                {{ __('Details') }}</button>
                                                            <button class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"><i
                                                                    class="bx bx-download align-middle mr-1"></i>
                                                                <a href="/customer/download-pdf/{{ $orderstore->id }}"
                                                                    style="color:white">{{ __('Download') }}</a></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @foreach ($order as $orderstore)
                        <!-- View Orders Modal -->
                        <div class="modal fade address-model view-orders-model"
                            id="exampleModal{{ $orderstore->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="text-center w-100">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Order') }}
                                                #{{ $orderstore->id }}</h5>
                                            <h6>{{ $orderstore->created_at }}</h6>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i class="bx bx-x btn-close"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('Order status') }}</td>
                                                    <td>{{ $orderstore->order_status }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Total amount') }}</td>
                                                    <td>${{ $orderstore->grand_total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Total discount') }}</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Delivery charge') }}</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Amount Paid') }}</td>
                                                    <td>${{ $orderstore->grand_total }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-striped mt-5 mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Ordered Items') }}</th>
                                                    <th scope="col">{{ __('Price') }}</th>
                                                    <th scope="col">{{ __('Total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderstore->itemfoods as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ \App\CentralLogics\Helpers::format_currency($item['price']) }}</td>
                                                        <td>${{ $orderstore->grand_total }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- View Orders Modal End -->

            </div>
        </div>
    </section>
</x-app-layout>
