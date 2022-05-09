<x-app-layout>
    @section('title', __('Checkout'))


    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Checkout') }}</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <form method="post" action="{{ route('orderStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="row cuisine-dish-wrap">
                    <div class="col-lg-8 cuisine-col">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <h6 class="checkout-title">{{__('Delivery Type')}}</h6>
                                <select class="form-control " name="delivery_method" id="select"
                                    onchange="status(this)">
                                    <option value="delivery" selected="delivery">{{__('Delivery')}}</option>
                                    <option value="pickup">{{__('Pickup')}}</option>
                                </select>
                            </div>
                        </div>
                        <h6 class="checkout-title">{{__('Payment')}}</h6>
                        <div class="form-group col-lg-12">
                            <div class="custom-radio">
                                <input type="radio" id="radio1" name="payment-type" checked="checked">
                                <label for="radio1">{{__('Pay via Cash')}}</label>
                                <img src="{{ asset('assets/images/cash.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="checkout-delivery-address food-item-cards-wrap" id="sub1">
                            <h6 class="checkout-title">{{__('Delivery Address')}}</h6>
                            <div class="row">
                                @foreach ($address as $add)
                                    <div class="col-xl-6">
                                        <div class="card address-card">
                                            <div class="card-body deliverable">
                                                <div class="delivery">
                                                    @if ($add->default == 1)
                                                        <i class='bx bxs-check-circle'></i>
                                                    @endif

                                                    <h5 class="card-title">{{ $add->address_type }}</h5>
                                                </div>
                                                <p class="card-text">
                                                    {{ $add->address }}

                                                </p>
                                                @if (!session('address'))
                                                    <button class="btn btn-primary btn-sm"><a
                                                            href="{{ route('addressStore', $add->id) }} "
                                                            style="color:white">{{__('Deliver here')}}</a></button>
                                                @else
                                                    <button class="btn btn-primary btn-sm"><a
                                                            href="{{ route('addressStore', $add->id) }} "
                                                            style="color:white">{{__('Delivered here')}}</a></button>
                                                @endif
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    id="edit-item" data-toggle="modal"
                                                    data-target="#exampleModal{{ $add->id }}">
                                                    {{__('Edit')}}</button> {{ session()->get('location') }}
                                                <button class="btn btn-outline-primary btn-sm">
                                                    <a href="{{ route('address_destroy', $add->id) }}">
                                                        {{__('Delete')}}</a></button>

                                            </div>
                                        </div>
                                    </div>

                                    {{--  <div class="col-xl-6">
                                <div class="card address-card">
                                    <div class="card-body unavailable">
                                        <div class="delivery ">
                                            <i class='bx bxs-x-circle'></i>
                                            <h5 class="card-title">{{ $add->address_type }}</h5>
                                        </div>
                                        <p class="card-text">
                                           {{ $add->address }}
                                        </p>
                                        <button class="btn btn-outline-primary btn-sm">{{__('Does not deliver here')}}</button>
                                    </div>
                                </div>
                            </div> --}}
                                @endforeach

                            </div>

                            <button type="button" class="btn btn-outline-primary mb-lg-auto mb-4" data-toggle="modal"
                                data-target="#exampleModal">{{__('Add New Address')}}</button>

                        </div>

                        @if ('delvery_method' != 'delivery')
                            <div class="checkout-delivery-address" id="pick1">
                                <h6 class="checkout-title">{{__('Pick up')}}</h6>

                                @if (session('restaurant'))
                                    <p>{{"This is a Pickup order. You'll need to go to"}}
                                        <strong>{{ session('restaurant')['name'] }}</strong> {{__('to
                                        pick up this order.
                                        Pick up at')}}
                                        .{{ session('restaurant')['addess'] }}
                                       </strong>
                                    </p>
                                @endif

                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 cart-col">
                        <div class="cart d-none d-md-block">
                            <div class="cart-head">
                                <span>{{__('Your order')}}</span>
                            </div>
                            @php $total = 0 @endphp
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $details)
                                    @php
                                        $total = 0;
                                        $total += $details['price'] * $details['quantity'];
                                    @endphp
                                    <div class="cart-body">
                                        <div class="cart-item">
                                            <div class="details">
                                                <h6> {{ $details['name'] }}</h6>


                                            </div>
                                            <div class="price">
                                                <h6>${{ $total }}.00</h6>

                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                            <div class="cart-footer">
                                @php $total = 0 @endphp
                                @foreach ((array) session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                @endforeach
                                <ul>
                                    <li>
                                        <h5>
                                            <span>{{__('SubTotal')}}</span>
                                            <span class="float-right">${{ $total }}.00</span>
                                        </h5>
                                    </li>
                                    <li>
                                        <p>
                                            <span>{{__('Delivery fee')}}</span>
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
                                    <li>
                                        <p>
                                            <span>{{__('Please keep the exact change for ')}}<b>${{ $total }}</b> {{__('handy to
                                                help us serve you better')}}.</span>

                                        </p>
                                    </li>
                                    <button class="btn btn-primary mt-3 w-100"
                                        onclick="window.location.href='{{ route('order') }}';">{{__('Checkout')}}</button>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Address Modal -->
    <div class="modal fade address-model" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x btn-close"></i>
                    </button>
                    <h5 class="mb-4">{{ __('Add Delivery Address') }}</h5>
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                    <form method="post" action="{{ route('address_store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <input type="text" name="longitude" class="form-control" value="-94.22213"
                                        placeholder="Ex : -94.22213" readonly>
                                    @if ($errors->has('longitude'))
                                        <span class="text-danger">{{ $errors->first('longitude') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" name="latitude" class="form-control" value="103.344322"
                                        placeholder="Ex : 103.344322" readonly>
                                    @if ($errors->has('latitude'))
                                        <span class="text-danger">{{ $errors->first('latitude') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div id="map"></div>
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="contact_person_name" class="form-control"
                                    placeholder="{{ __('Contact person name') }}">
                                @if ($errors->has('contact_person_name'))
                                    <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6">
                                <x-tel-input id="contact_person_number" name="contact_person_number"
                                    placeholder="{{ __('Ex : 017********') }}" required class="form-control" />
                                @if ($errors->has('contact_person_name'))
                                    <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="text" name="address" class="form-control"
                                    placeholder="{{ __('Address/Street') }}">
                                @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-lg-12">
                                <select name="address_type" id="address_type" class="form-control">

                                    <option value="0" disabled selected>{{ __('Address Type') }}</option>

                                    <option value="Home">{{ __('Home') }}</option>

                                    <option value="Office">{{ __('Office') }}</option>

                                    <option value="Other">{{ __('Other') }}</option>

                                </select>
                                @if ($errors->has('address_type'))
                                    <span class="text-danger">{{ $errors->first('address_type') }}</span>
                                @endif
                            </div>
                           
                            <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                <button type="button" class="btn btn-outline-primary w-100" data-dismiss="modal"
                                    aria-label="Close">{{__('Close')}}</button>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <button class="btn btn-secondary w-100">{{__('Save changes')}}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Address EDIT Modal -->
    @foreach ($address as $value)
        <div class="modal fade  " id="exampleModal{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x btn-close"></i>
                        </button>
                        <h5 class="mb-4">{{ __('Edit Delivery Address') }}</h5>
                        <form method="post" action="{{ route('update_address', $value->id) }}"
                            enctype="multipart/form-data">
                            <div class="form-row">
                                @csrf
                                @method('PATCH')
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                <div class="form-group col-lg-6">
                                    <input type="text" name="longitude" class="form-control" id="longitude"
                                        value="{{ $value->longitude }}" readonly>
                                    @error('location')
                                        <p style="color:red">{{ $errors->first('location') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="latitude" class="form-control" readonly
                                        value="{{ $value->latitude }}">
                                    @error('latitude')
                                        <p style="color:red">{{ $errors->first('latitude') }}
                                        @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <input type="text" name="contact_person_name" class="form-control"
                                        placeholder="{{ __('Full name') }}"
                                        value="{{ $value->contact_person_name }}">
                                    @error('contact_person_name')
                                        <p style="color:red">{{ $errors->first('contact_person_name') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <x-tel-input id="contact_person_number" name="contact_person_number"
                                        value="{{ $value->contact_person_number }}" required class="form-control" />
                                    @error('contact_person_number')
                                        <p style="color:red">{{ $errors->first('contact_person_number') }}
                                        @enderror
                                </div>

                                <div class="form-group col-lg-12">
                                    <input type="text" name="address" class="form-control"
                                        placeholder="{{ __('Address') }}" value="{{ $value->address }}">
                                    @error('address')
                                        <p style="color:red">{{ $errors->first('address') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <select name="address_type" id="address_type" class="form-control">

                                        <option value="0" disabled selected>{{ __('Address Type') }}</option>

                                        <option value="Home" {{ $value->home === __('Home') ? 'selected' : '' }}>
                                            {{ __('Home') }}
                                        </option>

                                        <option value="Office" {{ $value->home === __('Office') ? 'selected' : '' }}>
                                            {{ __('Office') }}</option>

                                        <option value="Other" {{ $value->home === __('Other') ? 'selected' : '' }}>
                                            {{ __('Other') }}</option>

                                    </select>
                                </div>

                                <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                    <button type="button" class="btn btn-outline-primary w-100" data-dismiss="modal"
                                        aria-label="Close">{{__('Close')}}</button>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <button class="btn btn-secondary w-100">{{__('Save')}}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Address Modal End -->

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                document.getElementById('pick1').style.display = "none";
            })

            function status(select) {
                if (select.value == 'delivery') {
                    document.getElementById('sub1').style.display = "block";
                    document.getElementById('pick1').style.display = "none";

                } else {
                    document.getElementById('sub1').style.display = "none";
                    document.getElementById('pick1').style.display = "block";

                }
            }
        </script>
    @endpush
    </x-app-layout>
