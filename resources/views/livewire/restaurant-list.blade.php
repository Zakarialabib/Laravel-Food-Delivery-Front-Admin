<div class="bg-light-secondary dark:bg-dark-primary p-4">
    {{--    {{ dd($restaurants[0]->openinghours->where('dayOfWeek', today()->dayOfWeek)->first()) }}--}}
        <div class="container px-4 sm:px-8 mb-8 mx-auto">
            <div class="flex items-baseline mb-4">
                {{--TODO implement dynamic heading--}}
                <h2 class="text-2xl ">{{ $restaurants->count() }} restaurants in {{ $postcode }} Odense V</h2>
                <a href="{{ '/' }}" class="ml-4 text-blue-500 font-bold">Change location</a>
            </div>
            <div class="flex-none lg:flex">
                <div>
                    <div class="flex flex-row lg:flex-col justify-around w-full">
                        @livewire('restaurant.sidebar')
                    </div>
                </div>
                <div class="lg:ml-6 w-full">
                    <h2 class="py-3 mb-4 text-lg text-center bg-light-third dark:bg-dark-secondary rounded">01 Restaurants
                        opens later</h2>
                    <div class="w-full px-4 bg-light-third dark:bg-dark-secondary rounded">
                        <div class="flex-col divide-y divide-gray-600">
                            @forelse($this->restaurants as $key => $restaurant)
                                <div class="py-4">
                                    <a class="hover:bg-blue-400" href="/restaurants-{{ $restaurant->name }}">
                                        <div class="flex flex-col sm:flex-row h-full w-full">
                                            <div class="relative h-32 sm:w-52 sm:mr-12 mb-6 sm:mb-0">
                                                <div class="h-full w-full bg-cover bg-no-repeat bg-center"
                                                     style="background-image: url({{ asset('/storage/15888.jpg') }})"></div>
                                                <img
                                                    class="absolute h-16 w-16 bottom-0 right-0 sm:bottom-auto sm:inset-y-1/4 content-center -mb-8 mr-8 sm:-mb-0 sm:-mr-8 border-4 border-light-third dark:border-dark-secondary"
                                                    src="{{ asset('storage/crispy-house-pizza.gif') }}"
                                                    alt="{{ $restaurant->name }}"/>
                                            </div>
                                            <div
                                                class="flex flex-col sm:flex-row w-full h-full justify-between sm:divide-x divide-gray-600">
                                                <div class="w-full text-left my-auto">
                                                    <h2 class="pb-1 font-bold">{{ $restaurant->name }}</h2>
                                                    <div class="flex items-center pb-1">
                                                        @for($i = 0; $i < 5; $i++)
                                                            {{-- <x-icons.star-solid-svg class="h-4 w-4 {{ $i <= round($restaurant->reviews->avg('avg_review')) ? 'text-light-important dark:text-dark-important' : 'text-gray-400'}}"></x-icons.star-solid-svg> --}}
                                                        @endfor
                                                        <span class="ml-2 text-xs">({{ $restaurant->reviews_count }})</span>
                                                    </div>
                                                    <p class="text-sm font-bold capitalize">{{ $restaurant->categoryfilters->where('group', 'cuisines')->pluck('value')->implode(', ') }}</p>
                                                </div>
                                                <div class="w-full h-full sm:pl-2">
                                                    <div
                                                        class="flex flex-col justify-between h-32 text-left my-auto text-sm">
                                                        <div class="flex items-center mt-6">
                                                            {{--@if(empty($restaurant->details->take_away))
                                                                <x-icons.just-eat.self-pickup-svg class="h-6 w-6"></x-icons.just-eat.self-pickup-svg>
                                                                <p class="ml-2">Only self pickup</p>
                                                            @else
                                                                <x-icons.just-eat.money-svg class="h-6 w-6"></x-icons.just-eat.money-svg>
                                                                 TODO shorten this statement
                                                                <p class="ml-2">
                                                                    Delivery {{ !empty($restaurant->details->take_away->deliver_fee) ? $restaurant->details->take_away->deliver_fee . ' ' . $restaurant->details->take_away->currency_sign . '.' : 'FREE' }}
                                                                    - {{ !empty($restaurant->details->take_away->min_order) ? 'Min. order ' . $restaurant->details->take_away->min_order . ' ' . $restaurant->details->take_away->currency_sign : 'No min. order' }}
                                                                </p>
                                                            @endif--}}
                                                        </div>
                                                        <div>
                                                            <p>Opening hours:</p>
                                                            <p>{{ $restaurant->openinghours->where('dayOfWeek', today()->dayOfWeek)->first()->dayOfWeekOpeningHours }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-2xl text-center">No results</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div