  <!-- header -->
  <script type="text/javascript">
    function updateCart() {
        $.post('{{ route('frnt-update-cart'); }}', {_token: '{{ csrf_token() }}'}, function (data) {
            $('#cart').empty().html(data);
        });
    }
  </script>
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
                <ul class="navbar-nav uppercase">
                </ul>
                <ul class="navbar-nav uppercase">
                    <div class="btn-group show-on-hover">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            {{ app()->getLocale() }}
                            @if (count($languages) > 1)
                                <span class="caret ml-1"></span>
                            @endif
                        </button>
                        @if (count($languages) > 1)
                            <ul class="dropdown-menu" role="menu">
                                @foreach ($languages as $language)
                                    @if (\Illuminate\Support\Facades\App::getLocale() !== $language->code)
                                        <li class="block px-4 py-2 text-sm text-gray-700"><a
                                                href="{{ route('change_language', $language->code) }}"
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
                            <a class="nav-link navbar-font"
                                href="{{ route('login') }}">{{ __('Sign in') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navbar-font"
                                href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link navbar-font" href="{{ route('myaccount') }}">
                                <i class='bx bx-user mr-1'></i>
                                {{ Auth::user()->f_name ?? Auth::user()->email }}
                                <i class='bx bx-chevron-down ml-1'></i>
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
                        <div class="btn-group show-on-hover dropleft">
                            <button type="button" class="btn btn-default dropdown-toggle" onclick="updateCart()" data-toggle="dropdown">
                                <span class="cart-badge-wrap">
                                    @if( session('cart'))
                                    <span class="cart-badge">{{ count( session('cart')) }}</span>
                                    @endif
                                    <i class='bx bx-shopping-bag mr-1'></i>
                                    </span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <div id="cart"></div>
                            </div>
                        </div>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>