<div>
    @if($location)
        <livewire:web.search :lat="$lat" :lng="$lng" :location="$location" :sortFilter="$sortFilter"/>
    @else
        <div class="mt-40 w-full m-auto text-center">
            <i class="fal fa-lg fa-spinner fa-spin text-6xl font-bold text-fa-blue-700"></i>
        </div>
    @endif
</div>


@push('scripts')
    <script>
          document.addEventListener('livewire:load', function () {
            getLocation();
        });

        function getLocation() {
        navigator.geolocation.getCurrentPosition(onSuccess, onError);
    }
    function onError() {
        window.axios.get('https://api.ipstack.com/check?access_key=YOUR_API_KEY')
        .then(function(response) {
            @this.lat = response.data.latitude;
            @this.lng = response.data.longitude;
            @this.location = response.data.city + ', ' + response.data.region_name;
        });
    }
    function onSuccess(position) {
        const {
            latitude,
            longitude
        } = position.coords;

        @this.lat = latitude;
        @this.lng = longitude;

        window.axios.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&sensor=false&key=YOUR_API_KEY')
            .then(function(response) {
                if(response.data.results[0]) {
                    @this.data = response.data.results[0];
                } else {
                    onError();
                }
            })
    }


    </script>
@endpush