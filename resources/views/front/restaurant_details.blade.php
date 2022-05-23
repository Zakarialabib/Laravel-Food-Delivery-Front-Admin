<x-app-layout>
    @section('title', $restaurant->name)
    {{-- loader --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="loading" style="display: none;">
                    <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                        <img width="200" src="{{ asset('public/assets/admin/img/loader.gif') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- loader --}}
    <div class="bg-gray-100 py-10 restaurant-head" {{-- style="background-image: url({{ asset('storage/app/public/restaurant/cover/' . $restaurant->cover_photo) }});
               background-size: cover;" --}}>

        <div class="container">
            <div class="rest-info-wrap">
                <div class="rest-logo"
                    style="background-image: url({{ asset('storage/app/public/restaurant/' . $restaurant->logo) }});">
                </div>
                <div>
                    <h3>{{ $restaurant->name }}</h3>

                    <div class="details justify-center">
                        <div class="detail-block">
                            <div>
                                <h5 class="pt-2 "> {{ Str::limit($restaurant->address, 30, '...') }}</h5>
                                <p class="py-2"><i class="bx bx-location-plus"></i>{{ __('Address') }}</p>
                            </div>
                        </div>
                        @if (empty($restaurant->rating))
                            <div class="detail-block">
                                <p class="py-2 badge"><i class='bx bxs-star'></i> {{ $restaurant->rating }}</p>
                            </div>
                        @endif
                        <div class="detail-block">
                            <h5 class="pt-2">{{ $restaurant->delivery_time }} {{ __('Minutes') }}</h5>
                            <p class="py-2">{{ __('Delivery Time') }}</p>
                        </div>
                        <div class="detail-block">
                            <h5 class="pt-2">AM {{ $restaurant->opening_time->format('h:m') }} / PM
                                {{ $restaurant->closeing_time->format('h:m') }}</h5>
                            <p class="py-2">{{ __('Opening and Closing Time') }}</p>
                        </div>
                        <div class="detail-block">
                            @if ($restaurant->take_away == 1)
                                <h5 class="pt-2"><i class="bx bx-walk"></i>{{ __('Pick Up') }}</h5>
                                <p class="py-2">{{ __('Pick Up Available') }}</p>
                            @else
                                <h5 class="pt-2"><i class="bx bx-walk"></i> {{ __('No Pick Up') }}</h5>
                                <p class="py-2">{{ __('Pick Up Not Available') }}</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            {{-- @if ($map_enabled == 1)
                
            @endif --}}
            <div class="w-full">
                <div id="map" style="height:180px; width:100%;"></div>
            </div>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <div class="row cuisine-dish-wrap">
                <div class="col-lg-8 cuisine-col">
                    <div class="card-header d-flex flex-wrap justify-content-between">
                        <form id="search-form" class="header-item">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bx bx-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" value="{{ $keyword ? $keyword : '' }}"
                                    name="search" class="form-control" placeholder="{{ __('Search here') }}"
                                    aria-label="{{ __('Search here') }}">
                            </div>
                            <!-- End Search -->
                        </form>
                        <div class="input-group header-item" style="width:250px;">
                            <select name="category" id="category" class="form-control js-select2-custom mx-1"
                                title="{{ __('Select category') }}" onchange="set_category_filter(this.value)">
                                <option value="">{{ __('All categories') }}</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ $category == $item->id ? 'selected' : '' }}>
                                        {{ Str::limit($item->name, 20, '...') }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="rest-menus bg-gray-100" id="rest-menus">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">

                                <div class="food-item-cards-wrap">
                                    <div id="sub-cat1">
                                        <h4 class="text-center py-4">{{ __('Most Popular') }}</h4>

                                        @if ($restaurant->active == 1)
                                            <div class="flex flex-wrap overflow-hidden">
                                                @foreach ($products as $product)
                                                    <div class="px-4 py-4 lg:w-1/3 md:w-1/3 sm-w-1/2">
                                                        @include('front.single_product', [
                                                            'product' => $product,
                                                            'restaurant' => $restaurant,
                                                        ])
                                                        {{-- <hr class="d-sm-none"> --}}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="p-4">
                                                {!! $products->withQueryString()->links('layouts.tailwind') !!}
                                            </div>
                                            {{-- <livewire:fooditem :restaurant="$restaurant" /> --}}
                                        @else
                                            <div class="row">
                                                @foreach ($restaurant->foods as $item)
                                                    <div class="col-lg-6">
                                                        <div class="food-item-card unavailable">
                                                            <div class="food-item-img"
                                                                style="background-image: url({{ asset('storage/app/public/product/' . $item->image) }});">
                                                            </div>
                                                            <div class="food-item-body">
                                                                <h5 class="card-title">
                                                                    {{ $item->name }}
                                                                </h5>
                                                                <div class="pricing">
                                                                    <div class="price-wrap">
                                                                        @if ($item->status == 1)
                                                                            <div class="non-div food-type-div">
                                                                                <i class="bx bxs-circle"></i>
                                                                            </div>
                                                                        @else
                                                                            <div class="veg-div food-type-div">
                                                                                <i class="bx bxs-circle"></i>
                                                                            </div>
                                                                        @endif

                                                                        <span class="price">
                                                                            {{ \App\CentralLogics\Helpers::format_currency($item['price']) }}
                                                                        </span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <livewire:cart />
            </div>
        </div>
    </section>
    <!--cart modal-->


    <div class="modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>

    @push('scripts')
        <script
                src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&callback=initMap&v=3.45.8">
        </script>
        <script>
            const myLatLng = {
                lat: {{ $restaurant->latitude }},
                lng: {{ $restaurant->longitude }}
            };
            let map;
            initMap();

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: myLatLng,
                });
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "{{ $restaurant->name }}",
                });
            }

            function set_category_filter(id) {
                var nurl = new URL('{!! url()->full() !!}');
                nurl.searchParams.set('category_id', id);
                location.href = nurl;
            }


            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var keyword = $('#datatableSearch').val();
                var nurl = new URL('{!! url()->full() !!}');
                nurl.searchParams.set('keyword', keyword);
                location.href = nurl;
            });

            function addon_quantity_input_toggle(e) {
                var cb = $(e.target);
                if (cb.is(":checked")) {
                    cb.siblings('.addon-quantity-input').css({
                        'visibility': 'visible'
                    });
                } else {
                    cb.siblings('.addon-quantity-input').css({
                        'visibility': 'hidden'
                    });
                }
            }

            function quickView(product_id) {
                $.get({
                    url: '{{ route('quick-view') }}',
                    dataType: 'json',
                    data: {
                        product_id: product_id
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        console.log("success...")
                        $('#quick-view').modal('show');
                        $('#quick-view-modal').empty().html(data.view);
                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            }

            function quickViewCartItem(product_id, item_key) {
                $.get({
                    url: '{{ route('quick-view-cart-item') }}',
                    dataType: 'json',
                    data: {
                        product_id: product_id,
                        item_key: item_key
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        console.log("success...")
                        $('#quick-view').modal('show');
                        $('#quick-view-modal').empty().html(data.view);
                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            }


            function checkAddToCartValidity() {
                var names = {};
                $('#add-to-cart-form input:radio').each(function() { // find unique names
                    names[$(this).attr('name')] = true;
                });
                var count = 0;
                $.each(names, function() { // then count them
                    count++;
                });
                if ($('input:radio:checked').length == count) {
                    return true;
                }
                return false;
            }

            function cartQuantityInitialize() {
                $('.btn-number').click(function(e) {
                    e.preventDefault();

                    var fieldName = $(this).attr('data-field');
                    var type = $(this).attr('data-type');
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());

                    if (!isNaN(currentVal)) {
                        if (type == 'minus') {

                            if (currentVal > input.attr('min')) {
                                input.val(currentVal - 1).change();
                            }
                            if (parseInt(input.val()) == input.attr('min')) {
                                $(this).attr('disabled', true);
                            }

                        } else if (type == 'plus') {

                            if (currentVal < input.attr('max')) {
                                input.val(currentVal + 1).change();
                            }
                            if (parseInt(input.val()) == input.attr('max')) {
                                $(this).attr('disabled', true);
                            }

                        }
                    } else {
                        input.val(0);
                    }
                });

                $('.input-number').focusin(function() {
                    $(this).data('oldValue', $(this).val());
                });

                $('.input-number').change(function() {

                    minValue = parseInt($(this).attr('min'));
                    maxValue = parseInt($(this).attr('max'));
                    valueCurrent = parseInt($(this).val());

                    var name = $(this).attr('name');
                    if (valueCurrent >= minValue) {
                        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: 'Sorry, the minimum value was reached'
                        });
                        $(this).val($(this).data('oldValue'));
                    }
                    if (valueCurrent <= maxValue) {
                        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: 'Sorry, stock limit exceeded.'
                        });
                        $(this).val($(this).data('oldValue'));
                    }
                });
                $(".input-number").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            }

            function getVariantPrice() {
                if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{ route('variant_price') }}',
                        data: $('#add-to-cart-form').serializeArray(),
                        success: function(data) {
                            $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                            $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                        }
                    });
                }
            }

            function addToCart(form_id = 'add-to-cart-form') {
                if (checkAddToCartValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.post({
                        url: '{{ route('add-to-cart') }}',
                        data: $('#' + form_id).serializeArray(),
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(data) {
                            if (data.data == 1) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Cart',
                                    text: "{{ __('product_already Added in_cart') }}"
                                });
                                return false;
                            } else if (data.data == 2) {
                                updateCart();
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Cart',
                                    text: "{{ __('product_has_been updated in_cart') }}"
                                });

                                return false;
                            } else if (data.data == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Cart',
                                    text: "{{ __('Sorry, product out of stock') }}"
                                });
                                return false;
                            }
                            $('.call-when-done').click();

                            toastr.success('{{ __('product_has_been Added in_cart') }}', {
                                CloseButton: true,
                                ProgressBar: true
                            });

                            updateCart();
                        },
                        complete: function() {
                            $('#loading').hide();
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'info',
                        title: 'Cart',
                        text: "{{ __('Please choose all the options') }}"
                    });
                }
            }

            function removeFromCart(key) {
                $.post('{{ route('remove-from-cart') }}', {
                    _token: '{{ csrf_token() }}',
                    key: key
                }, function(data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        updateCart();
                        toastr.info('{{ __('item_has_been_removed_from_cart') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                });
            }

            function emptyCart() {
                $.post('{{ route('emptyCart') }}', {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    updateCart();
                    toastr.info('Item has been removed from cart', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                });
            }



            $(function() {
                $(document).on('click', 'input[type=number]', function() {
                    this.select();
                });
            });


            function updateQuantity(e) {
                var element = $(e.target);
                var minValue = parseInt(element.attr('min'));
                // maxValue = parseInt(element.attr('max'));
                var valueCurrent = parseInt(element.val());

                var key = element.data('key');
                if (valueCurrent >= minValue) {
                    $.post('{{ route('updateQuantity') }}', {
                        _token: '{{ csrf_token() }}',
                        key: key,
                        quantity: valueCurrent
                    }, function(data) {
                        updateCart();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cart',
                        text: 'Sorry, the minimum value was reached'
                    });
                    element.val(element.data('oldValue'));
                }
                // if (valueCurrent <= maxValue) {
                //     $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                // } else {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Cart',
                //         text: 'Sorry, stock limit exceeded.'
                //     });
                //     $(this).val($(this).data('oldValue'));
                // }


                // Allow: backspace, delete, tab, escape, enter and .
                if (e.type == 'keydown') {
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                }

            };
        </script>
    @endpush

</x-app-layout>
