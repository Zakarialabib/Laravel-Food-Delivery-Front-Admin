<div class="flex flex-row" style="overflow-y: scroll;">
    <table class="table table-bordered">
        <thead class="text-muted">
            <tr>
                <th scope="col">{{ __('Item') }}</th>
                <th scope="col" class="text-center">{{ __('Qty') }}</th>
                <th scope="col">{{ __('Price') }}</th>
                <th scope="col">{{ __('Delete') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subtotal = 0;
            $addon_price = 0;
            $tax = \App\CentralLogics\Helpers::get_restaurant_data()->tax;
            $discount = 0;
            $discount_type = 'amount';
            $discount_on_product = 0;
            ?>
            @if (session()->has('cart') && count(session()->get('cart')) > 0)
                <?php
                $cart = session()->get('cart');
                if (isset($cart['tax'])) {
                    $tax = $cart['tax'];
                }
                if (isset($cart['discount'])) {
                    $discount = $cart['discount'];
                    $discount_type = $cart['discount_type'];
                }
                ?>
                @foreach (session()->get('cart') as $key => $cartItem)
                    @if (is_array($cartItem))
                        <?php
                        $product_subtotal = $cartItem['price'] * $cartItem['quantity'];
                        $discount_on_product += $cartItem['discount'] * $cartItem['quantity'];
                        $subtotal += $product_subtotal;
                        $addon_price += $cartItem['addon_price'];
                        ?>
                        <tr>
                            <td class="media align-items-center cursor-pointer"
                                onclick="quickViewCartItem({{ $cartItem['id'] }}, {{ $key }})">
                                <img class="avatar avatar-sm mr-1"
                                    src="{{ asset('storage/app/public/product') }}/{{ $cartItem['image'] }}"
                                    onerror="this.src='data:image/svg+xml,%3Csvg%20width%3D%22344%22%20height%3D%22194%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cdefs%3E%3Cpath%20id%3D%22a%22%20d%3D%22M-1%200h344v194H-1z%22%2F%3E%3C%2Fdefs%3E%3Cg%20transform%3D%22translate(1)%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cmask%20id%3D%22b%22%20fill%3D%22%23fff%22%3E%3Cuse%20xlink%3Ahref%3D%22%23a%22%2F%3E%3C%2Fmask%3E%3Cuse%20fill%3D%22%23BDBDBD%22%20xlink%3Ahref%3D%22%23a%22%2F%3E%3Cg%20mask%3D%22url(%23b)%22%3E%3Cpath%20d%3D%22M173.65%2069.238L198.138%2027%20248%20112.878h-49.3c.008.348.011.697.011%201.046%200%2028.915-23.44%2052.356-52.355%2052.356C117.44%20166.28%2094%20142.84%2094%20113.924c0-28.915%2023.44-52.355%2052.356-52.355%2010%200%2019.347%202.804%2027.294%207.669zm0%200l-25.3%2043.64h50.35c-.361-18.478-10.296-34.61-25.05-43.64z%22%20fill%3D%22%23757575%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E'"
                                    alt="{{ $cartItem['name'] }} image">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0">{{ Str::limit($cartItem['name'], 10) }}</h5>
                                    <small>{{ Str::limit($cartItem['variant'], 20) }}</small>
                                </div>
                            </td>
                            <td class="align-items-center text-center">
                                <input type="number" data-key="{{ $key }}"
                                    style="width:50px;text-align: center;" value="{{ $cartItem['quantity'] }}"
                                    min="1" onkeyup="updateQuantity(event)">
                            </td>
                            <td class="text-center px-0 py-1">
                                <div class="btn">
                                    {{ \App\CentralLogics\Helpers::format_currency($product_subtotal) }}
                                </div> <!-- price-wrap .// -->
                            </td>
                            <td class="align-items-center text-center">
                                <a href="javascript:removeFromCart({{ $key }})"
                                    class="btn btn-sm btn-outline-danger"> <i class="tio-delete-outlined"></i></a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>


    <?php
    $total = $subtotal + $addon_price;
    $discount_amount = $discount_type == 'percent' && $discount > 0 ? (($total - $discount_on_product) * $discount) / 100 : $discount;
    $total -= $discount_amount + $discount_on_product;
    $total_tax_amount = $tax > 0 ? ($total * $tax) / 100 : 0;
    ?>
    <div class="box p-3">
        <dl class="row text-sm-right">

            <dt class="col-sm-6">{{ __('Addon') }}:</dt>
            <dd class="col-sm-6 text-right">{{ \App\CentralLogics\Helpers::format_currency($addon_price) }}</dd>

            <dt class="col-sm-6">{{ __('Subtotal') }}:</dt>
            <dd class="col-sm-6 text-right">
                {{ \App\CentralLogics\Helpers::format_currency($subtotal + $addon_price) }}</dd>


            <dt class="col-sm-6">{{ __('Discount') }} :</dt>
            <dd class="col-sm-6 text-right">-
                {{ \App\CentralLogics\Helpers::format_currency(round($discount_on_product, 2)) }}</dd>

            <dt class="col-sm-6">{{ __('Extra discount') }} :</dt>
            <dd class="col-sm-6 text-right"><button class="btn btn-sm" type="button" data-toggle="modal"
                    data-target="#add-discount"><i class="tio-edit"></i></button>-
                {{ \App\CentralLogics\Helpers::format_currency(round($discount_amount, 2)) }}</dd>

            <dt class="col-sm-6">{{__('Tax')}} : </dt>
            <dd class="col-sm-6 text-right"><button class="btn btn-sm" type="button" data-toggle="modal"
                    data-target="#add-tax"><i
                        class="tio-edit"></i></button>{{ \App\CentralLogics\Helpers::format_currency(round($total_tax_amount, 2)) }}
            </dd>

            <dt class="col-sm-6">{{__('Total')}}: </dt>
            <dd class="col-sm-6 text-right h4 b">
                {{ \App\CentralLogics\Helpers::format_currency(round($total + $total_tax_amount, 2)) }} </dd>
        </dl>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-danger btn-sm btn-block" onclick="emptyCart()"><i
                        class="fa fa-times-circle "></i> {{ __('Cancel') }} </a>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn  btn-primary btn-sm btn-block" data-toggle="modal"
                    data-target="#paymentModal"><i class="fa fa-shopping-bag"></i>
                    {{ __('Order') }} </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-discount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Update discount') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendor.pos.discount') }}" method="post" class="row">
                        @csrf
                        <div class="form-group col-sm-6">
                            <label for="">{{ __('Discount') }}</label>
                            <input type="number" class="form-control" name="discount" min="0" id="discount_input"
                                value="{{ $discount }}"
                                max="{{ $discount_type == 'percent' ? 100 : 1000000000 }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">{{ __('Type') }}</label>
                            <select name="type" class="form-control" id="discount_input_type"
                                onchange="document.getElementById('discount_input').max=(this.value=='percent'?100:1000000000);">
                                <option value="amount" {{ $discount_type == 'amount' ? 'selected' : '' }}>
                                    {{ __('Amount') }}({{ \App\CentralLogics\Helpers::currency_symbol() }})
                                </option>
                                <option value="percent" {{ $discount_type == 'percent' ? 'selected' : '' }}>
                                    {{ __('Percent') }}(%)</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-tax" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Update tax') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendor.pos.tax') }}" method="POST" class="row"
                        id="order_submit_form">
                        @csrf
                        <div class="form-group col-12">
                            <label for="">{{ __('Tax') }}(%)</label>
                            <input type="number" class="form-control" name="tax" min="0">
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendor.pos.order') }}" id='order_place' method="post"
                        class="row">
                        @csrf
                        <input type="hidden" name="user_id" id="customer_id">
                        <div class="form-group col-12">
                            <label class="input-label"
                                for="">{{ __('Amount') }}({{ \App\CentralLogics\Helpers::currency_symbol() }})</label>
                            <input type="number" class="form-control" name="amount" min="0" step="0.01"
                                value="{{ round($total + $total_tax_amount, 2) }}">
                        </div>
                        <div class="form-group col-12">
                            <label class="input-label" for="">{{ __('Type') }}</label>
                            <select name="type" class="form-control">
                                <option value="cash">{{ __('Cash') }}</option>
                                <option value="card">{{ __('Card') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
