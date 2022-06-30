@extends('layouts.vendor.app')
@section('title','Edit Role')
 
@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Role Update</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('Custom role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('vendor.custom-role.update',[$role['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('Role name')}}</label>
                            <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="Ex : Store">
                        </div>

                        <label for="module">{{__('Module permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="food" class="form-check-input"
                                           id="food" {{in_array('food',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="food">{{__('Food')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order" {{in_array('order',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="order">{{__('Order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="restaurant_setup" class="form-check-input"
                                           id="restaurant_setup" {{in_array('restaurant_setup',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="restaurant_setup">{{__('business setup')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon" {{in_array('addon',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="addon">{{__('Addon')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                           id="wallet" {{in_array('wallet',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="wallet">{{__('Wallet')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                           id="bank_info" {{in_array('bank_info',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="bank_info">{{__('Bank info')}} </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee" {{in_array('employee',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="employee">{{__('Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                           id="my_shop" {{in_array('my_shop',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="my_shop">{{__('My shop')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role" {{in_array('custom_role',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="custom_role">{{__('Custom role')}}</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign" {{in_array('campaign',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="campaign">{{__('Campaign')}}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                           id="reviews" {{in_array('reviews',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="reviews">{{__('Reviews')}}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos" {{in_array('pos',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="pos">{{__('Pos')}} </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
