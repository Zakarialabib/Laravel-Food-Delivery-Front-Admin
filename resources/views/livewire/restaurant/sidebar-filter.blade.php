<div>
    <div class="flex justify-between mb-4 min-w-full w-full px-2 py-2 mx-auto cursor-pointer lg:cursor-text text-xl my-1 font-light">
        <h2 class="flex capitalize">
            <x-icons.just-eat.cuisine-svg class="h-6 w-6 mr-2"/>
            {{ $group }}
        </h2>
        <button
            id="{{ $group }}[]"
            type="button"
            wire:click="$set('query', [])"
            class="hidden ml-2 lg:block text-base text-blue-500 font-bold"
        > Reset
        </button>
    </div>
    <div class="hidden lg:block">
        @forelse ($collection as $item)
            <div
                wire:key="{{ $item->id }}"
                class="{{ $loop->iteration > 8 && !$this->isChecked($item->value) && $showMore == false ? ' hidden' : '' }} my-2 bg-light-primary dark:bg-dark-secondary dark:hover:text-dark-important dark:text-light-secondary rounded-lg">
                <label class="relative flex items-end p-2 capitalize">
                    <input
                        class="form-tick appearance-none h-6 w-6 mr-2 border border-gray-300 rounded-md checked:bg-light-important dark:bg-light-primary dark:checked:bg-dark-important dark:checked:border-transparent focus:outline-none"
                        type="checkbox"
                        name="{{ $item->group }}[]"
                        value="{{ $item->value }}"
                        wire:model="query"
                        {{ $this->isChecked($item->value) ? 'checked' : '' }}
                    />
                    {{ $item->description }}
                </label>
            </div>
            @if ($loop->iteration > 8 && $loop->last)
                <div x-data="{ open: false }" class="flex px-2 py-2">
                    <button
                        name="expand-button"
                        type="button"
                        @click="open = !open"
                        x-text="open ? 'View less' : 'View more'"
                        wire:click="expand"
                    ></button>
                    <span x-bind:class="open ? 'rotate-180' : ''" class="transform px-2 py-2"><x-icons.chevron-down-outline-svg class="h-4 w-4"/></span>
                </div>
            @endif
        @empty
            <p>No data</p>
        @endforelse
    </div>
</div>

@push('styles')
    <style>
        .form-tick:checked {
            background-image: url("{{ asset('storage/check-solid.svg') }}");
            border-color: transparent;
            background-size: 100% 100%;
            background-position: 50%;
            background-repeat: no-repeat
        }
    </style>
@endpush