@component('mail::message')
    {{ __('Your Order has been placed') }}.<br>
    <strong>{{ __('Order id') }} : {{ $id }}</strong>.<br>
    {{ __('We will contact you soon') }}.<br>

@component('mail::button', ['url' => '/orderhistory'])
        {{__('View Order')}}
@endcomponent

{{__('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent
