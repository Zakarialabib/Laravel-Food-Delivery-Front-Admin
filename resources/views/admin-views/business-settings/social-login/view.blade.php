@extends('layouts.admin.app')

@section('title', __('Social login'))

@push('css_or_js')

@endpush

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
                                        <span class="form-control" id="id_{{$socialLoginService['login_medium']}}" style="height: unset">{{ url('/') }}/customer/auth/login/{{$socialLoginService['login_medium']}}/callback</span>
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
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('google_api_setup_instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol>
                            <li>{{__('go_to_the_credentials_page')}} ({{__('click')}} <a href="https://console.cloud.google.com/apis/credentials" target="_blank">{{__('here')}}</a>)</li>
                            <li>{{__('Click')}} <b>{{__('create credentials')}}</b> > <b>{{__('auth client id')}}</b>.</li>
                            <li>{{__('Select the')}} <b>{{__('web application')}}</b> {{__('type')}}.</li>
                            <li>{{__('name_your_auth_client')}}</li>
                            <li>{{__('Click')}} <b>{{__('Add uri')}}</b> {{__('from')}} <b>{{__('authorized_redirect_uris')}}</b> , {{__('provide the')}} <code>{{__('callback uri')}}</code> {{__('from_below_and_click')}} <b>{{__('created')}}</b></li>
                            <li>{{__('Copy')}} <b>{{__('client id')}}</b> {{__('and')}} <b>{{__('client secret')}}</b>, {{__('past_in_the_input_field_below_and')}} <b>{{__('Save')}}</b>.</li>
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
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('facebook_api_set_instruction')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        <ol>
                            <li>{{__('goto_the_facebook_developer_page')}} (<a href="https://developers.facebook.com/apps/" target="_blank">{{__('click_here')}}</a>)</li>
                            <li>{{__('Goto')}} <b>{{__('get_started')}}</b> {{__('from_navbar')}}</li>
                            <li>{{__('from_register_tab_press')}} <b>{{__('Continue')}}</b> <small>({{__('if_needed')}})</small></li>
                            <li>{{__('provide_primary_email_and_press')}} <b>{{__('Confirm email')}}</b> <small>({{__('if_needed')}})</small></li>
                            <li>{{__('in_about_section_select')}} <b>{{__('other')}}</b> {{__('and_press')}} <b>{{__('complete_registration')}}</b></li>

                            <li><b>{{__('create_app')}}</b> > {{__('Select an app type and press')}} <b>{{__('next')}}</b></li>
                            <li>{{__('complete_the_details_form_and_press')}} <b>{{__('create_app')}}</b></li><br/>

                            <li>{{__('form')}} <b>{{__('facebook_login')}}</b> {{__('press')}} <b>{{__('set_up')}}</b></li>
                            <li>{{__('Select')}} <b>{{__('web')}}</b></li>
                            <li>{{__('Provide')}} <b>{{__('site_url')}}</b> <small>({{__('base_url_of_the_site')}}: https://example.com)</small> > <b>{{__('Save')}}</b></li><br/>
                            <li>{{__('now_go_to')}} <b>{{__('setting')}}</b> {{__('form')}} <b>{{__('facebook_login')}}</b> ({{__('left_sidebar')}})</li>
                            <li>{{__('make_sure_to_check')}} <b>{{__('client_auth_login')}}</b> <small>({{__('must_on')}})</small></li>
                            <li>{{__('Provide')}} <code>{{__('valid_auth_redirect_uris')}}</code> {{__('from_below_and_click')}} <b>{{__('Save changes')}}</b></li>

                            <li>{{__('now_go_to')}} <b>{{__('setting')}}</b> ({{__('from_left_sidebar')}}) > <b>{{__('Basic')}}</b></li>
                            <li>{{__('fill_the_form_and_press')}} <b>{{__('Save changes')}}</b></li>
                            <li>{{__('now_copy')}} <b>{{__('client_id')}}</b> & <b>{{__('client_secret')}}</b>, {{__('past_in_the_input_field_below_and')}} <b>{{__('Save')}}</b>.</li>
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
