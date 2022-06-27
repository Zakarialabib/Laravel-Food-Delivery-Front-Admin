<x-app-layout>
    @section('title', __('Deliveryman registration'))

    <!-- Page Header -->
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0"> {{ __('Deliveryman application') }}</h3>

        </div>
    </div>
    <!-- End Page Header -->
    <div class="container">
        <div class="row py-6 gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{ route('deliveryman.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{ __('First name') }}</label>
                                <input type="text" name="f_name" class="form-control"
                                    placeholder="{{ __('First name') }}" required
                                    value="{{ old('f_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{ __('Last name') }}</label>
                                <input type="text" name="l_name" class="form-control"
                                    placeholder="{{ __('Last name') }}"
                                    value="{{ old('l_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('email') }}</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Ex : ex@example.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('Deliveryman type') }}</label>
                                <select name="earning" class="form-control">
                                    <option value="1">{{ __('Freelancer') }}</option>
                                    <option value="0">{{ __('Salary based') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('Zone') }}</label>
                                <select name="zone_id" class="form-control" required
                                    data-placeholder="{{ __('Select zone') }}">
                                    <option value="" readonly="true" hidden="true">{{ __('Select zone') }}</option>
                                    @foreach (\App\Models\Zone::all() as $zone)
                                        @if (isset(auth('admin')->user()->zone_id))
                                            @if (auth('admin')->user()->zone_id == $zone->id)
                                                <option value="{{ $zone->id }}" selected>{{ $zone->name }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('Identity type') }}</label>
                                <select name="identity_type" class="form-control">
                                    <option value="passport">{{ __('passport') }}</option>
                                    <option value="driving_license">{{ __('Driving license') }}</option>
                                    <option value="nid">{{ __('nid') }}</option>
                                    <option value="restaurant_id">{{ __('Restaurant id') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('Identity number') }}</label>
                                <input type="text" name="identity_number" class="form-control"
                                    value="{{ old('identity_number') }}" placeholder="Ex : DH-23434" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('Identity image') }}</label>
                                <div>
                                    <div class="row" id="coba"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="phone">{{ __('phone') }}</label>
                                <div class="input-group">
                                        <x-tel-input
                                        id="phone"
                                        name="phone"
                                        placeholder="{{__('Ex : 017********')}}"
                                        value="{{ old('tel') }}"
                                        required
                                        class="form-control"
                                        />                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ __('password') }}</label>
                                <input type="text" name="password" class="form-control" placeholder="Ex : password"
                                    value="{{ old('password') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>{{ __('deliveryman') }} {{ __('image') }}</label><small
                                    style="color: red">* ( {{ __('ratio') }} 1:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                    <label class="custom-file-label" for="customFileEg1">{{ __('choose') }}
                                        {{ __('file') }}</label>
                                </div>

                                <center class="pt-4">
                                    <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                        src="{{ asset('public/assets/admin/img/400x400/img2.jpg') }}"
                                        alt="delivery-man image" />
                                </center>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{ __('submit') }}</button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
        @php($country = \App\Models\BusinessSetting::where('key', 'country')->first())
        
    </script>

    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/admin/img/400x400/img2.jpg') }}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error('{{ __('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ __('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
