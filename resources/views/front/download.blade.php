<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @include('partials.head')

</head>

<body>

    @php($landing_page_links = \App\Models\BusinessSetting::where(['key' => 'landing_page_links'])->first())
    @php($landing_page_links = isset($landing_page_links->value) ? json_decode($landing_page_links->value, true) : null)

    <div class="container bg-white py-10">
        <div class="flex justify-center">
            @php($logo = \App\CentralLogics\Helpers::get_settings('logo'))
            <img class="rounded float-left"
                onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                src="{{ asset('storage/app/public/business/' . $logo) }}"
                style="max-width: 200px;max-height: 75px">
        </div>
    </div>
    <!-- download app section -->
    <section class="download-app-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="app-image">
                        <img src="{{ asset('public/assets/images/mobile-app.png') }}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contents">
                        <h3>{{ __('Download Our App') }}</h3>
                        <p>{{ "Now you can make food happen pretty much wherever you are. Get our app, it's the fastest way
                                                                                                    to order food on the go" }}.
                        </p>
                        <div class="flex flex-wrap">
                            <a class="px-2" href=""><img src="{{ asset('public/assets/images/play.png') }}"
                                    alt=""></a>
                            <a class="px-2" href=""><img
                                    src="{{ asset('public/assets/images/app-store.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   

    <!-- Scripts -->
    @include('partials.scripts')

</body>

</html>
