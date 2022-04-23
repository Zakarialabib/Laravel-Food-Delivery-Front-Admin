@extends('layouts.app')
@section('content')
    <!-- <div class="search-nav">
            <div class="container">
                <h3 class="mb-0">Reset Your Password</h3>
            </div>
        </div> -->

    <section class="log-reg-sec">

        <div class="content">
            <div class="form-content">
                <img src="assets/images/logo-round.png" alt="" class="form-logo">
                <h1 class="text-center">Reset Password?</h1>
                @if (Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('info') }}
                    </div>
                @endif
                @if (Session::has('fail'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                <form action="{{ route('customer.resetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <span class="email-text">Enter a new password for your account</span>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Email"
                            value="{{ $email ?? old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="New Password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Confirm New Password">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary w-100">Reset Password</button>
                    </div>
                    <div class="form-group text-center mb-0">
                        <span>Don't have an account?</span>
                        <a href="">Sign up</a>
                    </div>

                </form>
            </div>
        </div>

    </section>
@endsection
