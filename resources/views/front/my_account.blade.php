<x-app-layout>

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('My Account') }}</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
            <div class="row">
                @include('partials.sidebar')

                {{-- @livewire('front.account', [$customer]) --}}
                
                <div class="col-lg-9">
                    <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        <div class="my-account-content">
                            <h4>{{ __('Account Details') }}</h4>
                            <form method="post" action="{{ route('profile_update', $customer->id) }}">
                                @csrf
                                @method('PATCH')

                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="f_name"
                                                placeholder="{{ __('First Name') }}" value="{{ $customer['f_name'] }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="l_name"
                                                placeholder="{{ __('Last Name') }}" value="{{ $customer['l_name'] }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email"
                                                placeholder="{{ __('Email') }}" value="{{ $customer['email'] }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mobile"
                                                placeholder="{{ __('Mobile') }}" value="{{ $customer['phone'] }}">
                                        </div>
                                        <div class="form-group  mb-0">
                                            <button class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Save Changes') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                @yield('order_history')
                @yield('change_password')
                @yield('address')


                
            </div>
        </div>
    </section>

</x-app-layout>