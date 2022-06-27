@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-red-600']) }}>
        {{ $status }}
    </div>
@endif
