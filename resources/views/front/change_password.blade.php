<x-app-layout>
    @section('title', __('Change Password'))
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">{{ __('Change Password') }}</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">

            <div class="row">
                @include('partials.sidebar')
                <div class="col-lg-9">
                    <div class="tab-pane fade show " id="v-pills-password" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        <div class="my-account-content">
                            <form action="{{ route('change_password') }}" method="post" class="needs-validation"
                                novalidate enctype="multipart">
                                @csrf
                                @if (Session::get('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif


                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="current_password"
                                                placeholder="Current Password">
                                            @if ($errors->has('current_password'))
                                                <span class="help-block" style="color:red">
                                                    {{ $errors->first('current_password') }}
                                                </span>
                                            @endif

                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="new_password"
                                                placeholder="New Password">
                                            @if ($errors->has('new_password'))
                                                <span class="help-block" style="color:red">
                                                    {{ $errors->first('new_password') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="new_confirm_password"
                                                placeholder="Confirm New Password">
                                            @if ($errors->has('new_confirm_password'))
                                                <span class="help-block" style="color:red">
                                                    {{ $errors->first('new_confirm_password') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group  mb-0">
                                            <button class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{__('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
