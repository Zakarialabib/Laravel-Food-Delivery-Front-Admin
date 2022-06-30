@extends('layouts.admin.app')

@section('title', __('Payment Setup'))

 
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('Payment gateway setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row" style="padding-bottom: 20px">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Payment method')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery'))
                        <form action="{{route('admin.business-settings.payment-method-update',['cash_on_delivery'])}}"
                              method="post">
                            @csrf
                            
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Cash on delivery')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                    <label
                                        style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Payment method')}}</h5>
                        @php($digital_payment=\App\CentralLogics\Helpers::get_business_settings('digital_payment'))
                        <form action="{{route('admin.business-settings.payment-method-update',['digital_payment'])}}"
                              method="post">
                            @csrf
                                <div class="form-group mb-2">
                                    <label
                                        class="control-label text-capitalize">{{__('Digital payment')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" class="digital_payment" name="status" value="1" {{$digital_payment?($digital_payment['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" class="digital_payment" name="status" value="0" {{$digital_payment?($digital_payment['status']==0?'checked':''):''}}>
                                    <label
                                        style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row digital_payment_methods" style="padding-bottom: 20px">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Sslcommerz')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('ssl_commerz_payment'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['ssl_commerz_payment']):'javascript:'}}"
                            method="post">
                            @csrf
                                <div class="form-group mb-2">
                                    <label
                                        class="control-label">{{__('Sslcommerz payment')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                    <label
                                        style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Store id')}} </label><br>
                                    <input type="text" class="form-control" name="store_id"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['store_id']:''):''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Store password')}}</label><br>
                                    <input type="text" class="form-control" name="store_password"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['store_password']:''):''}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Razorpay')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('razor_pay'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['razor_pay']):'javascript:'}}"
                            method="post">
                            @csrf
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Razorpay')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                    <label
                                        style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Razorkey')}}</label><br>
                                    <input type="text" class="form-control" name="razor_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['razor_key']:''):''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Razorsecret')}}</label><br>
                                    <input type="text" class="form-control" name="razor_secret"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['razor_secret']:''):''}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Paypal')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paypal'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['paypal']):'javascript:'}}"
                            method="post">
                            @csrf
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Paypal')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Paypal client id')}}</label><br>
                                    <input type="text" class="form-control" name="paypal_client_id"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['paypal_client_id']:''):''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Paypal secret')}} </label><br>
                                    <input type="text" class="form-control" name="paypal_secret"
                                           value="{{env('APP_MODE')!='demo'?$config['paypal_secret']??'':''}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Stripe')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('stripe'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['stripe']):'javascript:'}}"
                              method="post">
                            @csrf
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Stripe')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Published key')}}</label><br>
                                    <input type="text" class="form-control" name="published_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['published_key']:''):''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Api key')}}</label><br>
                                    <input type="text" class="form-control" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['api_key']:''):''}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 26px!important;">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Paystack')}}</h5>
                        <span class="badge badge-soft-danger">{{__('Paystack_callback_warning')}}</span>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paystack'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['paystack']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Paystack')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Public Key')}}</label><br>
                                    <input type="text" class="form-control" name="publicKey"
                                           value="{{env('APP_MODE')!='demo'?$config['publicKey']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize" style="padding-left: 10px">{{__('Secret key')}} </label><br>
                                    <input type="text" class="form-control" name="secretKey"
                                           value="{{env('APP_MODE')!='demo'?$config['secretKey']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize" style="padding-left: 10px">{{__('Payment url')}}</label><br>
                                    <input type="text" class="form-control" name="paymentUrl"
                                           value="{{env('APP_MODE')!='demo'?$config['paymentUrl']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize" style="padding-left: 10px">{{__('Merchant email')}}</label><br>
                                    <input type="text" class="form-control" name="merchantEmail"
                                           value="{{env('APP_MODE')!='demo'?$config['merchantEmail']:''}}">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                                    <button type="button" class="btn btn-info mb-2 pull-right" onclick="copy_text('{{url('/')}}/paystack-callback')">{{__('Copy callback')}}</button>        
                                </div>

                                
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Senang pay')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('senang_pay'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['senang_pay']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Senang pay')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('Secret key')}}</label><br>
                                    <input type="text" class="form-control" name="secret_key"
                                           value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Merchant id')}}</label><br>
                                    <input type="text" class="form-control" name="merchant_id"
                                           value="{{env('APP_MODE')!='demo'?$config['merchant_id']:''}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <!-- Flutterwave -->
            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Flutterwave')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('flutterwave'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['flutterwave']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Flutterwave')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('Public Key')}}</label><br>
                                    <input type="text" class="form-control" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('Secret key')}}</label><br>
                                    <input type="text" class="form-control" name="secret_key"
                                           value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('hash')}}</label><br>
                                    <input type="text" class="form-control" name="hash"
                                           value="{{env('APP_MODE')!='demo'?$config['hash']:''}}">
                                </div>

                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- MercadoPago -->
            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Mercadopago')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('mercadopago'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['mercadopago']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Mercadopago')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('Public Key')}}</label><br>
                                    <input type="text" class="form-control" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                        style="padding-left: 10px">{{__('Access token')}}</label><br>
                                    <input type="text" class="form-control" name="access_token"
                                           value="{{env('APP_MODE')!='demo'?$config['access_token']:''}}">
                                </div>

                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Paymob_accept')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paymob_accept'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['paymob_accept']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Paymob accept')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('callback')}}</label>
                                    <span class="btn btn-secondary btn-sm m-2"
                                          onclick="copyToClipboard('#id_paymob_accept')"><i class="tio-copy"></i> {{__('Copy callback')}}</span>
                                    <br>
                                    <p class="form-control" id="id_paymob_accept">{{ url('/') }}/paymob-callback</p>
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Api key')}}</label><br>
                                    <input type="text" class="form-control" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Iframe id')}}</label><br>
                                    <input type="text" class="form-control" name="iframe_id"
                                           value="{{env('APP_MODE')!='demo'?$config['iframe_id']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Integration id')}}</label><br>
                                    <input type="text" class="form-control" name="integration_id"
                                           value="{{env('APP_MODE')!='demo'?$config['integration_id']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('HMAC')}}</label><br>
                                    <input type="text" class="form-control" name="hmac"
                                           value="{{env('APP_MODE')!='demo'?$config['hmac']:''}}">
                                </div>


                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4" style="display: block">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Bkash')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('bkash'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['bkash']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Bkash')}}</label>
                                </div>

                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Api key')}}</label><br>
                                    <input type="text" class="form-control" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Api secret')}}</label><br>
                                    <input type="text" class="form-control" name="api_secret"
                                           value="{{env('APP_MODE')!='demo'?$config['api_secret']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Username')}}</label><br>
                                    <input type="text" class="form-control" name="username"
                                           value="{{env('APP_MODE')!='demo'?$config['username']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Password')}}</label><br>
                                    <input type="text" class="form-control" name="password"
                                           value="{{env('APP_MODE')!='demo'?$config['password']:''}}">
                                </div>


                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4" style="display: block">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Paytabs')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paytabs'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['paytabs']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Paytabs')}}</label>
                                </div>

                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Profile id')}}</label><br>
                                    <input type="text" class="form-control" name="profile_id"
                                           value="{{env('APP_MODE')!='demo'?$config['profile_id']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Server')}}</label><br>
                                    <input type="text" class="form-control" name="server_key"
                                           value="{{env('APP_MODE')!='demo'?$config['server_key']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Base url by region')}}</label><br>
                                    <input type="text" class="form-control" name="base_url"
                                           value="{{env('APP_MODE')!='demo'?$config['base_url']:''}}">
                                </div>


                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Paytm')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paytm'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['paytm']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Paytm')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Paytm merchant key')}}</label><br>
                                    <input type="text" class="form-control" name="paytm_merchant_key"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_key']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{__('Paytm merchant mid')}}</label><br>
                                    <input type="text" class="form-control" name="paytm_merchant_mid"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_mid']:''}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label
                                        style="padding-left: 10px">{{__('Paytm merchant website')}}</label><br>
                                    <input type="text" class="form-control" name="paytm_merchant_website"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_website']:''}}">
                                </div>

                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 pt-4">
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <h5 class="text-center">{{__('Liqpay')}}</h5>
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('liqpay'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method-update',['liqpay']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                                <div class="form-group mb-2">
                                    <label class="control-label">{{__('Liqpay')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{__('Inactive')}} </label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                           style="padding-left: 10px">{{__('Public Key')}}</label><br>
                                    <input type="text" class="form-control" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-capitalize"
                                           style="padding-left: 10px">{{__('Private Key')}}</label><br>
                                    <input type="text" class="form-control" name="private_key"
                                           value="{{env('APP_MODE')!='demo'?$config['private_key']:''}}">
                                </div>

                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('Save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2">{{__('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script_2')
<script>
    @if(!isset($digital_payment) || $digital_payment['status']==0)
        $('.digital_payment_methods').hide();
    @endif
    $(document).ready(function () {
        $('.digital_payment').on('click', function(){
            if($(this).val()=='0')
            {
                $('.digital_payment_methods').hide();
            }
            else
            {
                $('.digital_payment_methods').show();
            }
        })
    });
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

        toastr.success("{{__('Text copied')}}");
    }

</script>
@endpush
