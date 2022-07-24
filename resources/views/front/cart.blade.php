<section class="p-1">
    <div class="container cart-page">

        @if (session('cart') && count(session('cart')))
            <div class="table-responsive-lg">
                <table class="cart-table table mb-0 pb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Food item') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $ttotal = 0 @endphp
                        @php $total = 0 @endphp
                        @foreach (session('cart') as $id => $details)
                            @php
                                //dd( $details['price'] );
                                $total = 0;
                                $total += $details['price'] * $details['quantity'];
                                $ttotal += $details['price'] * $details['quantity'];
                            @endphp

                            <tr data-id="{{ $id }}">
                                <td class="product-item">
                                    <div class="dish-image">
                                        @if (empty($details['image']))
                                            <img class="aspect-video w-96 rounded-t-2xl object-cover object-center"
                                                src="{{ asset('storage/app/public/product/' . $product['image']) }}">
                                        @else
                                            <img
                                                class="aspect-video w-96 rounded-t-2xl object-cover object-center"src="data:image/svg+xml,%3Csvg%20width%3D%22344%22%20height%3D%22194%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cdefs%3E%3Cpath%20id%3D%22a%22%20d%3D%22M-1%200h344v194H-1z%22%2F%3E%3C%2Fdefs%3E%3Cg%20transform%3D%22translate(1)%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cmask%20id%3D%22b%22%20fill%3D%22%23fff%22%3E%3Cuse%20xlink%3Ahref%3D%22%23a%22%2F%3E%3C%2Fmask%3E%3Cuse%20fill%3D%22%23BDBDBD%22%20xlink%3Ahref%3D%22%23a%22%2F%3E%3Cg%20mask%3D%22url(%23b)%22%3E%3Cpath%20d%3D%22M173.65%2069.238L198.138%2027%20248%20112.878h-49.3c.008.348.011.697.011%201.046%200%2028.915-23.44%2052.356-52.355%2052.356C117.44%20166.28%2094%20142.84%2094%20113.924c0-28.915%2023.44-52.355%2052.356-52.355%2010%200%2019.347%202.804%2027.294%207.669zm0%200l-25.3%2043.64h50.35c-.361-18.478-10.296-34.61-25.05-43.64z%22%20fill%3D%22%23757575%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E">
                                        @endif
                                    </div>
                                    <div class="product-name">
                                        <a href="#">{{ $details['name'] }}</a>
                                    </div>
                                </td>
                                <td>{{ \App\CentralLogics\Helpers::format_currency($details['price']) }}</td>
                                <td>
                                    <div class="add-remove-button">
                                        <div class="input-group">
                                            <a onclick="updateQty('{{ $id }}', 'minus')" min="0"
                                                class="number-button  minus">-</a>
                                            <input type="number" step="1" max=""
                                                value="{{ $details['quantity'] }}" name="quantity"
                                                class="quantity-field">
                                            <a onclick="updateQty('{{ $id }}', 'plus')"
                                                class="number-button  plus">+</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \App\CentralLogics\Helpers::format_currency($total) }}</td>
                                <td>
                                    <a href="#" onclick="removeFromCart(this, '{{ $id }}')"
                                        class="float-right"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="product-item">
                                <a href="{{ route('checkout') }}"
                                    class="btn btn-primary float-right check-out-btn">{{ __('Proceed to checkout') }}</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            {{ __('Your cart is empty') }}
        @endif

    </div>
</section>
