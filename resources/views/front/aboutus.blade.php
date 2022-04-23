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
    <title>FoodDay - About Us</title>
</head>

<body>

    <!-- header -->
    <header>
        <div class="container-fluid">
            <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light fixed-top">
                <a class="navbar-brand" href="home.html"><img src="{{asset('assets/images/logo.png')}}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
                        </li>
                       

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('signin')}}">Sign In</a>
                        </li>
                        <livewire:cart-count />
                       
                       
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- Header -->

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">About Us</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">

            <div class="row">

                <div class="col-lg-10 offset-lg-1">
                    <div class="about-us-wrap">
                        <h4>Who We Are?</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas temporibus repellendus,
                            minus velit sapiente accusantium expedita itaque quae! Odio aspernatur exercitationem
                            itaque, quibusdam qui nulla? Rerum quidem sed a, minus mollitia quia accusamus suscipit ab!
                        </p>
                        <P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, repellendus assumenda eius
                            perspiciatis enim dolore error asperiores consequatur consectetur reiciendis fuga recusandae
                            non nesciunt pariatur porro! Laborum sapiente eligendi illo, velit laudantium esse
                            voluptatibus ratione facere obcaecati necessitatibus blanditiis tempora sunt officia quasi
                            ex minima aliquid ipsum earum, minus maiores?</P>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint repellat omnis quam fugit
                            expedita et, explicabo soluta temporibus molestias alias, ea blanditiis molestiae veritatis
                            hic necessitatibus doloremque enim eius fugiat animi inventore? Iure consectetur non
                            officiis. Saepe distinctio est, possimus delectus eligendi provident, non labore eum odio
                            quam nam natus consequatur. Dolore, temporibus vel minima repellendus voluptatem enim non
                            praesentium.</p>
                        <img src="assets/images/slide3.jpg" alt="" class="img-fluid">
                        <h4>Our Mission</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam doloribus, a qui architecto
                            omnis reiciendis! Culpa cum voluptates suscipit perspiciatis expedita distinctio commodi
                            sapiente dolores ipsum numquam deserunt, soluta eum nemo odit harum reprehenderit dolor
                            obcaecati vitae eaque tempore. Dolore!</p>
                        <h4>Our Vision</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil accusantium, rerum laudantium
                            nisi quidem dolore ab eaque eos tempore cupiditate sint velit dolores minima fugit.</p>
                        <h4>Meet Our Team</h4>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Explicabo, culpa repellat vitae
                            pariatur quod possimus? Mollitia numquam ut odit aut, perspiciatis esse rem autem
                            praesentium.</p>
                        <div class="team-wrap">
                            <div class="row">

                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_11.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>CEO</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_21.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>COO</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_31.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>CFO</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_41.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>CTO</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_41.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>Mentor</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_11.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>John Doe</h4>
                                            <h5>Creative Head</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_31.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>Jonny James</h4>
                                            <h5>Designs Head</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-item">
                                        <div class="team-image">
                                            <img src="{{asset('assets/images/team_21.png')}}" alt="">
                                        </div>
                                        <div class="team-desc">
                                            <h4>Max Johnson</h4>
                                            <h5>Marketing Manager</h5>
                                        </div>
                                    </div>
                                </div>

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
                    <div class="col-lg-3 col-md-6">
                        <h3>Quick links</h3>
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('restaurant_listing')}}">Restaurants</a></li>
                            <li><a href="{{route('customer.aboutus')}}">About us</a></li>
                            <li><a href="{{route('customer.contact')}}">Contact</a></li>
                           
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3>Quick links</h3>
                        <ul>

                            <li><a href="enrol-delivery-boy.html">Enroll Delivery Boy</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="enrol-your-restaurant.html">Enroll Your Restaurant</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h3>Subscribe to newsletter</h3>
                        <p>Join our newsletter to keep be informed about offers and news.</p>
                        <form action="">
                            <div class="input-group newsletter-group">
                                <input type="text" class="form-control" placeholder="Enter your email" aria-label=""
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" id="find-food-btn"><i
                                            class='bx bx-send'></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-6">
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