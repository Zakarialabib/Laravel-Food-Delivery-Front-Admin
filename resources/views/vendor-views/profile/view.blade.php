@extends('layouts.vendor.app')
@section('title','Bandk Info View')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{__('Vendor')}}</li>
                <li class="breadcrumb-item">{{__('My bank info')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0 text-capitalize">{{__('My bank info')}}  </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-4">
                            <h4>{{__('Bank name')}}
                                : {{$data->bank_name ? $data->bank_name : 'No Data found'}}</h4>
                            <h6>{{__('Branch')}} : {{$data->branch ? $data->branch : 'No Data found'}}</h6>
                            <h6>{{__('Holder name')}}
                                : {{$data->holder_name ? $data->holder_name : 'No Data found'}}</h6>
                            <h6>{{__('Account no')}}
                                : {{$data->account_no ? $data->account_no : 'No Data found'}}</h6>


                            <a class="btn btn-primary"
                               href="{{route('vendor.profile.bankInfo')}}">{{__('Edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <!-- Page level plugins -->
@endpush
