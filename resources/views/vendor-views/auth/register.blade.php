<x-app-layout>

    @section('title', __('Restaurant registration'))

    @push('styles')
        <style>
            #map {
                height: 100%;
            }

            @media only screen and (max-width: 768px) {

                /* For mobile phones: */
                #map {
                    height: 200px;
                }
            }

        </style>
    @endpush


    <!-- Page Header -->

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Restaurant application') }}</h3>
        </div>
    </div>

    <div class="container py-6">
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3 pt-5">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{ route('restaurant.store') }}" method="post" enctype="multipart/form-data"
                    class="js-validate">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="name">{{ __('Restaurant name') }}</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('TIKTAK CASABLANCA RESTAURANT') }}"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="address">{{ __('Restaurant address') }}</label>
                                <textarea type="text" name="address" class="form-control"
                                    placeholder="{{ __('Restaurant address') }}"
                                    required>{{ old('address') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="tax">{{ __('Tax') }} (%)</label>
                                <input type="number" name="tax" class="form-control"
                                    placeholder="{{ __('Tax') }}" min="0" step=".01" required
                                    value="{{ old('tax') }}">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 pr-md-1 px-3">
                                    <label class="input-label"
                                        for="minimum_delivery_time">{{ __('Minimum delivery time') }}</label>
                                    <input type="text" name="minimum_delivery_time" class="form-control"
                                        placeholder="30" pattern="^[0-9]{2}$" required
                                        value="{{ old('minimum_delivery_time') }}">
                                </div>
                                <div class="form-group col-md-6 px-3">
                                    <label class="input-label"
                                        for="maximum_delivery_time">{{ __('Maximum delivery time') }}</label>
                                    <input type="text" name="maximum_delivery_time" class="form-control"
                                        placeholder="40" pattern="[0-9]{2}" required
                                        value="{{ old('maximum_delivery_time') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="input-label">{{ __('Restaurant logo') }}<small style="color: red"> (
                                        {{ __('ratio') }} 1:1
                                        )</small></label>
                                <div class="custom-file">
                                    <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                    <label class="custom-file-label" for="logo">{{ __('Choose file') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" style="margin-top: auto;margin-bottom: auto;">
                            <div class="form-group" style="margin-bottom:0%;">
                                <center>
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                        src="{{ asset('public/assets/admin/img/400x400/img2.jpg') }}"
                                        alt="delivery-man image" />
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="choice_zones">{{ __('Zone') }}<span
                                        class="input-label-secondary"
                                        title="{{ __('Select zone for map') }}"><img
                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="{{ __('Select zone for map') }}"></span></label>
                                <select name="zone_id" id="choice_zones" required class="form-control js-select2-custom"
                                    data-placeholder="{{ __('Select zone') }}">
                                    <option value="" selected disabled>{{ __('Select zone') }}</option>
                                    @foreach (\App\Models\Zone::all() as $zone)
                                        @if (isset(auth('admin')->user()->zone_id))
                                            @if (auth('admin')->user()->zone_id == $zone->id)
                                                <option value="{{ $zone->id }}" selected>{{ $zone->name }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="latitude">{{ __('Latitude') }}<span
                                        class="input-label-secondary"
                                        title="{{ __('Restaurant lat lng warning') }}"><img
                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="{{ __('Restaurant lat lng warning') }}"></span></label>
                                <input type="text" id="latitude" name="latitude" class="form-control"
                                    placeholder="Ex : -94.22213" value="{{ old('latitude') }}" required readonly>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="longitude">{{ __('longitude') }}<span
                                        class="input-label-secondary"
                                        title="{{ __('Restaurant lat lng warning') }}"><img
                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="{{ __('Restaurant lat lng warning') }}"></span></label>
                                <input type="text" name="longitude" class="form-control" placeholder="Ex : 103.344322"
                                    id="longitude" value="{{ old('longitude') }}" required readonly>
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <div id="map"></div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="f_name">{{ __('First name') }}</label>
                                <input type="text" name="f_name" class="form-control"
                                    placeholder="{{ __('First name') }}"
                                    value="{{ old('f_name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="l_name">{{ __('Last name') }}</label>
                                <input type="text" name="l_name" class="form-control"
                                    placeholder="{{ __('Last name') }}"
                                    value="{{ old('l_name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="phone">{{ __('Phone') }}</label>
                                <x-tel-input
                                        id="phone"
                                        name="phone"
                                        placeholder="{{__('Ex : 017********')}}"
                                        value="{{ old('tel') }}"
                                        required
                                        class="form-control"
                                        /> 
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="email">{{ __('email') }}</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Ex : ex@example.com" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleInputPassword">{{ __('password') }}</label>
                                <input type="password" name="password"
                                    class="form-control form-control-user" minlength="6" id="exampleInputPassword"
                                    required value="{{ old('password') }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="js-form-message form-group">
                                <label class="input-label"
                                    for="signupSrConfirmPassword">{{ __('Confirm password') }}</label>
                                <input type="password" name="confirm-password" class="form-control form-control-user"
                                    minlength="6" id="exampleRepeatPassword"
                                    required value="{{ old('confirm-password') }}">
                                <div class="pass invalid-feedback">{{ __('Password not matched') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pb-5">
                            <div class="form-group">
                                <label for="name">{{ __('upload cover photo') }}<span
                                        class="text-danger">({{ __('ratio') }}
                                        2:1)</span></label>
                                <div class="custom-file">
                                    <input type="file" name="cover_photo" id="coverImageUpload"
                                        class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                        for="customFileUpload">{{ __('choose') }}
                                        {{ __('file') }}</label>
                                </div>
                            </div>
                            <center>
                                <img style="max-width: 100%;border: 1px solid; border-radius: 10px; max-height:200px;"
                                    id="coverImageViewer"
                                    src="{{ asset('public/assets/admin/img/900x400/img1.jpg') }}"
                                    alt="Product thumbnail" />
                            </center>
                        </div>
                    </div>

                    <button type="submit" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
@push('scripts')
    <script>
        $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup', function() {
            var pass = $("#exampleInputPassword").val();
            var passRepeat = $("#exampleRepeatPassword").val();
            if (pass == passRepeat) {
                $('.pass').hide();
            } else {
                $('.pass').show();
            }
        });


        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#' + viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this, 'viewer');
        });

        $("#coverImageUpload").change(function() {
            readURL(this, 'coverImageViewer');
        });
    </script>

    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/admin/img/400x400/img2.jpg') }}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error('{{ __('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ __('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
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
        var zonePolygon = null;
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get Lat/Lng!",
            position: myLatlng,
        });
        var bounds = new google.maps.LatLngBounds();

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
            infoWindow.open(map);
        }
        $('#choice_zones').on('change', function() {
            var id = $(this).val();
            $.get({
                url: '{{ url('/') }}/admin/zone/get-coordinates/' + id,
                dataType: 'json',
                success: function(data) {
                    if (zonePolygon) {
                        zonePolygon.setMap(null);
                    }
                    zonePolygon = new google.maps.Polygon({
                        paths: data.coordinates,
                        strokeColor: "#FF0000",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: 'white',
                        fillOpacity: 0,
                    });
                    zonePolygon.setMap(map);
                    zonePolygon.getPaths().forEach(function(path) {
                        path.forEach(function(latlng) {
                            bounds.extend(latlng);
                            map.fitBounds(bounds);
                        });
                    });
                    map.setCenter(data.center);
                    google.maps.event.addListener(zonePolygon, 'click', function(mapsMouseEvent) {
                        infoWindow.close();
                        // Create a new InfoWindow.
                        infoWindow = new google.maps.InfoWindow({
                            position: mapsMouseEvent.latLng,
                            content: JSON.stringify(mapsMouseEvent.latLng.toJSON(),
                                null, 2),
                        });
                        var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null,
                            2);
                        var coordinates = JSON.parse(coordinates);

                        document.getElementById('latitude').value = coordinates['lat'];
                        document.getElementById('longitude').value = coordinates['lng'];
                        infoWindow.open(map);
                    });
                },
            });
        });
    </script>
@endpush
