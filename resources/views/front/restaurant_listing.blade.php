<x-app-layout>
    @section('title', __('Restaurant listing'))

    <!-- Banner -->
    <div class="w-full bg-gray-100 py-10">
        <h3 class="text-3xl leading-5 text-center ">{{ __('Restaurants in map') }}</h3>
        <div id="map" class="border border-t border-gray-500" style="height:180px; width:100%"></div>
        <div id="mapos"></div>
    </div>

    <section class="py-60">
        <div class="container">
            <div class="row cuisine-dish-wrap">
                <div class="col-lg-12 cuisine-col">
                    <div class="card-header d-flex flex-wrap justify-content-between">
                        <form id="search-form" class="header-item w-full">
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
                    </div>
                    <h4 class="my-4">{{ __('Restaurants') }}</h4>

                    <div class="flex flex-wrap">
                        @forelse ($restaurants as $rest)
                            <script type="text/javascript">
                                addMarker({{ $rest->latitude }}, {{ $rest->longitude }});
                            </script>
                            @if ($rest->status == 1)
                                <div class="xl:w-1/3 px-4 lg:w-1/2 sm:w-full">

                                    <a href="{{ route('restaurant_details', $rest->id) }}"
                                        class="card restaurant-card available">
                                        <span class="restaurant-status">
                                            @if ($rest->status == 1)
                                                <em class="ribbon"></em>{{ __('Open') }}
                                            @endif
                                        </span>
                                        @if ($rest->status == 0)
                                            <span class="restaurant-status closed">
                                                <em class="ribbon"></em>{{ _('Closed') }}
                                        @endif
                                        </span>
                                        <div class="restaurant-image"
                                            style="background-image: url({{ asset('storage/app/public/restaurant/cover/' . $rest->cover_photo) }});
                                    background-size: cover;height: 120px;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $rest->name }}</h5>
                                            <p class="location"><i class="bx bx-location-plus"></i>
                                                {{ $rest->address }}</p>
                                            <div class="details">
                                                <span class="badge bg-red-500 text-white p-2"><i
                                                        class='bx bxs-star text-yellow-300'></i> 4.2</span>
                                                {{-- @if (empty($rest->rating))
                                                        <span class="badge"><i class='bx bxs-star'></i> {{ $rest->rating }}</span>
                                                    @endif --}}
                                                <span class="badge">{{ $rest->delivery_time }}</span>
                                                <span class="badge">{{ $rest->opening_time->format('h:m') }}
                                                    /
                                                    {{ $rest->closeing_time->format('h:m') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="lg:w-1/3 md:w-1/3 sm:w-1/2 px-4">

                                    <a href="{{ route('restaurant_details', $rest->id) }}"
                                        class="card restaurant-card unavailable">
                                        <span class="restaurant-status">
                                            @if ($rest->status == 1)
                                                <em class="ribbon"></em>{{ __('Open') }}
                                            @endif
                                        </span>
                                        @if ($rest->status == 0)
                                            <span class="restaurant-status closed">
                                                <em class="ribbon"></em>{{ __('Closed') }}
                                            </span>
                                        @endif
                                        <div class="restaurant-image"
                                            style="
                                                        background-image: url('{{ $rest->cover_photo }}');
                                                      ">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $rest->name }}</h5>
                                            <p class="location"><i class="bx bx-location-plus"></i>
                                                {{ $rest->address }}
                                            </p>
                                            <div class="details">
                                                <span class="badge"><i class='bx bxs-star'></i> 4.2</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @empty
                            <div class="empty-status-div">
                                <h4 class="mb-4">{{ __("Sorry! We couldn't find any results") }}</h4>
                            </div>
                        @endforelse
                    </div>
                    <div class="pt-3">
                        {{ $restaurants->links('layouts.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}">
        </script>
        <script type="text/javascript">
            function locationPopup() {

                document.getElementById('location').focus();

                document.getElementById('location-popup').style.display = "none";

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
       
            let map = null;

            function initMap(center) {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 4,
                    center: center,
                });
            }

            function addMarker($lat, $lng) {

                if (map == null)
                    initMap({
                        lat: $lat,
                        lng: $lng
                    });

                new google.maps.Marker({
                    position: {
                        lat: $lat,
                        lng: $lng
                    },
                    map,
                    title: "",
                });
            }
        </script>
    @endpush
</x-app-layout>
