<x-app-layout>
    <!-- Banner -->
    <div class="w-full">
        <h1 class="text-2xl leading-5 font-bold text-center py-6 ">{{__('Restaurants in map')}}</h1>
        <div id="map" class="border border-t border-gray-500" style="height:180px; width:100%"></div>
    </div>

    <section class="pb-60">
        <div class="container">
            <div class="flex flex-row">
                <div class="lg:w-1/10 sm:w-full px-4">
                    {{-- @if (app('request')->has('location')) --}}
                    <h4 class="my-4">{{ __('Restaurants') }}</h4>
                    <div class="flex flex-wrap">
                        @forelse ($restaurants as $rest)
                            @if ($rest->status == 1)
                                <div class="col-md-4 col-sm-6">

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
                                        <div class="restaurant-image" style="background-image: url({{ asset('storage/app/public/restaurant/cover/' . $rest->cover_photo) }});
                                    background-size: cover;height: 120px;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $rest->name }}</h5>
                                            <p class="location"><i class="bx bx-location-plus"></i>
                                                {{ $rest->address }}</p>
                                            <div class="details">
                                                <span class="badge p-2"><i class='bx bxs-star text-yellow-300'></i>
                                                    4.2</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="col-lg-4 col-sm-6">

                                    <a href="{{ route('restaurant_details', $rest->id) }}"
                                        class="card restaurant-card unavailable">
                                        <span class="restaurant-status">
                                            @if ($rest->status == 1)
                                                <em class="ribbon"></em>Open
                                            @endif
                                        </span>
                                        @if ($rest->status == 0)
                                            <span class="restaurant-status closed">
                                                <em class="ribbon"></em>Closed
                                            </span>
                                        @endif
                                        <div class="restaurant-image" style="
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
                                <h4 class="mb-4">Sorry! We couldn't find any results</h4>
                            </div>
                        @endforelse
                    </div>
                    {{-- @endif --}}
                    <div class="pt-3">
                        {{ $restaurants->links('layouts.tailwind') }}
                    </div>
                </div>
                <div class="lg:w-1/2 sm:w-full px-4 mt-4 cart-col">
                    <div class="my-2 px-4 flex sm:flex-row flex-col">
                        <div class="mb-1 sm:mb-0">
                            <div class="relative py-2">
                                <p class="mt-2 text-sm leading-normal">{{__('Results per page')}}</p>
                                <x-select 
                                    class="appearance-none h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </x-select>
                            </div>
                            <div class="relative">
                                <p class="mt-2 text-sm leading-normal">{{__('Order by name')}}</p>
                                <x-select 
                                    class="appearance-none h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="asc">{{ __('ASC') }}</option>
                                    <option value="desc">{{ __('DESC') }}</option>
                                </x-select>
                            </div>
                            <div class="relative">
                                <p class="mt-2 text-sm leading-normal">{{__('Order by filters')}}</p>
                                <x-select 
                                    class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                    <option value="price">{{ __('Price') }}</option>
                                    <option value="status">{{ __('Status') }}</option>
                                    <option value="created_at">{{ __('Created at') }}</option>
                                    <option value="updated_at">{{ __('Updated at') }}</option>
                                </x-select>
                            </div>
                
                            <div class="block relative">
                                <p class="mt-2 text-sm leading-normal">{{__('Search')}}</p>
                                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                        <path
                                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                                        </path>
                                    </svg>
                                </span>
                                <input id="search" type="text"
                                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
                                    autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="container my-4 px-4 flex flex-wrap">
                        @foreach ($categories as $category)
                            <div class="my-2 mx-2">
                                <a class="leading-2 text-sm bg-red-500 hover:bg-white text-white hover:text-red-500 py-2 px-2 rounded" href="#sub-cat2">
                                    {{ $category['name'] }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @push('scripts')
        <script type="text/javascript">
            function locationPopup() {

                document.getElementById('location').focus();

                document.getElementById('location-popup').style.display = "none";

            }
        </script>
   
{{-- <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8" ></script>
<script>
    const myLatLng = { lat: {{$restaurant->latitude}}, lng: {{$restaurant->longitude}} };
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
            title: "{{$restaurant->name}}",
        });
    }
</script> --}}
@endpush
</x-app-layout>
