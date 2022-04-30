@extends('layouts.app')
@section('content')


    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">My Account</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">

            <div class="row">

                <div class="col-lg-3">

                    <div class="my-account-menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link {{ Request::is('customer/order_history') ? 'active' : '' }}"
                                href="{{ route('order_history') }}" role="tab" aria-controls="v-pills-profile"
                                aria-selected="false"><i class='bx bxs-cart'></i> Orders</a>

                            <!-- <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-wishlist"
                                role="tab" aria-controls="v-pills-messages" aria-selected="false"><i
                                    class='bx bxs-heart'></i> Wishlist</a> -->
                            <a class="nav-link {{ Request::is('customer/address') ? 'active' : '' }}"
                                href="{{ route('address') }}" role="tab" aria-controls="v-pills-messages"
                                aria-selected="false"><i class='bx bxs-home-smile'></i> Addresses</a>
                            <a class="nav-link {{ Request::is('customer/account') ? 'active' : '' }}"
                                href="{{ route('account') }}" role="tab" aria-controls="v-pills-settings"
                                aria-selected="false"><i class='bx bxs-user-rectangle'></i> Account Details</a>
                            <a class="nav-link {{ Request::is('customer/change_password') ? 'active' : '' }}"
                                href="{{ route('show_password') }}" role="tab" aria-controls="v-pills-settings"
                                aria-selected="false"><i class='bx bxs-wallet-alt'></i> Change Password</a>
                            <a class="nav-link" href="{{ route('logout') }}" role="tab"
                                aria-controls="v-pills-settings" aria-selected="false"><i class='bx bxs-log-out'></i>
                                Logout</a>
                            <!-- <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-no-orders"
                                role="tab" aria-controls="v-pills-settings" aria-selected="false"><i
                                    class='bx bxs-log-out'></i> No Orders</a> -->
                        </div>
                    </div>

                </div>
                @yield('order_history')
                @yield('content')
                @yield('change_password')
                @yield('address')


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
                                            <input type="text" name="location" class="form-control"
                                                placeholder="Location">
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
                                            <input type="text" name="landmark" class="form-control"
                                                placeholder="Landmark">
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
                                            <input type="text" name="note_a_driver" id="note_a_driver"
                                                class="form-control" placeholder="Note for Driver">
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

                <!-- Address Modal End -->

            </div>

        </div>
    </section>
@endsection
