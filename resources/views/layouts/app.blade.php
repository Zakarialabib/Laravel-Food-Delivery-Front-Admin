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
    @php($auth = \App\Models\User::find(Auth::user()))

    <!-- header -->
    <header>
        <div class="container-fluid">
            <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light fixed-top">
                <a class="navbar-brand" href="{{ route('home') }}">
                    @php($logo = \App\CentralLogics\Helpers::get_settings('logo'))
                    <img onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                        src="{{ asset('storage/app/public/business/' . $logo) }}"
                        style="height:auto;width:100%; max-width:200px; max-height:60px">
                </a>
                <button style="background: #FFFFFF; border-radius: 2px;font-size: 13px" class="navbar-toggler"
                    type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto"></ul>
                    <ul class="navbar-nav">
                        <div class="btn-group show-on-hover">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                {{ app()->getLocale() }}
                                @if (count($languages) > 1)
                                    <span class="caret"></span>
                                @endif
                            </button>
                            @if (count($languages) > 1)
                                <ul class="dropdown-menu" role="menu">
                                    @foreach ($languages as $language)
                                        @if (\Illuminate\Support\Facades\App::getLocale() !== $language->code)
                                            <li><a href="{{ route('change_language', $language->code) }}"
                                                    title="{{ $language->name }}">{{ $language->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('home') }}">{{ __('Home') }} <span
                                    class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link navbar-font"
                                href="{{ route('restaurant_listing') }}">{{ _('Restaurants') }}</a>
                        </li>
                        @if (empty($auth))
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('myaccount') }}">
                                <i class='bx bx-user mr-1'></i>
                                    {{ __('My Account') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link navbar-font" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            
                            
                            @endif
                            <livewire:cart-count />
                        </ul>
                </div>
            </nav>
        </div>
    </header>
    <div id="app">
        <main>
            {{ $slot }}
        </main>
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
    <!-- footer -->

    @include('partials.footer')



    @include('partials.scripts')

</body>

</html>
