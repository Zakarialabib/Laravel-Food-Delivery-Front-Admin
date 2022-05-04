<x-app-layout>
    <div class="search-nav restaurant-head" 
        {{-- style="background-image: url({{ asset('storage/app/public/restaurant/cover/' . $restaurant->cover_photo) }});
               background-size: cover;" --}}
        >
        <div class="container">
            <div class="rest-info-wrap">
                <div class="rest-logo" style="background-image: url({{ asset('storage/app/public/restaurant/' . $restaurant->logo) }});">
                </div>
                <div>
                    <h3>{{ $restaurant->name }}</h3>

                    <div class="cuisines">
                        @foreach ($itemfoods as $cuisine)
                            @if ($restaurant->foods)
                                <span>
                                    {{ $cuisine->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <p><i class="bx bx-location-plus"></i> {{ $restaurant->address }}</p>
                </div>
            </div>
            <div class="details justify-center">
                @if (empty($restaurant->rating))
                <div class="detail-block">
                        <span class="badge"><i class='bx bxs-star'></i> {{ $restaurant->rating }}</span>
                    </div>
                @endif
                <div class="detail-block">
                    <h5>{{ $restaurant->delivery_time }}</h5>
                    <span>{{__('Delivery Time')}}</span>
                </div>
                <div class="detail-block">
                    <h5>AM {{ $restaurant->opening_time->format('h:m') }} / PM
                        {{ $restaurant->closeing_time->format('h:m') }}</h5>
                    <span>{{__('Opening and Closing Time')}}</span>
                </div>
                <div class="detail-block">
                    @if ($restaurant->take_away == 1)
                        <h5><i class="bx bx-walk"></i>{{__('Pick Up')}}</h5>
                        <span>{{__('Pick Up Available')}}</span>
                    @else
                        <h5><i class="bx bx-walk"></i> {{__('No Pick Up')}}</h5>
                        <span>{{__('Pick Up Not Available')}}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <div class="row cuisine-dish-wrap">
                <div class="col-lg-8 cuisine-col">
                    <div class="rest-menus" id="rest-menus">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <ul class="nav sub-cat-nav">
                                    @foreach ($itemfoods as $item)
                                        @if ($restaurant->foods->contains($item->id))
                                            <li class="nav-item">
                                                <a class="nav-link js-scroll-trigger"
                                                    href="#sub-cat2">{{ $item->food_item }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                <div class="food-item-cards-wrap">
                                    <div class="sub-cat mt-0" id="sub-cat1">
                                        <h4 class="mb-4">{{__('Most Popular')}}</h4>

                                        @if ($restaurant->active == 1)
                                            <livewire:fooditem :restaurant="$restaurant" />
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
                                                                        {{-- array for options 
                                                                            {{$item->choice_options}} --}}
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
                                                                            {{ $item->price }}DH
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
    </section>
    <!--cart modal-->
</x-app-layout>