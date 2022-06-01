<div class="col-lg-9">
    <!-- Validation Errors -->
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form wire:submit.prevent="submit" class="pt-3">
       
        <div class="flex flex-wrap">
            <div class="lg:w-1/3 sm:w-1/2 px-2 mt-5 {{ $errors->has('f_name') ? 'is-invalid' : '' }}">
                <label class="form-label" for="f_name">{{ __('Full name') }}</label>
                <input
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    type="text" name="f_name" id="f_name" wire:model="account.f_name">
                <x-input-error for="f_name" />
            </div>
            <div class="lg:w-1/3 sm:w-1/2 px-2 mt-5 {{ $errors->has('l_name') ? 'is-invalid' : '' }}">
                <label class="form-label" for="l_name">{{ __('Full name') }}</label>
                <input
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    type="text" name="l_name" id="l_name" wire:model="account.l_name">
                <x-input-error for="l_name" />
            </div>
            <div class="lg:w-1/3 sm:w-1/2 px-2 mt-5 {{ $errors->has('email') ? 'is-invalid' : '' }}">
                <label class="form-label" for="email">{{ __('Email') }}</label>
                <input
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    type="email" name="email" id="email" disabled wire:model="account.email">
                <x-input-error for="email" />
            </div>
            <div class="lg:w-1/3 sm:w-1/2 px-2 mt-5 {{ $errors->has('mobile') ? 'is-invalid' : '' }}">
                <label class="form-label" for="mobile">{{ __('Phone') }}</label>
                <input
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    type="number" name="mobile" id="mobile" wire:model="account.mobile">
                <x-input-error for="mobile" />
            </div>
        </div>

        <div class="w-full mt-5 px-2 {{ $errors->has('address') ? 'is-invalid' : '' }}">
            <label class="form-label" for="address">{{ __('Address') }}</label>
            <input
                class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                type="text" name="address" id="address" wire:model="account.address">
            <x-input-error for="address" />
        </div>
        <div class="w-full mt-5 px-2 {{ $errors->has('password') ? 'is-invalid' : '' }}">
            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input
                class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                type="password" name="password" id="password" wire:model="password">
            <x-input-error for="password" />
        </div>
        <div class="mt-5">
            <button
                class="leading-4 md:text-sm sm:text-xs bg-blue-900 text-white hover:text-blue-800 hover:bg-blue-100 active:bg-blue-200 focus:ring-blue-300 font-medium uppercase px-6 py-2 rounded-md shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="submit">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>
