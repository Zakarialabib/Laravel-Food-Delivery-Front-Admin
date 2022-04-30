<x-app-layout>
    @section('title', __('Sign in'))
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{__('Sign in')}}</h3>
        </div>
    </div>

    <section class="log-reg-sec">
        <div class="content">
            <div class="form-content">
                <img src="{{ asset('assets/images/logo-round.png') }}" alt="" class="form-logo">
                <h1 class="text-center">{{__('Sign in to your account')}}</h1>
                <form action="{{ route('check') }}" method="post">
                    @csrf
                    @if (Session::get('fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('fail') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email">
                        @error('email')
                            <p style="color:red">{{ $errors->first('email') }}
                            @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @error('password')
                            <p style="color:red">{{ $errors->first('password') }}
                            @enderror
                    </div>

                    <div class="form-group">
                        <a href="{{ route('showforgotForm') }}">Forgot password?</a>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary w-100">Sign in</button>
                    </div>
                    <div class="form-group text-center mb-0">
                        <span>Don't have an account?</span>
                        <a href="{{ route('signup') }}">Sign up</a>
                    </div>

                </form>
            </div>
        </div>
    </section>
</x-app-layout>


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js" integrity="sha512-QMUqEPmhXq1f3DnAVdXvu40C8nbTgxvBGvNruP6RFacy3zWKbNTmx7rdQVVM2gkd2auCWhlPYtcW2tHwzso4SA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js" integrity="sha512-hkmipUFWbNGcKnR0nayU95TV/6YhJ7J9YUAkx4WLoIgrVr7w1NYz28YkdNFMtPyPeX1FrQzbfs3gl+y94uZpSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.min.js" integrity="sha512-lv6g7RcY/5b9GMtFgw1qpTrznYu1U4Fm2z5PfDTG1puaaA+6F+aunX+GlMotukUFkxhDrvli/AgjAu128n2sXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags.png" type="image/x-icon">
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags@2x.png" type="image/x-icon">

@endpush