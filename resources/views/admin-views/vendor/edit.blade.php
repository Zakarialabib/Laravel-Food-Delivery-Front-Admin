@extends('layouts.admin.app')

@section('title', __('Update restaurant info'))

@push('css_or_js')
<style>
    #map{
        height: 100%;
    }
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        #map{
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> {{__('update restaurant')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.vendor.update',[$restaurant['id']])}}" method="post" class="js-validate"
                      enctype="multipart/form-data">
                    @csrf

                    
                    <small class="nav-subtitle text-secondary border-bottom">{{__('Restaurant info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="name">{{__('Restaurant name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{__('First name')}}"
                                       required value="{{$restaurant->name}}">
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="address">{{__('Restaurant address')}}</label>
                                <textarea  type="text" name="address" class="form-control" placeholder="{{__('Restaurant address')}}"
                                       required>{{$restaurant->address}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="address">{{__('vat/tax')}} (%)</label>
                                <input type="number" name="tax" class="form-control" placeholder="{{__('vat/tax')}}" min="0" step=".01" required value="{{$restaurant->tax}}">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="input-label" for="minimum_delivery_time">{{__('Minimum delivery time')}}</label>
                                    <input type="text" name="minimum_delivery_time" class="form-control" placeholder="30" pattern="^[0-9]{2}$" required value="{{explode('-',$restaurant->delivery_time)[0]}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="input-label" for="maximum_delivery_time">{{__('Maximum delivery time')}}</label>
                                    <input type="text" name="maximum_delivery_time" class="form-control" placeholder="40" pattern="[0-9]{2}" required value="{{explode('-',$restaurant->delivery_time)[1]}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="input-label">{{__('Restaurant logo')}}<small style="color: red"> ( {{__('ratio')}} 1:1 )</small></label>
                                <div class="custom-file">
                                    <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{__('Choose file')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" style="margin-top: auto;margin-bottom: auto;">
                            <div class="form-group" style="margin-bottom:0%;">                       
                                <center>
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                        src="{{asset('storage/app/public/restaurant').'/'.$restaurant->logo}}" alt="delivery-man image"/>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="choice_zones">{{__('Zone')}}<span
                                        class="input-label-secondary" title="{{__('Select zone for map')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('Select zone for map')}}"></span></label>
                                <select name="zone_id" id="choice_zones" onchange="get_zone_data(this.value)" data-placeholder="{{__('Select zone')}}"
                                        class="form-control js-select2-custom">
                                    @foreach(\App\Models\Zone::all() as $zone)
                                        @if(isset(auth('admin')->user()->zone_id))
                                            @if(auth('admin')->user()->zone_id == $zone->id)
                                                <option value="{{$zone->id}}" {{$restaurant->zone_id == $zone->id? 'selected': ''}}>{{$zone->name}}</option>
                                            @endif
                                        @else
                                            <option value="{{$zone->id}}" {{$restaurant->zone_id == $zone->id? 'selected': ''}}>{{$zone->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Latitude')}}<span
                                        class="input-label-secondary" title="{{__('Restaurant lat lng warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('Restaurant lat lng warning')}}"></span></label>
                                <input type="text"
                                       name="latitude" class="form-control" id="latitude"
                                       placeholder="Ex : -94.22213" value="{{$restaurant->latitude}}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Longitude')}}<span
                                        class="input-label-secondary" title="{{__('Restaurant lat lng warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('Restaurant lat lng warning')}}"></span></label>
                                <input type="text"
                                       name="longitude" class="form-control" id="longitude"
                                       placeholder="Ex : 103.344322" value="{{$restaurant->longitude}}" readonly>
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <div id="map"></div>
                        </div>

                        {{--<div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="">
                                    <i class="tio-info-outined"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="This value is the radius from your restaurant location, and customer can order food inside  the circle calculated by this radius."></i>
                                    {{__('coverage')}} ( {{__('km')}} )
                                </label>
                                <input type="number" value=""
                                       name="coverage" class="form-control" placeholder="Ex : 3">
                            </div>
                        </div>--}}
                    </div>
                    <div class="form-group">
                        <label for="name">{{__('upload cover photo')}} <span class="text-danger">({{__('ratio')}} 2:1)</span></label>
                        <div class="custom-file">
                            <input type="file" name="cover_photo" id="coverImageUpload" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                            <label class="custom-file-label" for="customFileUpload">{{__('Choose file')}}</label>
                        </div>
                    </div> 
                    <center>
                        <img style="max-width: 100%;border: 1px solid; border-radius: 10px; max-height:200px;" id="coverImageViewer"
                        onerror="this.src='{{asset('public/assets/admin/img/900x400/img1.jpg')}}'"
                        src="{{asset('storage/app/public/restaurant/cover/'.$restaurant->cover_photo)}}" alt="Product thumbnail"/>
                    </center>  
                    
                    <br>
                    <small class="nav-subtitle text-secondary border-bottom">{{__('vendor info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('First name')}}</label>
                                <input type="text" name="f_name" class="form-control" placeholder="{{__('First name')}}" value="{{$restaurant->vendor->f_name}}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Last name')}}</label>
                                <input type="text" name="l_name" class="form-control" placeholder="{{__('Last name')}}"
                                value="{{$restaurant->vendor->l_name}}"  required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Phone')}}</label>
                                <input type="text" name="phone" class="form-control" placeholder="Ex : 017********"
                                value="{{$restaurant->phone}}"   required>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    <small class="nav-subtitle text-secondary border-bottom">{{__('login info')}}</small>
                    <br>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Email')}}</label>
                                <input type="email" name="email" class="form-control" placeholder="Ex : ex@example.com" value="{{$restaurant->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrPassword">Password</label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control" name="password" id="signupSrPassword" placeholder="{{__('Password length placeholder',['length'=>'6+'])}}" aria-label="6+ characters required"
                                    data-msg="Your password is invalid. Please try again."
                                    data-hs-toggle-password-options='{
                                    "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                    }'>
                                    <div class="js-toggle-password-target-1 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrConfirmPassword">Confirm password</label>

                                <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control" name="confirmPassword" id="signupSrConfirmPassword" placeholder="{{__('Password length placeholder', ['length'=>'6+'])}}" aria-label="6+ characters required"                                      data-msg="Password does not match the confirm password."
                                        data-hs-toggle-password-options='{
                                        "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                        }'>
                                <div class="js-toggle-password-target-2 input-group-append">
                                    <a class="input-group-text" href="javascript:;">
                                    <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+viewer).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
        });

        $("#coverImageUpload").change(function () {
            readURL(this, 'coverImageViewer');
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8"></script>
    <script> 
        let myLatlng = { lat: {{$restaurant->latitude}}, lng: {{$restaurant->longitude}} };
        const map = new google.maps.Map(document.getElementById("map"), {
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
            new google.maps.Marker({
                position: { lat: {{$restaurant->latitude}}, lng: {{$restaurant->longitude}} },
                map,
                title: "{{$restaurant->name}}",
            });
            infoWindow.open(map);            
        }
        initMap();
        function get_zone_data(id)
        {
            $.get({
                url: '{{url('/')}}/admin/zone/get-coordinates/'+id,
                dataType: 'json',
                success: function (data) {
                    if(zonePolygon)
                    {
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
                    map.setCenter(data.center);
                    google.maps.event.addListener(zonePolygon, 'click', function (mapsMouseEvent) {
                        infoWindow.close();
                        // Create a new InfoWindow.
                        infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                        content: JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
                        });
                        var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                        var coordinates = JSON.parse(coordinates);

                        document.getElementById('latitude').value = coordinates['lat'];
                        document.getElementById('longitude').value = coordinates['lng'];
                        infoWindow.open(map);
                    });    
                },
            });
        }
        $(document).on('ready', function (){
            var id = $('#choice_zones').val();
            $.get({
                url: '{{url('/')}}/admin/zone/get-coordinates/'+id,
                dataType: 'json',
                success: function (data) {
                    if(zonePolygon)
                    {
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
                    google.maps.event.addListener(zonePolygon, 'click', function (mapsMouseEvent) {
                        infoWindow.close();
                        // Create a new InfoWindow.
                        infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                        content: JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
                        });
                        var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                        var coordinates = JSON.parse(coordinates);

                        document.getElementById('latitude').value = coordinates['lat'];
                        document.getElementById('longitude').value = coordinates['lng'];
                        infoWindow.open(map);
                    });    
                },
            });
        });
    </script>
<script>
      $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
          new HSTogglePassword(this).init()
        });


        // INITIALIZATION OF FORM VALIDATION
        // =======================================================
        $('.js-validate').each(function() {
          $.HSCore.components.HSValidation.init($(this), {
            rules: {
              confirmPassword: {
                equalTo: '#signupSrPassword'
              }
            }
          });
        });

        get_zone_data({{$restaurant->zone_id}});
      });
    </script>
@endpush
