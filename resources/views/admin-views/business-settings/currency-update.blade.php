@extends('layouts.admin.app')

@section('title', __('Update Currency'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('Update Currency')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.business-settings.currency-update',[$currency['id']])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group mb-2">
                        <label style="padding-left: 10px">{{__('Country Name')}}</label><br>
                        <input type="text" placeholder="ex : Bangladesh" value="{{$currency['country']}}" class="form-control" name="country">
                    </div>

                    <div class="form-group mb-2">
                        <label style="padding-left: 10px">{{__('Code')}}</label><br>
                        <input type="text" placeholder="ex : USD" value="{{$currency['currency_code']}}" class="form-control" name="currency_code">
                    </div>

                    <div class="form-group mb-2">
                        <label style="padding-left: 10px">{{__('Symbol')}}</label><br>
                        <input type="text" placeholder="ex : $" value="{{$currency['currency_symbol']}}" class="form-control" name="symbol">
                    </div>

                    <div class="form-group mb-2">
                        <label style="padding-left: 10px">{{__('Exchange Rate ( 1 USD ) with USD')}}</label><br>
                        <input type="number" placeholder="ex : 1" value="{{$currency['exchange_rate']}}" class="form-control" name="exchange_rate">
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">{{__('Update')}}</button>

                </form>
            </div>
        </div>
    </div>
@endsection