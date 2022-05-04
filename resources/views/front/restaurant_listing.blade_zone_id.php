<x-app-layout>
    
    
    @livewire('restaurant-list', ['postcode' => $postcode])



    @push('scripts')
    <script>
        function onSubmit() {
            document.getElementById('restaurant-query-filter').submit();
        }
    </script>
    @endpush

</x-app-layout>

