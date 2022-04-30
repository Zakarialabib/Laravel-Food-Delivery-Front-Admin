<div class="col-lg-3">
    <div class="my-account-menu">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link {{ Request::is('order_history') ? 'active' : '' }}"
                href="{{ route('order_history') }}" role="tab" aria-controls="v-pills-profile"
                aria-selected="false"><i class='bx bxs-cart'></i> {{ __('Orders') }}</a>

            <!-- <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-wishlist"
                            role="tab" aria-controls="v-pills-messages" aria-selected="false"><i
                                class='bx bxs-heart'></i> Wishlist</a> -->
            <a class="nav-link {{ Request::is('address') ? 'active' : '' }}"
                href="{{ route('address') }}" role="tab" aria-controls="v-pills-messages"
                aria-selected="false"><i class='bx bxs-home-smile'></i> {{ __('Addresses') }}</a>
            <a class="nav-link {{ Request::is('account') ? 'active' : '' }}"
                href="{{ route('account') }}" role="tab" aria-controls="v-pills-settings"
                aria-selected="false"><i class='bx bxs-user-rectangle'></i> {{ __('Account Details') }}</a>
            <a class="nav-link {{ Request::is('change_password') ? 'active' : '' }}"
                href="{{ route('show_password') }}" role="tab" aria-controls="v-pills-settings"
                aria-selected="false"><i class='bx bxs-wallet-alt'></i> {{ __('Change Password') }}</a>
            <a class="nav-link" href="{{ route('logout') }}" role="tab"
                aria-controls="v-pills-settings" aria-selected="false"><i class='bx bxs-log-out'></i>
                {{ __('Logout') }}</a>
            <!-- <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-no-orders"
                            role="tab" aria-controls="v-pills-settings" aria-selected="false"><i
                                class='bx bxs-log-out'></i> No Orders</a> -->
        </div>
    </div>
</div>