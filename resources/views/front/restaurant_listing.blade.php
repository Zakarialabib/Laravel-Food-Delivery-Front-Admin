<x-app-layout>
    <!-- Banner -->

    <section class="py-60">
        <div class="container">
            {{-- @if (app('request')->has('location')) --}}
            <h4 class="mb-4">Restaurants</h4>
            <div class="row rest-listing-row">
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
                                    background-size: cover;height: 150px;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rest->name }}</h5>
                                    <p class="location"><i class="bx bx-location-plus"></i> {{ $rest->address }}
                                    </p>
                                    <div class="details">
                                        <span class="badge p-2"><i class='bx bxs-star text-yellow-300'></i> 4.2</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-md-4 col-sm-6">

                            <a href="{{ route('customer.restaurant_details', $rest->id) }}"
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
                                    <p class="location"><i class="bx bx-location-plus"></i> {{ $rest->address }}
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
            {{ $restaurants->links() }}
        </div>
    </section>
</x-app-layout>
@push('scripts')
    <script type="text/javascript">
        function locationPopup() {

            document.getElementById('location').focus();

            document.getElementById('location-popup').style.display = "none";

        }
    </script>
@endpush

