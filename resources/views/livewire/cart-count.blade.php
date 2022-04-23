<div>
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
</div>