<x-app-layout>
    <!-- Banner -->
    @php($landing_page_text = \App\Models\BusinessSetting::where(['key'=>'landing_page_text'])->first())
    @php($landing_page_text = isset($landing_page_text->value)?json_decode($landing_page_text->value, true):null)
    
    <div class="home-banner d-flex align-items-center">
        <div class="container">
            <div class="banner-content">
                <h1 class="text-center text-5xl pt-4 pb-2" >
                    {{isset($landing_page_text)?$landing_page_text['header_title_1']:''}}
                </h1>
                <h5
                    class="text-center py-4">
                    {{isset($landing_page_text)?$landing_page_text['header_title_2']:''}}
                </h5>
                <h4 class="text-center pt-2 pb-4">
                    {{isset($landing_page_text)?$landing_page_text['header_title_3']:''}}
                </h4>
                {{-- <div class="text-center">
                <form action="{{ route('restaurants.query') }}" method="post" class="flex flex-row relative w-full lg:max-w-xl mx-auto border dark:border-dark-hover overflow-hidden rounded">
                    @csrf
                    <div class="input-group search-location-group">
                        <input id="zipSearch" class="w-full min-h-full px-4 pt-6 pb-2 text-bold dark:bg-dark-primary dark:text-dark-primary" onkeydown="return checkPhoneKey(event.key)" id="search-input" name="postcode" tabindex="1" type="text"  autocomplete="false" pattern="\d{1,4}" maxlength="4" title="Four digit zip code" required>
                        <span class="absolute transform translate-y-1/2 transition duration-500 ease-in-out left-0 ml-4 mt-1 text-sm sm:text-base">Enter your postcode</span>
                    </label>
                    <button class="bg-light-important dark:bg-dark-important hover:bg-light-hover dark:hover:bg-dark-hover text-light-secondary font-bold py-2 px-4 inline-flex items-center">
                        <i class='bx bx-target-lock'></i>
                        <span class="hidden sm:block whitespace-no-wrap">Find restaurant</span>
                    </button>
                </form>
                </div> --}}
                <form action="{{ route('search') }}" method="GET">
                    @csrf
                    <div class="input-group search-location-group">
                        <input type="text" class="form-control" name="search_text" placeholder="Enter your delivery location"
                            aria-label="delivery location" aria-describedby="button-addon2">
                        <a href="" class="btn-locate"><i class='bx bx-target-lock'></i> {{__('Locate Me')}}</a>
                        <div class="input-group-append btn-find-food">
                            <button class="btn btn-danger" type="submit">{{__('Order Now')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Banner End -->

    <!-- How it works -->

    <section class="how-it-works pb-0">
        <div class="container">
            <h4 class="text-4xl pb-5">{{__('How It Works')}}</h4>
            <div class="flex flex-wrap">
                <div class="lg:w-1/3 sm:w-full px-4">
                    <div class="item">
                        <div class="item-image flex justify-center">
                            <img src="{{ asset('public/assets/images/meal.svg') }}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>Choose Your Dish</h4>
                            <p>Choose your favorite meals and order online or by phone. It's easy to customize your
                                order
                            </p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 sm:w-full px-4">
                    <div class="item">
                        <div class="item-image flex justify-center">
                            <img src="{{ asset('public/assets/images/delivery.svg') }}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>We Deliver Your Meals</h4>
                            <p>We prepared and delivered meals arrive at your door. Duis autem vel eum iriure dolor in
                                hendrerit in vulputate.</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 sm:w-full px-4">
                    <div class="item">
                        <div class="item-image flex justify-center">
                            <img src="{{ asset('public/assets/images/eat-enjoy.svg') }}" alt="">
                        </div>
                        <div class="item-desc">
                            <h4>Eat And Enjoy</h4>
                            <p>No shooping, no cooking, no counting and no cleaning. Enjoy your healthy meals with your
                                family.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pb-4">
        <div class="container">
            <h4 class="mb-4">{{__('Popular restaurants')}}</h4>
            <div class="flex flex-wrap -mx-5 overflow-hidden">
                @forelse ($restaurants as $restaurant)
                    <div class="lg:w-1/3 sm:w-full my-2 px-4 ">
                        <a class="card restaurant-card">
                            @if ($restaurant->status == 1)
                                <span class="restaurant-status">
                                    <em class="ribbon"></em>{{__('Open')}}
                                </span>
                            @endif
                            @if ($restaurant->status == 0)
                                <span class="restaurant-status closed">
                                    <em class="ribbon"></em>{{__('Closed')}}
                                </span>
                            @endif
                            <a href="{{ route('restaurant_details', $restaurant->id) }}">
                                <div class="restaurant-image"
                                    style="background-image: url({{ asset('storage/app/public/restaurant/cover/' . $restaurant->cover_photo) }});
                                           background-size: cover;height: 150px;">
                            </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('restaurant_details', $restaurant->id) }}">
                            {{ $restaurant->name }}
                            </a>
                        </h5>
                        {{-- <div class="cuisines">
                            <span>{{ $restaurant->zone->id }}</span>
                        </div> --}}
                        <p class="location"><i class="bx bx-location-plus"></i>
                            {{ $restaurant->address }}
                        </p>
                        <div class="details">
                            <span class="badge bg-red-500 text-white p-2"><i class='bx bxs-star text-yellow-300'></i> 4.2</span>
                            {{-- @if (empty($restaurant->rating))
                                <span class="badge"><i class='bx bxs-star'></i> {{ $restaurant->rating }}</span>
                            @endif --}}
                            <span class="badge">{{ $restaurant->delivery_time }}</span>
                            <span class="badge">{{ $restaurant->opening_time->format('h:m') }} /
                                {{ $restaurant->closeing_time->format('h:m') }}</span>
                        </div>
                    </div>
                    </a>
            </div>
        @empty
            {{__('No restaurant')}}
            @endforelse
        </div>
    </section>

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr.css') }}">
@endpush

@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&v=3.45.8">
    </script>
    <script>
          function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation ?
                    "Error: The Geolocation service failed." :
                    "Error: Your browser doesn't support geolocation."
                );
            }

            $('.btn-locate').click(function(e){
                e.preventDefault();

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position){
                        console.log( "Latitude: " + position.coords.latitude +   " - Longitude: " + position.coords.longitude );
                    });
                } else {
                    console.log( "Geolocation is not supported by this browser.");
                }
            }).trigger('click');
    </script>
@endpush
</x-app-layout>

