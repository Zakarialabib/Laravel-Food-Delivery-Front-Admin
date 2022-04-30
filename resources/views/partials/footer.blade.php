<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{{__('Quick links')}}</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">{{_('Home')}}</a></li>
                        <li><a href="{{ route('restaurant_listing') }}">{{__('Restaurants')}}</a></li>
                        <li>
                            <a href="{{ $landing_page_links['app_url_android'] }}" class="footer-item">
                                Play Store</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ $landing_page_links['app_url_ios'] }}" class="footer-item">App
                                Store</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{{__('Quick links')}}</h3>
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
                        {{-- <li><a href="faq.html">FAQ</a></li>
                        <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li> --}}
                    </ul>
                </div>


                <div class="col-lg-4 col-md-6">
                    <h3>{{__('Contact us')}}</h3>
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
                <a href="">
                    <i class='bx bx-search'></i>
                    <span>{{__('Search')}}</span>
                </a>
            </div>
            <div class="col-4 item">
                <a href="">
                    <i class='bx bx-cart'><span class="badge badge-light">22</span></i>
                    <span>Cart</span>
                </a>
            </div>
            <div class="col-4 item">
                <a href="">
                    <i class='bx bx-user'></i>
                    <span>Account</span>
                </a>
            </div>
        </div>
    </div>

    <!-- mobile footer end -->

</footer>