@section("layouts.app")
@section('content')
    <!-- Banner -->

    <div class="home-banner d-flex align-items-center">
        <div class="container">
            <div class="banner-content">
                <h2>Delivering your favorite food to your door step.</h2>
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group search-location-group">
                        <input type="text" class="form-control" name="location"
                            placeholder="Enter your delivery location" aria-label="delivery location"
                            aria-describedby="button-addon2">
                        <a href="" class="btn-locate"><i class='bx bx-target-lock'></i> Locate Me</a>
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
                            <img src="{{ asset ('public/assets/images/meal.svg')}}" alt="">
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
                            <img src="{{ asset ('public/assets/images/delivery.svg')}}" alt="">
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
                            <img src="{{ asset ('public/assets/images/eat-enjoy.svg')}}" alt="">
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
                                    background-image: url('assets/images/banner1.jpg');
                                  ">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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
                                    background-image: url('assets/images/test1.jpg');
                                  ">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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
                                    background-image: url('assets/images/test2.jpg');
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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
                                    background-image: url('assets/images/test3.jpg');
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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
                                    background-image: url('assets/images/test4.jpg');
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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
                                    background-image: url('assets/images/test5.jpg');
                                  "></div>
                        <div class="card-body">
                            <h5 class="card-title">Golden Dragon</h5>
                            <div class="cuisines">
                                <span>South Indian</span><span>Beverages</span>
                            </div>
                            <p class="location"><i class="bx bx-location-plus"></i> 302 Potrero Ave, San
                                Francisco, CA
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

@endsection