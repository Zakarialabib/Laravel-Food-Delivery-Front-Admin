@extends('layouts.admin.app')

@section('title',$restaurant->name)

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
    <style>
        .flex-item{
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item{
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item{
                flex: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Vendor view')}}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-6">
                <h1 class="page-header-title text-break">{{$restaurant->name}}</h1>
            </div>
            <div class="col-6">
                @if($restaurant->vendor->status)
                <a href="{{route('admin.vendor.edit',[$restaurant->id])}}" class="btn btn-primary float-right">
                    <i class="tio-edit"></i> {{__('Edit restaurant')}}
                </a>
                @else
                    @if(!isset($restaurant->vendor->status))
                    <a class="btn btn-danger text-capitalize font-weight-bold float-right" 
                    onclick="request_alert('{{route('admin.vendor.application',[$restaurant['id'],0])}}','{{__('You want to deny this application')}}')"
                        href="javascript:">{{__('deny')}}</a>
                    @endif
                    <a class="btn btn-primary text-capitalize font-weight-bold float-right mr-2"
                    onclick="request_alert('{{route('admin.vendor.application',[$restaurant['id'],1])}}','{{__('You want to approve this application')}}')"
                        href="javascript:">{{__('Approve')}}</a>
                @endif
            </div>
        </div>
        @if($restaurant->vendor->status)
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.vendor.view', $restaurant->id)}}">{{__('Restaurant')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'order'])}}"  aria-disabled="true">{{__('Order')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'product'])}}"  aria-disabled="true">{{__('Food')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'discount'])}}"  aria-disabled="true">{{__('Discount')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'settings'])}}"  aria-disabled="true">{{__('Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{__('transaction')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'reviews'])}}"  aria-disabled="true">{{__('Reviews')}}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
        @endif
    </div>
        <!-- End Page Header -->
    <!-- Page Heading -->
    <div class="row my-2">
        <!-- Earnings (Monthly) Card Example -->
        <div class="for-card col-md-4 mb-1">
            <div class="card for-card-body-2 shadow h-100 text-white"  style="background: #8d8d8d;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase for-card-text mb-1">
                                {{__('Collected cash by restaurant')}}
                            </div>
                            <div
                                class="for-card-count">{{$wallet->collected_cash}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"  style="background: #8d8d8d; border:none;">
                        <a class="btn w-100" style="background: #f9fafc;" href="{{route('admin.account-transaction.index')}}" title="{{__('goto account transaction')}}">{{__('Collect cash from restaurant')}}</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <!-- Panding Withdraw Card Example -->
                <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="card  shadow h-100 for-card-body-3  badge-secondary" >
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class=" font-weight-bold for-card-text text-uppercase mb-1">{{__('Pending withdraw')}}</div>
                                    <div
                                        class="for-card-count">{{$wallet->pending_withdraw}}</div>
                                </div>
                                <div class="col-auto for-margin">
                                    <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="card  shadow h-100 for-card-body-3 text-white"  style="background: #2C2E43;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class=" font-weight-bold for-card-text text-uppercase mb-1">{{__('withdrawn')}}</div>
                                    <div
                                        class="for-card-count">{{$wallet->total_withdrawn}}</div>
                                </div>
                                <div class="col-auto for-margin">
                                    <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collected Cash Card Example -->
                <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="card r shadow h-100 for-card-body-4  badge-dark">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class=" for-card-text font-weight-bold  text-uppercase mb-1">{{__('Withdraw able balance')}}</div>
                                    <div
                                        class="for-card-count">{{$wallet->balance}}</div>
                                </div>
                                <div class="col-auto for-margin">
                                    <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                    <div class="card r shadow h-100 for-card-body-4 text-white" style="background:#362222;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class=" for-card-text font-weight-bold  text-uppercase mb-1">{{__('Total earning')}} </div>
                                    <div
                                        class="for-card-count">{{$wallet->total_earning}}</div>
                                </div>
                                <div class="col-auto for-margin">
                                    <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
    </div>
    <div class="card my-2">
        <div class="card-body">
            <div class="row align-items-md-center gx-md-5" id="restaurant_details">
                <div class="col-md-auto mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <img class="avatar avatar-xxl avatar-4by3 mr-4"
                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                        src="{{asset('storage/app/public/restaurant')}}/{{$restaurant->logo}}"
                                alt="{{$restaurant->name}} Logo">
                        
                    </div>
                </div>

                <div class="col-md">
                    <ul class="list-unstyled list-unstyled-py-2 mb-0">
                    @php($ratings = $restaurant->rating)
                    @php($five = $ratings[0])
                    @php($four = $ratings[1])
                    @php($three = $ratings[2])
                    @php($two = $ratings[3])
                    @php($one = $ratings[4])
                    @php($total_rating = $one+$two+$three+$four+$five)
                    @php($total_rating = $total_rating==0?1:$total_rating)
                    <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span
                                class="mr-3">5 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: {{($five/$total_rating)*100}}%;"
                                        aria-valuenow="{{($five/$total_rating)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$five}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="mr-3">4 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: {{($four/$total_rating)*100}}%;"
                                        aria-valuenow="{{($four/$total_rating)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$four}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="mr-3">3 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: {{($five/$total_rating)*100}}%;"
                                        aria-valuenow="{{($five/$total_rating)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$three}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="mr-3">2 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: {{($two/$total_rating)*100}}%;"
                                        aria-valuenow="{{($two/$total_rating)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$two}}</span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                        
                            <span class="mr-3">1 star</span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: {{($one/$total_rating)*100}}%;"
                                        aria-valuenow="{{($one/$total_rating)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3">{{$one}}</span>
                        </li>
                        <!-- End Review Ratings -->
                    </ul>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <div class="card mt-2">
                                <div class="card-header">
                                {{__('Restaurant info')}}
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                                        <li class="pt-2 pb-0">
                                            <small class="card-subtitle">Contact details</small>
                                        </li>
                                        <li>
                                            <i class="tio-city nav-icon"></i>
                                            {{__('Address')}} : {{$restaurant->address}}
                                        </li>

                                        <li>
                                            <i class="tio-online nav-icon"></i>
                                            {{__('Email')}} : {{$restaurant->email}}
                                        </li>
                                        <li>
                                            <i class="tio-android-phone-vs nav-icon"></i>
                                            {{__('Phone')}} : {{$restaurant->phone}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-6">
                            <div class="card mt-2">
                                <div class="card-header">
                                {{__('restaurant location')}}
                                </div>
                                <div class="card-body pt-2 pb-2">
                                    <div id="map" style="height:180px; width:100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="card h-100">
                        <div class="card-header">
                            {{__('Owner info')}}
                        </div>
                        <div class="card-body ">
                            <div class="text-center">
                                <div class="avatar avatar-xxl avatar-circle avatar-border-lg">
                                    <img class="avatar-img" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                src="{{asset('storage/app/public/vendor')}}/{{$restaurant->vendor->image}}" alt="Image Description">
                                </div>
                            
                            
                                <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                                    <li>
                                        <i class="tio-user-outlined nav-icon"></i>
                                        {{$restaurant->vendor->f_name}} {{$restaurant->vendor->l_name}}
                                    </li>
                                    <li>
                                        <i class="tio-online nav-icon"></i>
                                        {{$restaurant->vendor->email}}
                                    </li>
                                    <li>
                                        <i class="tio-android-phone-vs nav-icon"></i>
                                    {{$restaurant->vendor->phone}}
                                    </li>
                                </ul>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                                        <li class="py-0 border-bottom">
                                            <small class="card-subtitle">{{__('Bank info')}} </small>
                                        </li>
                                        @if($restaurant->vendor->bank_name)
                                        <li class="pb-1 pt-1">
                                            {{__('Bank name')}}: {{$restaurant->vendor->bank_name ? $restaurant->vendor->bank_name : 'No Data found'}}
                                        </li>
                                        <li class="pb-1 pt-1">
                                            {{__('Branch')}}  : {{$restaurant->vendor->branch ? $restaurant->vendor->branch : 'No Data found'}}
                                        </li>
                                        <li class="pb-1 pt-1">
                                            {{__('Holder name')}} : {{$restaurant->vendor->holder_name ? $restaurant->vendor->holder_name : 'No Data found'}}
                                        </li>
                                        <li class="pb-1 pt-1">
                                            {{__('Account no')}}  : {{$restaurant->vendor->account_no ? $restaurant->vendor->account_no : 'No Data found'}}
                                        </li>
                                        @else
                                        <li class="my-auto">
                                            <center class="card-subtitle">No Data found</center>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8" ></script>
    <script>
        const myLatLng = { lat: {{$restaurant->latitude}}, lng: {{$restaurant->longitude}} };
        let map;
        initMap();
        function initMap() {
                 map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatLng,
            });
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "{{$restaurant->name}}",
            });
        }
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

    function request_alert(url, message) {
        Swal.fire({
            title: '{{__('Are you sure')}}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{__('no')}}',
            confirmButtonText: '{{__('yes')}}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = url;
            }
        })
    }
    </script>
@endpush
