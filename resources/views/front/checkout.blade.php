<x-app-layout>
@section('content')
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Checkout</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <form method="post" action="/customer/order/store" enctype="multipart/form-data">
                @csrf
                <div class="row cuisine-dish-wrap">
                    <div class="col-lg-8 cuisine-col">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <h6 class="checkout-title">Delivery Type</h6>
                                <select class="form-control " name="delivery_method" id="select"
                                    onchange="status(this)">
                                    <option value="delivery" selected="delivery">Delivery</option>
                                    <option value="pickup">Pickup</option>
                                </select>
                            </div>
                        </div>
                        <h6 class="checkout-title">Payment</h6>
                        <div class="form-group col-lg-12">
                            <div class="custom-radio">
                                <input type="radio" id="radio1" name="payment-type" checked="checked">
                                <label for="radio1">Pay via Cash</label>
                                <img src="{{ asset('assets/images/cash.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="checkout-delivery-address food-item-cards-wrap" id="sub1">
                            <h6 class="checkout-title">Delivery Address</h6>
                            <div class="row">
                                @foreach ($address as $add)
                                    <div class="col-xl-6">
                                        <div class="card address-card">
                                            <div class="card-body deliverable">
                                                <div class="delivery">
                                                    @if ($add->default == 1)
                                                        <i class='bx bxs-check-circle'></i>
                                                    @endif

                                                    <h5 class="card-title">{{ $add->home }}</h5>
                                                </div>
                                                <h6>{{ $add->location }}, {{ $add->pincode }}</h6>
                                                <p class="card-text">
                                                    {{ $add->landmark }}

                                                </p>
                                                @if (!session('address'))
                                                    <button class="btn btn-primary btn-sm"><a
                                                            href="{{ route('addressStore', $add->id) }} "
                                                            style="color:white">Deliver here</a></button>
                                                @else
                                                    <button class="btn btn-primary btn-sm"><a
                                                            href="{{ route('addressStore', $add->id) }} "
                                                            style="color:white">Delivered here</a></button>
                                                @endif
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    id="edit-item" data-toggle="modal"
                                                    data-target="#exampleModal{{ $add->id }}">
                                                    Edit</button> {{ session()->get('location') }}
                                                <button class="btn btn-outline-primary btn-sm">
                                                    <a href="{{ route('address_destroy', $add->id) }}">
                                                        Delete</a></button>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-6">
                                <div class="card address-card">
                                    <div class="card-body unavailable">
                                        <div class="delivery ">
                                            <i class='bx bxs-x-circle'></i>
                                            <h5 class="card-title">{{ $add->home }}</h5>
                                        </div>
                                        <h6>{{ $add->location }}, {{ $add->pincode }}</h6>
                                        <p class="card-text">
                                           {{ $add->landmark }}
                                          
                                        </p>
                                        <button class="btn btn-outline-primary btn-sm">Does not deliver here</button>
                                    </div>
                                </div>
                            </div> -->
                                @endforeach

                            </div>

                            <button type="button" class="btn btn-outline-primary mb-lg-auto mb-4" data-toggle="modal"
                                data-target="#exampleModal">Add New Address</button>

                        </div>

                        @if ('delvery_method' != 'delivery')
                            <div class="checkout-delivery-address" id="pick1">
                                <h6 class="checkout-title">Pick up</h6>

                                @if (session('restaurant'))
                                    <p>This is a Pickup order. You'll need to go to
                                        <strong>{{ session('restaurant')['name'] }}</strong> to
                                        pick up this order.
                                        Pick up at
                                        <strong>{{ session('restaurant')['location'] }}</strong>.{{ session('restaurant')['addess'] }}
                                        <strong>{{ session('restaurant')['mobile'] }}</strong>
                                    </p>
                                @endif

                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 cart-col">
                        <div class="cart d-none d-md-block">
                            <div class="cart-head">
                                <span>Your order</span>
                            </div>
                            @php $total = 0 @endphp
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $details)
                                    @php
                                        $total = 0;
                                        $total += $details['rate'] * $details['quantity'];
                                    @endphp
                                    <div class="cart-body">
                                        <div class="cart-item">
                                            <div class="details">
                                                <h6> {{ $details['food_item'] }}</h6>


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
                                            <span>Delivery fee</span>
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
                                    <li>
                                        <p>
                                            <span>Please keep the exact change for <b>${{ $total }}</b> handy to
                                                help us serve you better.</span>

                                        </p>
                                    </li>
                                    <button class="btn btn-primary mt-3 w-100"
                                        onclick="window.location.href='{{ route('order') }}';">Checkout</button>
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
                    <h5 class="mb-4">Add Delivery Address</h5>
                    @section('content')
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

                                <div class="form-group col-lg-12">
                                    <input type="text" name="location" class="form-control" placeholder="Location">
                                    @if ($errors->has('location'))
                                        <span class="text-danger">{{ $errors->first('location') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="house_name" class="form-control"
                                        placeholder="House Name/Flat No/Building">
                                    @if ($errors->has('house_name'))
                                        <span class="text-danger">{{ $errors->first('house_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="area" class="form-control" placeholder="Area/Street">
                                    @if ($errors->has('area'))
                                        <span class="text-danger">{{ $errors->first('area') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="city" class="form-control" placeholder="City">
                                    @if ($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="landmark" class="form-control" placeholder="Landmark">
                                    @if ($errors->has('landmark'))
                                        <span class="text-danger">{{ $errors->first('landmark') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="pincode" class="form-control" placeholder="Pincode">
                                    @if ($errors->has('pincode'))
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <select name="home" id="home" class="form-control">

                                        <option value="0" disabled selected>Address Type</option>

                                        <option value="Home">Home</option>

                                        <option value="Office">Office</option>

                                        <option value="Other">Other</option>

                                    </select>
                                    @if ($errors->has('home'))
                                        <span class="text-danger">{{ $errors->first('home') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="note_a_driver" id="note_a_driver" class="form-control"
                                        placeholder="Note for Driver">
                                    @if ($errors->has('note_a_driver'))
                                        <span class="text-danger">{{ $errors->first('note_a_driver') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                    <button type="button" class="btn btn-outline-primary w-100" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <button class="btn btn-secondary w-100">Save changes</button>
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
                            <h5 class="mb-4">Edit Delivery Address</h5>


                            <form method="post" action="{{ route('update_address', $value->id) }}"
                                enctype="multipart/form-data">
                                <div class="form-row">
                                    @csrf
                                    @method('PATCH')
                                    <!-- @if (Session::get('success'))
    <div class="alert alert-success">
                                                     {{ Session::get('success') }}
                                                   </div>
    @endif -->

                                    <div class="form-group col-lg-12">
                                        <input type="text" name="location" class="form-control" id="location"
                                            placeholder="Location" value="{{ $value->location }}">
                                        @error('location')
                                            <p style="color:red">{{ $errors->first('location') }}
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="text" name="house_name" class="form-control"
                                            placeholder="House Name / Flat / Building" value="{{ $value->house_name }}">
                                        @error('house_name')
                                            <p style="color:red">{{ $errors->first('house_name') }}
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="area" class="form-control" placeholder="Area / Street"
                                            value="{{ $value->area }}">
                                        @error('area')
                                            <p style="color:red">{{ $errors->first('area') }}
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="city" class="form-control" placeholder="City"
                                            value="{{ $value->city }}">
                                        @error('city')
                                            <p style="color:red">{{ $errors->first('city') }}
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="text" name="landmark" class="form-control" placeholder="Landmark"
                                            value="{{ $value->landmark }}">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input type="text" name="pincode" class="form-control" placeholder="Pincode"
                                            value="{{ $value->pincode }}">
                                        @error('pincode')
                                            <p style="color:red">{{ $errors->first('pincode') }}
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <select name="home" id="home" class="form-control">

                                            <option value="0" disabled selected>Address Type</option>

                                            <option value="Home" {{ $value->home === 'Home' ? 'selected' : '' }}>Home
                                            </option>

                                            <option value="Office" {{ $value->home === 'Office' ? 'selected' : '' }}>
                                                Office</option>

                                            <option value="Other" {{ $value->home === 'Other' ? 'selected' : '' }}>Other
                                            </option>

                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <textarea class="form-control" name="note_a_driver" id="note_A_driver" rows="3" placeholder="Note for Driver"
                                            value="{{ $value->note }}">{{ $value->note_a_driver }}</textarea>
                                    </div>

                                    <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                        <button type="button" class="btn btn-outline-primary w-100" data-dismiss="modal"
                                            aria-label="Close">Close</button>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <button class="btn btn-secondary w-100">Save</button>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
        <!-- Address Modal End -->
@endsection
<x-app-layout>

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
