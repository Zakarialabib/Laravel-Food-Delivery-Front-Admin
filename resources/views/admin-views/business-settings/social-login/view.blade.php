@extends('layouts.admin.app')

@section('title', __('Social login'))

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{__('Social login')}}</li>
            </ol>
        </nav>
        <div class="row" style="padding-bottom: 20px">
            @if (isset($socialLoginServices))
            @foreach ($socialLoginServices as $socialLoginService)
                    <div class="col-md-6 mt-4">
                        <div class="card">
                            <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}" style="padding: 20px">
                                <div class="flex-between">
                                    <h4 class="text-center">{{__(''.$socialLoginService['login_medium'])}}</h4>
                                    <div class="btn btn-dark p-2" data-toggle="modal" data-target="#{{$socialLoginService['login_medium']}}-modal" style="cursor: pointer">
                                        <i class="tio-info-outined"></i> {{__('Credentials setup')}}
                                    </div>
                                </div>
                                <form
                                    action="{{route('admin.social-login.update',[$socialLoginService['login_medium']])}}"
                                    method="post">
                                    @csrf
                                    <div class="form-group mb-2 mt-5">
                                        <input type="radio" name="status"
                                               value="1" {{$socialLoginService['status']==1?'checked':''}}>
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('Active')}}</label>
                                        <br>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="radio" name="status"
                                               value="0" {{$socialLoginService['status']==0?'checked':''}}>
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('Inactive')}}</label>
                                        <br>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('Callback uri')}}</label>
                                        <span class="btn btn-secondary btn-sm m-2" onclick="copyToClipboard('#id_{{$socialLoginService['login_medium']}}')"><i class="tio-copy"></i> {{__('Copy uri')}}</span>
                                        <br>
                                        <span class="form-control" id="id_{{$socialLoginService['login_medium']}}" style="height: unset">{{ url('/') }}/auth/login/{{$socialLoginService['login_medium']}}/callback</span>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label
                                            style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('Store client id')}}</label><br>
                                        <input type="text" class="form-control" name="client_id"
                                               value="{{ $socialLoginService['client_id'] }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label
                                            style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{__('Store client secret')}}</label><br>
                                        <input type="text" class="form-control" name="client_secret"
                                               value="{{ $socialLoginService['client_secret'] }}">
                                    </div>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                            class="btn btn-primary mb-2">{{__('Save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
            @endif
        </div>
        {{-- Modal Starts--}}
        <!-- Google -->
        <div class="modal fade" id="google-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('Google api setup instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol>
                            <li>{{__('Go to the Credentials page click')}} <a href="https://console.cloud.google.com/apis/credentials" target="_blank">{{__('here')}}</a></li>
                            <li>{{__('Click create credentials auth client id')}}</b>.</li>
                            <li>{{__('Select the web application type')}}.</li>
                            <li>{{__('Name your auth client')}}</li>
                            <li>{{__('Click Add uri from Authorized redirect uris, provide the')}} <code>{{__('callback uri')}}</code> {{__('From below and click created')}}</b></li>
                            <li>{{__('Copy client id and Client secret, past in the input field below and save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facebook -->
        <div class="modal fade" id="facebook-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('Facebook api set instruction')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        <ol>
                            <li>{{__('Goto the facebook developer page')}} (<a href="https://developers.facebook.com/apps/" target="_blank">{{__('Click here')}}</a>)</li>
                            <li>{{__('Goto get started from navbar')}}</li>
                            <li>{{__('from register tab press continue if needed')}}</li>
                            <li>{{__('Provide primary email and press confirm email If needed')}}</li>
                            <li>{{__('In about section select other and press complete registration')}}</li>

                            <li>{{__('Create app select an app type and press next')}}</li>
                            <li>{{__('Complete the details form and press create app')}} </li><br/>

                            <li>{{__('form facebook login press set up')}}</li>
                            <li>{{__('Select web')}}</li>
                            <li>{{__('Provide Site url base url of the site')}}:<small>https://tiktak.ma</small>  <b>{{__('Save')}}</b></li><br/>
                            <li>{{__('Now go to setting form facebook login left sidebar')}}</li>
                            <li>{{__('Make sure to check client auth login must on')}}</li>
                            <li>{{__('Provide')}} <code>{{__('valid auth redirect uris')}}</code> {{__('From below and click Save changes')}}</b></li>

                            <li>{{__('Now go to setting From left sidebar basic')}}</li>
                            <li>{{__('Fill the form and press save changes')}}</li>
                            <li>{{__('Now copy client id & Client secret past in the input field below and Save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Twitter -->
        <div class="modal fade" id="twitter-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('twitter api set up instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        {{__('Instruction will be available very soon')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Ends--}}
    </div>
@endsection

@push('script_2')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();

            toastr.success("{{__('Copied to the clipboard')}}");
        }
    </script>

@endpush
