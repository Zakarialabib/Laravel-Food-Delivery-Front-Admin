<!doctype html>
<html lang="en">

<head>
   
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <title>FoodDay - Home</title>
</head>

<body>

    <!-- header -->
    <header>
        <div class="container-fluid">
            <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light fixed-top">
                <a class="navbar-brand" href="{{route('customer.my_home')}}"><img src="{{asset('assets/images/logo.png')}}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('customer.my_home')}}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{route('restaurant_listing')}}">Restaurants</a>
                        </li> -->

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('customer.account')}}">
                                <i class='bx bx-user mr-1'></i>
                                My Account</a>
                        </li>
                        @if(count((array) session('cart'))==0)

<a class="nav-link" href="{{route('emptycart')}}">

<span class="cart-badge-wrap">

<span class="cart-badge">{{ count((array) session('cart')) }}</span>

<i class='bx bx-shopping-bag mr-1'></i>

</span>

Cart</a>

@else

<a class="nav-link" href="{{route('customer.cart2')}}">

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
    <!-- Header -->

    <!-- Banner -->

    <div class="home-banner d-flex align-items-center">
        <div class="container">
            <div class="banner-content">
                <h2>Delivering your favorite food to your door step.</h2>
                <form action="{{route('search')}}" method="GET">
                    <div class="input-group search-location-group">
                        <input type="text" class="form-control" name="location" placeholder="Enter your delivery location"
                            aria-label="delivery location" aria-describedby="button-addon2">
                        <a href="{{route('search')}}" class="btn-locate"><i class='bx bx-target-lock'></i> Locate Me</a>
                        <!-- <button class="btn-locate"><i class='bx bx-target-lock'></i> Locate Me</button> -->

                        <div class="input-group-append btn-find-food">
                            <button class="btn btn-danger" type="submit">Find Food</button>
                            

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Banner End -->

    <!-- How it works -->

    <section class="how-it-works pb-0">
        <div class="container">
            <h4>How It Works</h4>
            <div class="row">
                <div class="col-lg-4">
                    <div class="item">
                        <div class="item-image">
                            <img src="{{asset('assets/images/meal.svg')}}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>Choose Your Dish</h4>
                            <p>Choose your favorite meals and order online or by phone. It's easy to customize your
                                order
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <div class="item-image">
                            <img src="{{asset('assets/images/delivery.svg')}}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>We Deliver Your Meals</h4>
                            <p>We prepared and delivered meals arrive at your door. Duis autem vel eum iriure dolor in
                                hendrerit in vulputate.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <div class="item-image">
                            <img src="{{asset('assets/images/eat-enjoy.svg')}}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>Eat And Enjoy</h4>
                            <p>No shooping, no cooking, no counting and no cleaning. Enjoy your healthy meals with your
                                family.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 pb-4">
        <div class="container">
            <h4 class="mb-4">Popular Restaurants</h4>
            <div class="row rest-listing-row">

                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card">
                        <span class="restaurant-status"><em class="ribbon"></em>Open</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  ">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card">
                        <span class="restaurant-status"><em class="ribbon"></em>Open</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  ">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card">
                        <span class="restaurant-status"><em class="ribbon"></em>Open</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card unavailable">
                        <span class="restaurant-status closed"><em class="ribbon"></em>Closed</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card unavailable">
                        <span class="restaurant-status closed"><em class="ribbon"></em>Closed</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="restaurant-details.html" class="card restaurant-card unavailable">
                        <span class="restaurant-status closed"><em class="ribbon"></em>Closed</span>
                        <div class="restaurant-image" style="
                                    background-image: url({{asset('assets/images/banner1.jpg')}});
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San Francisco, CA
                                94110</p>
                            <div class="details">
                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                <span class="badge">30 Mins</span>
                                <span class="badge">$200 for two</span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>


    <!-- location listing section -->

    <div class="location-listing-section">
        <div class="container">
            <h4 class="mb-4">Top cities</h4>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <ul class="delivery-ul">
                        <li><a href="">Tokyo</a></li>
                        <li><a href="">Singapore</a></li>
                        <li><a href="">Berlin</a></li>
                        <li><a href="">Seoul</a></li>
                        <li><a href="">Toronto</a></li>
                        <li><a href="">Paris</a></li>
                        <li><a href="">Munich</a></li>
                        <li><a href="">London</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <ul class="delivery-ul">
                        <li><a href="">Toronto</a></li>
                        <li><a href="">Paris</a></li>
                        <li><a href="">Munich</a></li>
                        <li><a href="">London</a></li>
                        <li><a href="">Tokyo</a></li>
                        <li><a href="">Singapore</a></li>
                        <li><a href="">Berlin</a></li>
                        <li><a href="">Seoul</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <ul class="delivery-ul">
                        <li><a href="">Tokyo</a></li>
                        <li><a href="">Singapore</a></li>
                        <li><a href="">Berlin</a></li>
                        <li><a href="">Seoul</a></li>
                        <li><a href="">Toronto</a></li>
                        <li><a href="">Paris</a></li>
                        <li><a href="">Munich</a></li>
                        <li><a href="">London</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <ul class="delivery-ul">
                        <li><a href="">Toronto</a></li>
                        <li><a href="">Paris</a></li>
                        <li><a href="">Munich</a></li>
                        <li><a href="">London</a></li>
                        <li><a href="">Tokyo</a></li>
                        <li><a href="">Singapore</a></li>
                        <li><a href="">Berlin</a></li>
                        <li><a href="">Seoul</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- download app section -->

    <section class="download-app-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="app-image">
                        <img src="{{asset('assets/images/mobile-app.png')}}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contents">
                        <h3>Download Our App</h3>
                        <p>Now you can make food happen pretty much wherever you are. Get our app, it's the fastest way
                            to order food on the go.</p>
                        <div>
                            <a href=""><img src="{{asset('assets/images/play.png')}}" alt=""></a>
                            <a href=""><img src="{{asset('assets/images/app-store.png')}}" alt=""></a>
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
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('restaurant_listing')}}">Restaurants</a></li>
                            <li><a href="{{route('customer.aboutus')}}">About us</a></li>
                            <li><a href="{{route('customer.contact')}}">Contact</a></li>
                           
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h3>Quick links</h3>
                        <ul>
                            <li><a href="enrol-your-restaurant.html">Enroll as Restaurant</a></li>
                            <li><a href="enrol-delivery-boy.html">Enroll as Delivery Boy</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <!-- <div class="col-lg-3 col-md-6"> -->
                        <!-- <h3>Subscribe to newsletter</h3>
                        <p>Join our newsletter to keep be informed about offers and news.</p>
                        <form action="">
                            <div class="input-group newsletter-group">
                                <input type="text" class="form-control" placeholder="Enter your email" aria-label=""
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" id="find-food-btn"><i
                                            class='bx bx-send'></i></button>
                                </div>
                            </div> -->
                        <!-- </form> -->
                    <!-- </div> -->
                    <div class="col-lg-4 col-md-6">
                        <h3>Contact us</h3>
                        <ul class="contact">
                            <li><i class='bx bx-location-plus'></i><span>Down Town Building, MG Road, Toronto, Canada,
                                    784578</span></li>
                            <li><i class='bx bx-mail-send'></i><span>hello@cedextech.com</span></li>
                            <li><i class='bx bx-phone'></i><span>+91-8129881750</span></li>
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

                <div class="text-center">
                    <p class="mb-0 copy-right">© 2021 FoodDay All Rights Reserved</p>
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

    <!-- footer end -->

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
    <script src="{{asset('assets/js/custom.js')}}"></script>
</body>

</html>