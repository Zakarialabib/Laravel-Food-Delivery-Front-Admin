@extends('layouts.admin.app')

@section('title',__('Update Attribute'))

 
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> {{__('attribute update')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.attribute.update',[$attribute['id']])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group lang_form">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{__('New attribute')}}" maxlength="191" value="{{ $attribute['name'] }}" required>
                            </div>
                        </div>
                    </div>
   
                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')

@endpush
