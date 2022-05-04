@extends('layouts.app')

@section('title', __('Contact Us'))

@section('content')
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{__('Contact Us')}}</h3>
        </div>
    </div>
    <section class="py-60">
        <div class="container">

            <!-- Top Start -->
            <div class="top-start" style="min-height: 100px">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mt-2 text-center">
                            {{-- <h1>{{__('messages.contact_us')}}</h1> --}}
                        </div>
                        <div class="col-12">
                            <center>
                                <img style="max-width: 50%" src="{{ asset('public/assets/landing/image/contact.png') }}">
                                <h6 class="mt-4">
                                    {{__('Phone')}} : {{ \App\CentralLogics\Helpers::get_settings('phone') }},
                                    {{__('Email')}} : {{ \App\CentralLogics\Helpers::get_settings('email_address') }}
                                </h6><br>
                                <h6>
                                    {{__('Address')}} : {{ \App\CentralLogics\Helpers::get_settings('address') }}
                                </h6>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top End -->
        </div>
    </section>
@endsection
