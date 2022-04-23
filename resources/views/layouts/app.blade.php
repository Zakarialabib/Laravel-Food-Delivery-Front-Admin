<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @php($logo = \App\Models\BusinessSetting::where(['key' => 'icon'])->first()->value ?? '')
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/business/' . $logo ?? '') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/styles.css') }}">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('public/assets/landing/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/landing/fontawesome/css/fontawesome.min.css') }}">

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr.css') }}">
</head>

<body>

    @php($landing_page_links = \App\Models\BusinessSetting::where(['key' => 'landing_page_links'])->first())
    @php($landing_page_links = isset($landing_page_links->value) ? json_decode($landing_page_links->value, true) : null)

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
                    Menu
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto"></ul>
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('index') }}">Home <span
                                    class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('restaurant_listing') }}">Restaurants</a>
                        </li>
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link navbar-font" href="{{ route('signin') }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('register') }}">Inscription</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>

                        @if (count((array) session('cart')) == 0)
                            <a class="nav-link navbar-font" href="{{ route('emptycart') }}">

                                <span class="cart-badge-wrap">

                                    <span class="cart-badge">{{ count((array) session('cart')) }}</span>

                                    <i class='bx bx-shopping-bag mr-1'></i>

                                </span>

                                Cart</a>
                        @else
                            <a class="nav-link navbar-font" href="{{ route('customer.cart2') }}">

                                <span class="cart-badge-wrap">

                                    <span class="cart-badge">{{ count((array) session('cart')) }}</span>

                                    <i class='bx bx-shopping-bag mr-1'></i>

                                </span>

                                Cart</a>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <div id="app">
        <main>
            @yield('content')
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
                        <h3>Download Our App</h3>
                        <p>Now you can make food happen pretty much wherever you are. Get our app, it's the fastest way
                            to order food on the go.</p>
                        <div>
                            <a href=""><img src="{{ asset('public/assets/images/play.png') }}" alt=""></a>
                            <a href=""><img src="{{ asset('public/assets/images/app-store.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->

    <footer>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <h3>Quick links</h3>
                        <ul>
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('restaurant_listing') }}">Restaurants</a></li>
                            <li>
                                <a href="{{ $landing_page_links['app_url_android'] }}" class="footer-item">Play
                                    Store</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ $landing_page_links['app_url_ios'] }}" class="footer-item">App Store</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h3>Quick links</h3>
                        <ul>
                            @if ($toggle_restaurant_registration)
                                <li><a
                                        href="{{ route('restaurant.create') }}">{{ __('messages.restaurant_registration') }}</a>
                                </li>
                            @endif
                            @if ($toggle_dm_registration)
                                <li><a href="{{ route('deliveryman.create') }}">
                                        {{ __('messages.deliveryman_registration') }}
                                    </a>
                                </li>
                            @endif
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        </ul>
                    </div>


                    <div class="col-lg-4 col-md-6">
                        <h3>Contact us</h3>
                        <ul class="contact">
                            <li>
                                <a>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ \App\CentralLogics\Helpers::get_settings('address') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ \App\CentralLogics\Helpers::get_settings('email_address') }}"
                                    class="footer-item text-white">
                                    <i class="fas fa-envelope MR-1"></i>
                                    <span
                                        class="ml-1">{{ \App\CentralLogics\Helpers::get_settings('email_address') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:{{ \App\CentralLogics\Helpers::get_settings('phone') }}"
                                    class="footer-item text-white">
                                    <i class="fas fa-phone MR-1"></i>
                                    <span
                                        class="ml-1">{{ \App\CentralLogics\Helpers::get_settings('phone') }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="social">
                            <i class='bx bxl-facebook-circle'></i>
                            <i class='bx bxl-twitter'></i>
                            <i class='bx bxl-youtube'></i>
                            <i class='bx bxl-instagram-alt'></i>
                        </div>
                    </div>
                </div><!-- End row -->
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <!-- Copyright -->
                <div class="text-center">
                    <a href="#">{{ \App\CentralLogics\Helpers::get_settings('business_name') }}</a>
                </div>
            </div>
        </div>

        <!-- mobile footer -->

        <div class="mobile-footer">
            <div class="row">
                <div class="col-4 item">
                    <a href="home.html">
                        <i class='bx bx-search'></i>
                        <span>Search</span>
                    </a>
                </div>
                <div class="col-4 item">
                    <a href="cart.html">
                        <i class='bx bx-cart'><span class="badge badge-light">22</span></i>
                        <span>Cart</span>
                    </a>
                </div>
                <div class="col-4 item">
                    <a href="my-account.html">
                        <i class='bx bx-user'></i>
                        <span>Account</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- mobile footer end -->

    </footer>

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="{{ asset('public/assets/js/custom.js') }}"></script>
    <script src="{{ asset('public/assets/admin') }}/js/toastr.js"></script>

    {!! Toastr::message() !!}

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                CloseButton: true,
                ProgressBar: true
                });
            @endforeach
        </script>
    @endif

    @stack('scripts')
</body>

</html>
