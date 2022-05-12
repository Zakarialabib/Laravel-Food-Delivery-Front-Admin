@push('styles')
    <style>
        .btn-check {
            position: absolute;
            clip: rect(0, 0, 0, 0);
            pointer-events: none;
        }

        .choice-input {
            width: 7rem;
        }

        .addon-input {
            height: 7rem;
            width: 7rem;
        }

        .addon-quantity-input {
            height: 2rem;
            width: 7rem;
            z-index: 9;
            bottom: 1rem;
            visibility: hidden;
        }

        .check-label {
            background-color: #F3F3F3;
            color: #000000;
            border-width: 2px;
            border-color: #BABFC4;
            font-weight: bold;
        }

        .btn-check:checked+.check-label {
            background-color: #EF7822;
            color: #FFFFFF;
            border: none;
        }

    </style>
@endpush

<div class="modal-header p-2">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="d-flex flex-row">
        @if (config('toggle_veg_non_veg'))
            <span
                class="badge badge-{{ $product->veg ? 'success' : 'danger' }} position-absolute">{{ $product->veg ? __('Veg') : __('Non veg') }}</span>
        @endif
        <!-- Product gallery-->
        <div class="d-flex align-items-center justify-content-center active" style="height:9.5rem;">
            @if (empty($product['image']))
                <img class="img-responsive" style="height:100%;width:auto;overflow:hidden;border-radius: 5%;"
                    src="{{ asset('storage/app/public/product/' . $product['image']) }}"
                    data-zoom="{{ asset('storage/app/public/product/' . $product['image']) }}"
                    alt="{{ $product->name }}">
            @else
                <img alt="{{ $product->name }}" class="img-responsive"
                    style="height:100%;width:auto;overflow:hidden;border-radius: 5%;"
                    src="data:image/svg+xml,%3Csvg%20width%3D%22344%22%20height%3D%22194%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cdefs%3E%3Cpath%20id%3D%22a%22%20d%3D%22M-1%200h344v194H-1z%22%2F%3E%3C%2Fdefs%3E%3Cg%20transform%3D%22translate(1)%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cmask%20id%3D%22b%22%20fill%3D%22%23fff%22%3E%3Cuse%20xlink%3Ahref%3D%22%23a%22%2F%3E%3C%2Fmask%3E%3Cuse%20fill%3D%22%23BDBDBD%22%20xlink%3Ahref%3D%22%23a%22%2F%3E%3Cg%20mask%3D%22url(%23b)%22%3E%3Cpath%20d%3D%22M173.65%2069.238L198.138%2027%20248%20112.878h-49.3c.008.348.011.697.011%201.046%200%2028.915-23.44%2052.356-52.355%2052.356C117.44%20166.28%2094%20142.84%2094%20113.924c0-28.915%2023.44-52.355%2052.356-52.355%2010%200%2019.347%202.804%2027.294%207.669zm0%200l-25.3%2043.64h50.35c-.361-18.478-10.296-34.61-25.05-43.64z%22%20fill%3D%22%23757575%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E">
            @endif
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details pl-2">
            <a class="py-2 font-semibold text-2xl capitalize text-break">{{ $product->name }}</a>

            <div class="py-2 text-dark">
                <span class="text-xl text-accent mr-1 text-break">
                    {{ \App\CentralLogics\Helpers::get_price_range($product, true) }}
                </span><br>
                @if ($product->discount > 0 || \App\CentralLogics\Helpers::get_restaurant_discount($product->restaurant))
                    <strike class="text-xs text-red-500">
                        {{ \App\CentralLogics\Helpers::get_price_range($product) }}
                    </strike>
                @endif
            </div>

            @if ($product->discount > 0)
                <div class="mb-3 flex text-center">
                    <strong>{{ __('Discount') }} : </strong>
                    <strong class="bg-red-500 px-2 font-bold text-white"
                        id="set-discount-amount">{{ \App\CentralLogics\Helpers::get_product_discount($product) }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <?php
            $cart = false;
            if (session()->has('cart')) {
                foreach (session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }?>
            <h2 class="mt-2 text-dark text-xl">{{ __('Description') }}</h2>
            <span class="d-block text-dark text-break">
                {!! $product->description !!}
            </span>
            <form id="add-to-cart-form" class="mb-2">
                @csrf
                {{-- <input type="hidden" name="id" value="{{ $product->id }}"> --}}
                @foreach (json_decode($product->choice_options) as $key => $choice)
                    <h3 class="mt-2 text-dark text-xl">{{ $choice->title }}
                    </h3>

                    <div class="d-flex justify-content-left flex-wrap">
                        @foreach ($choice->options as $key => $option)
                            <input class="btn-check" type="radio" id="{{ $choice->name }}-{{ $option }}"
                                name="{{ $choice->name }}" value="{{ $option }}"
                                @if ($key == 0) checked @endif autocomplete="off">
                            <label class="btn btn-sm check-label mx-1 choice-input text-break"
                                for="{{ $choice->name }}-{{ $option }}">{{ Str::limit($option, 20, '...') }}</label>
                        @endforeach
                    </div>
                @endforeach

                <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between py-4 border-b border-gray-200">
                    <div class="mt-2 text-dark text-xl">{{ __('Quantity') }}:</div>
                    <div class="product-quantity flex items-center justify-betweenr">
                        <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button" data-type="minus"
                                    data-field="quantity" disabled="disabled" style="padding: 10px">
                                    <i class="tio-remove  font-weight-bold"></i>
                                </button>
                            </span>
                            <input type="text" name="quantity"
                                class="form-control input-number text-center cart-qty-field" placeholder="1" value="1"
                                min="1" max="100">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button" data-type="plus"
                                    data-field="quantity" style="padding: 10px">
                                    <i class="tio-add  font-weight-bold"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                @php($add_ons = json_decode($product->add_ons))
                @if (count($add_ons) > 0)
                    <div class="mt-2 text-dark text-xl">{{ __('Addon') }} :</div>
                    @foreach (\App\Models\AddOn::whereIn('id', $add_ons)->active()->get() as $key => $add_on)
                        <div class="py-4 border-b border-gray-200 flex items-center justify-between">
                            <input type="hidden" name="addon-price{{ $add_on->id }}" value="{{ $add_on->price }}">
                            <input class="btn-check addon-chek" type="checkbox" id="addon{{ $key }}"
                                onchange="addon_quantity_input_toggle(event)" name="addon_id[]"
                                value="{{ $add_on->id }}" autocomplete="off">
                            <label class="d-flex align-items-center btn btn-sm check-label mx-1 addon-input text-break"
                                for="addon{{ $key }}">{{ Str::limit($add_on->name, 20, '...') }} <br>
                                {{ \App\CentralLogics\Helpers::format_currency($add_on->price) }}</label>
                            <label class="input-group addon-quantity-input mx-1 shadow bg-white rounded px-1"
                                for="addon{{ $key }}">
                                <button class="btn btn-sm h-100 text-dark px-0" type="button"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown(), getVariantPrice()"><i
                                        class="tio-remove  font-weight-bold"></i></button>
                                <input type="number" name="addon-quantity{{ $add_on->id }}"
                                    class="form-control text-center border-0 h-100" placeholder="1" value="1" min="1"
                                    max="100" readonly>
                                <button class="btn btn-sm h-100 text-dark px-0" type="button"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp(), getVariantPrice()"><i
                                        class="tio-add  font-weight-bold"></i></button>
                            </label>
                        </div>
                    @endforeach

                @endif
                <div class="row no-gutters d-none mt-2 text-dark" id="chosen_price_div">
                    <div class="col-2">
                        <div class="product-description-label">{{ __('Total Price') }}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price"></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn-primary" onclick="addToCart()" type="button" style="width:37%; height: 45px">
                        <i class="tio-shopping-cart"></i>
                        {{ __('Add to cart') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        cartQuantityInitialize();
        getVariantPrice();
        $('#add-to-cart-form input').on('change', function() {
            getVariantPrice();
        });
    </script>
@endpush
