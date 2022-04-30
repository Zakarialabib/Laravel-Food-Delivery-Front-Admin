<x-app-layout>
@section('title', __('Address'))

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Manage Addresses') }}</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">

            <div class="row">
                @include('partials.sidebar')
                <div class="col-lg-9">
                    <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        <div class="my-account-content">
                            @foreach ($address as $value)
                                @if (Auth::user()->id == $value->customer_id)
                                    <div class="col-md-6">
                                        <div class="card address-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $value->home }}</h5>
                                                <h6> {{ $value->house_name }} , {{ $value->area }},
                                                    {{ $value->city }},
                                                    {{ $value->pincode }}</h6>
                                                <p class="card-text">
                                                    {{ $value->landmark }}
                                                </p>
                                                <button type="button" class="btn-link" id="edit-item"
                                                    data-toggle="modal" data-target="#exampleModal{{ $value->id }}">
                                                    <i class='bx bx-edit'></i>{{ __('Edit') }}</button>
                                                <button class="btn-link"><i class='bx bx-trash'></i>

                                                    <a href="{{ route('address_destroy', $value->id) }}"
                                                        style="color:#CC0000">
                                                        {{ __('Delete') }}</a></button>

                                                @if ($value->default == 0)
                                                    <button class="btn-link"><i class='bx bx-location-plus'></i><a
                                                            href="{{ route('default', $value->id) }}"
                                                            style="color:#CC0000">{{ __('Set as default') }}</a></button>
                                                @else
                                                    <button class="btn-link"><i class='bx bx-location-plus'></i><a
                                                            href="{{ route('removedefault', $value->id) }}"
                                                            style="color:#CC0000">{{ __('Remove default') }}</a></button>
                                                @endif

                                                <!-- <a href="#" class=""><i class='bx bx-trash' ></i>Delete</a> -->
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <div class="flex justify-center">

                            <button type="button" class="btn btn-outline-primary  mb-4" data-toggle="modal"
                                data-target="#exampleModal">{{ __('Add Address') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

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

                                <div class="form-group col-lg-12">
                                    <input type="text" name="location" class="form-control" id="location"
                                        placeholder="Location" value="{{ $value->location }}">
                                    @error('location')
                                        <p style="color:red">{{ $errors->first('location') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="house_name" class="form-control"
                                        placeholder="{{__('House Name / Flat / Building')}}" value="{{ $value->house_name }}">
                                    @error('house_name')
                                        <p style="color:red">{{ $errors->first('house_name') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="area" class="form-control" placeholder="{{__('Area / Street')}}"
                                        value="{{ $value->area }}">
                                    @error('area')
                                        <p style="color:red">{{ $errors->first('area') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="city" class="form-control" placeholder="{{__('City')}}"
                                        value="{{ $value->city }}">
                                    @error('city')
                                        <p style="color:red">{{ $errors->first('city') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="landmark" class="form-control" placeholder="{{__('Landmark')}}"
                                        value="{{ $value->landmark }}">
                                    @error('landmark')
                                        <p style="color:red">{{ $errors->first('landmark') }}
                                        @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <input type="text" name="pincode" class="form-control" placeholder="{{__('Zip code')}}"
                                        value="{{ $value->pincode }}">
                                    @error('pincode')
                                        <p style="color:red">{{ $errors->first('pincode') }}
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <select name="home" id="home" class="form-control">

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
                                <div class="form-group col-lg-12">
                                    <textarea class="form-control" name="note_a_driver" id="note_A_driver" rows="3" cols="6" placeholder="{{__('Note for Driver')}}"
                                        value="{{ $value->note }}">{{ $value->note_a_driver }}</textarea>
                                </div>

                                <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                    <button type="button" class="btn btn-outline-primary w-100" data-dismiss="modal"
                                        aria-label="Close">{{ __('Close') }}</button>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <button class="btn btn-secondary w-100">{{ __('Save') }}</button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    <!-- Address Modal End -->
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

                                    <option value="0" disabled selected>{{ __('Address Type') }}</option>

                                    <option value="Home">{{ __('Home') }}</option>

                                    <option value="Office">{{ __('Office') }}</option>

                                    <option value="Other">{{ __('Other') }}</option>

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
                                    aria-label="Close">{{ __('Close') }}</button>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <button class="btn btn-secondary w-100">{{ __('Save changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Modal End -->

</x-app-layout>
