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
                        <div class="flex flex-wrap -m-5">
                            @foreach ($address as $value)
                                @if (Auth::user()->id == $value->user_id)
                                    <div class="lg:w-1/2 sm:w-full mb-5">
                                        <div class="card address-card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $value->address_type }}</h5>
                                                <p class="text-2xl text-black-500 py-3 leading-3"> {{ $value->longitude }} , {{ $value->latitude }}<br>
                                                    {{ $value->contact_person_name }}<br>
                                                    {{ $value->contact_person_number }}</p>
                                                <p class="text-2xl text-black-500  pb-5">
                                                    {{ $value->address }}
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
                                data-target="#exampleModal">{{ __('Add Address') }}
                            </button>
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
                                    <input id="contact_person_number" name="contact_person_number" value="{{ $value->contact_person_number }}" type="phone" required class="form-control" >
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
                                <input id="contact_person_number" name="contact_person_number" placeholder="{{ __('Ex : 017********') }}" type="phone" required class="form-control" >
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

                            <div class="form-group col-md-12 flex flex-wrap">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal"
                                    aria-label="Close">{{ __('Close') }}</button>
                                <div class="form-group col-md-6 mb-0">
                                    <button class="btn btn-secondary">{{ __('Save changes') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Modal End -->


    @push('scripts')
        <script
                src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&v=3.45.8">
        </script>
        <script>
            @php($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first())
            @php($default_location = $default_location->value ? json_decode($default_location->value, true) : 0)
            let myLatlng = {
                lat: {{ $default_location ? $default_location['lat'] : '23.757989' }},
                lng: {{ $default_location ? $default_location['lng'] : '90.360587' }}
            };
            let map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: myLatlng,
            });
            let infoWindow = new google.maps.InfoWindow({
                content: "Click the map to get Lat/Lng!",
                position: myLatlng,
            });

            function initMap() {
                // Create the initial InfoWindow.
                infoWindow.open(map);
                //get current location block
                infoWindow = new google.maps.InfoWindow();
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            myLatlng = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            infoWindow.setPosition(myLatlng);
                            infoWindow.setContent("Location found.");
                            infoWindow.open(map);
                            map.setCenter(myLatlng);
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter());
                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
                //-----end block------
            }
            initMap();

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation ?
                    "Error: The Geolocation service failed." :
                    "Error: Your browser doesn't support geolocation."
                );
            }
        </script>
    @endpush
</x-app-layout>
