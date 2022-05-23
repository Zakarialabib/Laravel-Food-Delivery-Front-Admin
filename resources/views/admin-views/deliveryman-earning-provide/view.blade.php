@extends('layouts.admin.app')
@section('title','Accoutn transaction information')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Account transaction')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex row align-items-center justify-content-between mb-2">
        <div class="col-md-6"> 
             <h4 class=" mb-0 text-black-50">{{__('Deliverymen earning provide information')}}</h4>
        </div>
    </div>
    <div class="row mt-3">
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  ">{{$account_transaction->restaurant?__('Restaurant'):__('Deliveryman info')}}</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                        <h4>{{__('Name')}}: {{$account_transaction->restaurant ? $account_transaction->restaurant->name : $account_transaction->deliveryman->f_name.' '.$account_transaction->deliveryman->l_name}}</h4>
                        <h6>{{__('Phone')}}  : {{$account_transaction->restaurant ? $account_transaction->restaurant->phone : $account_transaction->deliveryman->phone}}</h6>
                        <h6>{{__('Collected cash')}} : {{\App\CentralLogics\Helpers::format_currency($account_transaction->restaurant ? $account_transaction->restaurant->vendor->wallet->collected_cash : $account_transaction->deliveryman->wallet->collected_cash)}}</h6>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="col-md-6">
            {{-- {{ $wr }} --}}
           
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  ">{{__('transaction information')}} </h3>
                </div>
                <div class="card-body">
                    <h6>{{__('Amount')}} : {{\App\CentralLogics\Helpers::format_currency($account_transaction->amount)}}</h6>
                    <h6 class="text-capitalize">{{__('Time')}} : {{$account_transaction->created_at->format('Y-m-d '.config('timeformat'))}}</h6>
                    <h6>{{__('method')}} : {{$account_transaction->method}}</h6>
                    <h6>{{__('Reference')}} : {{$account_transaction->ref}}</h6>
                </div>
            </div>
          
       
       
        </div>
    
     

    </div>
 
</div>

@endsection

@push('script')

@endpush
