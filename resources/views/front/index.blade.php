<x-app-layout>
    <!-- Banner -->
    @php($landing_page_text = \App\Models\BusinessSetting::where(['key'=>'landing_page_text'])->first())
    @php($landing_page_text = isset($landing_page_text->value)?json_decode($landing_page_text->value, true):null)
    
    <div class="home-banner d-flex align-items-center">
        <div class="container">
            <div class="banner-content">
                <h1 class="text-center text-5xl py-2" >
                    {{isset($landing_page_text)?$landing_page_text['header_title_1']:''}}
                </h1>
                <h5
                    class="text-center py-2">
                    {{isset($landing_page_text)?$landing_page_text['header_title_2']:''}}
                </h5>
                <h4 class="text-center py-2">
                    {{isset($landing_page_text)?$landing_page_text['header_title_3']:''}}
                </h4>
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group search-location-group">
                        <input type="text" class="form-control" name="location" placeholder="Enter your delivery location"
                            aria-label="delivery location" aria-describedby="button-addon2">
                        <a href="" class="btn-locate"><i class='bx bx-target-lock'></i> {{__('Locate Me')}}</a>
                        <div class="input-group-append btn-find-food">
                            <button class="btn btn-danger" type="submit">{{__('Find Food')}}</button>
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
            <h4 class="mb-4">{{__('Popular Restaurants')}}</h4>
            <div class="row rest-listing-row -mx-5">
                @forelse ($restaurants as $restaurant)
                    <div class="lg:w-1/3 sm:w-full px-4 rounded-2xl shadow-xl shadow-slate-300/60">
                        <a class="card restaurant-card">
                            @if ($restaurant->status == 1)
                                <span class="restaurant-status">
                                    <em class="ribbon"></em>Open
                                </span>
                            @endif
                            @if ($restaurant->status == 0)
                                <span class="restaurant-status closed">
                                    <em class="ribbon"></em>Closed
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
                        <div class="cuisines">
                            <span>{{ $restaurant->zone->id }}</span>
                        </div>
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
        </div>
    </section>
</x-app-layout>

@push('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/toastr.css">
@endpush

@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&v=3.45.8">
    </script>
@endpush
