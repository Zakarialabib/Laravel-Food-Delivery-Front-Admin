@extends('layouts.admin.app')

@section('title', __('Third party apis'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('Third party apis')}}</h1>
                    <span class="badge badge-soft-dark">{{__('Map api hint')}}</span><br>
                    <span class="badge badge-soft-dark">{{__('Map api hint 2')}}</span><br>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
        @php($map_api_key=\App\Models\BusinessSetting::where(['key'=>'map_api_key'])->first())
        @php($map_api_key=$map_api_key?$map_api_key->value:null)

        @php($map_api_key_server=\App\Models\BusinessSetting::where(['key'=>'map_api_key_server'])->first())
        @php($map_api_key_server=$map_api_key_server?$map_api_key_server->value:null)
        
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.config-update'):'javascript:'}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="input-label" style="padding-left: 10px">{{__('client map api key')}}</label>
                                <input type="text" placeholder="{{__('client map api key')}})" class="form-control" name="map_api_key"
                                    value="{{env('APP_MODE')!='demo'?$map_api_key??'':''}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="input-label" style="padding-left: 10px">{{__('Server map api key ')}}</label>
                                <input type="text" placeholder="{{__('Server map api key')}})" class="form-control" name="map_api_key_server"
                                    value="{{env('APP_MODE')!='demo'?$map_api_key_server??'':''}}" required>
                            </div>
                        </div>
                    </div>

                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection