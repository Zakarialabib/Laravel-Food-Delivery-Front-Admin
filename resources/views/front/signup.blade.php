@extends('layouts.app')
@section('content')
    <!-- <div class="search-nav">
            <div class="container">
                <h3 class="mb-0">Sign in</h3>
            </div>
        </div> -->

    <section class="log-reg-sec">
        <div class="content">
            <div class="form-content">
                <img src="{{ asset('assets/images/logo-round.png') }}" alt="" class="form-logo">
                <h1 class="text-center">Sign up to FoodDay</h1>
                <form method="post" action="{{ route('signup_store') }}">
                    @csrf
                    @if (Session::get('fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('fail') }}
                        </div>
                    @endif

                    <div class="form-group ">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name"
                            value="{{ old('first_name') }}">
                        @error('first_name')
                            <p style="color:red">{{ $errors->first('first_name') }}
                            @enderror
                    </div>
                    <div class="form-group ">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <p style="color:red">{{ $errors->first('last_name') }}
                            @enderror
                    </div>
                    <div class="form-group ">
                        <input type="text" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}">
                        @error('email')
                            <p style="color:red">{{ $errors->first('email') }}
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="phone">{{__('messages.phone')}}</label>
                        <input type="text" name="phone" class="form-control" placeholder="Ex : 017********"
                        value="{{old('phone')}}" required>
                    </div>
                    <div class="form-group ">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @error('password')
                            <p style="color:red">{{ $errors->first('password') }}
                            @enderror
                    </div>
                    <div class="form-group ">
                        <input type="password" name="confirm_password" class="form-control"
                            placeholder=" Confirm Password">
                        @error('confirm_password')
                            <p style="color:red">{{ $errors->first('confirm_password') }}
                            @enderror
                    </div>
                    <div class="form-group  text-center">
                        <span class="d-inline-block">By clcking Sign up, Continue with Faecbook or Continue with
                            Google, you agree to our <a href="">Terms and Conditions</a> and <a href="">Privacy
                                Statement</a></span>
                    </div>

                    <div class="form-group ">
                        <button class="btn btn-primary w-100">Sign up</button>
                    </div>
                    <div class="form-group text-center mb-0">
                        <span>Already have an account?</span>
                        <a href="{{ route('signin') }}">Sign In</a>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js" integrity="sha512-QMUqEPmhXq1f3DnAVdXvu40C8nbTgxvBGvNruP6RFacy3zWKbNTmx7rdQVVM2gkd2auCWhlPYtcW2tHwzso4SA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js" integrity="sha512-hkmipUFWbNGcKnR0nayU95TV/6YhJ7J9YUAkx4WLoIgrVr7w1NYz28YkdNFMtPyPeX1FrQzbfs3gl+y94uZpSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.min.js" integrity="sha512-lv6g7RcY/5b9GMtFgw1qpTrznYu1U4Fm2z5PfDTG1puaaA+6F+aunX+GlMotukUFkxhDrvli/AgjAu128n2sXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags.png" type="image/x-icon">
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags@2x.png" type="image/x-icon">

@endpush