@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm p-3 leading-5 bg-white dark:bg-dark-eval-2 text-zinc-700 dark:text-zinc-300 border border-zinc-300 mb-1 text-sm w-full focus:shadow-outline-red focus:border-red-500']) !!}>
