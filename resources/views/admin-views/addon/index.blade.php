@extends('layouts.admin.app')

@section('title',__('Add new addon'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('Addon')}}</h1>
                </div>
                @if(isset($addon))
                <a href="{{route('admin.addon.add-new')}}" class="btn btn-primary pull-right"><i class="tio-add-circle"></i> {{__('Add new addon')}}</a>
                @endif
            </div>
        </div>
        <!-- End Page Header -->
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($default_lang = 'en')
        <div class="card">
            <div class="card-header"> <h5>{{__('Add').' '.__('New addon')}}</h5></div>
            <div class="card-body">
                <form action="{{isset($addon)?route('admin.addon.update',[$addon['id']]):route('admin.addon.store')}}" method="post">
                    @csrf
                    @if($language)
                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs mb-4">
                            @foreach(json_decode($language) as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="row">
                        <div class="col-12">
                        @if ($language)
                            @foreach(json_decode($language) as $lang)
                                <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <label class="input-label" for="exampleFormControlInput1">{{__('Name')}} ({{strtoupper($lang)}})</label>
                                    <input type="text" name="name[]" class="form-control" placeholder="{{__('New addon')}}" maxlength="191" {{$lang == $default_lang? 'required':''}} oninvalid="document.getElementById('en-link').click()">
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}">
                            @endforeach
                        @else
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{__('New addon')}}" value="{{old('name')}}" required maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="{{$lang}}">
                        @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1">{{__('Restaurant')}}<span
                                        class="input-label-secondary"></span></label>
                                <select name="restaurant_id" id="restaurant_id" class="js-data-example-ajax form-control"  data-placeholder="{{__('Select restaurant')}}" oninvalid="this.setCustomValidity('{{__('Please select restaurant')}}')">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Price')}}</label>
                                <input type="number" min="0" max="999999999999.99" name="price" step="0.01" value="{{old('price')}}" class="form-control" placeholder="100" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{isset($addon)?__('Update'):__('Add')}}</button>
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="card mt-1">
            <div class="card-header">
                <h5 class="card-header-title"> {{__('Addon list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$addons->total()}}</span></h5>
                <div class="col-sm-auto" style="width: 306px;">
                    <select name="restaurant_id" id="restaurant" onchange="set_restaurant_filter('{{route('admin.addon.add-new')}}',this.value)" data-placeholder="{{__('Select restaurant')}}" class="js-data-example-ajax form-control"   title="Select Restaurant">
                    @if(isset($restaurant))    
                    <option value="{{$restaurant->id}}" selected>{{$restaurant->name}}</option>
                    @else
                    <option value="all" selected>{{__('All restaurants')}}</option>
                    @endif
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between align-items-center flex-grow-1 mb-1">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <form id="search-form">
                            @csrf
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" name="search" class="form-control" placeholder="{{__('Search addons')}}" aria-label="Search addons">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-auto">
                        <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                            data-hs-unfold-options='{
                            "target": "#showHideDropdown",
                            "type": "css-animation"
                            }'>
                            <i class="tio-table mr-1"></i> {{__('Columns')}} <span class="badge badge-soft-dark rounded-circle ml-1">5</span>
                        </a>

                        <div id="showHideDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card" style="width: 15rem;">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">#</span>
                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_index">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_index" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    <!-- End Checkbox Switch -->
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">{{__('Name')}}</span>
                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_name">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_name" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    <!-- End Checkbox Switch -->
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">{{__('Price')}}</span>
                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_price">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_price" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <!-- End Checkbox Switch -->
                                    </div>


                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">{{__('Restaurant')}}</span>

                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_vendor">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_vendor" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <!-- End Checkbox Switch -->
                                    </div>

                                
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">{{__('Status')}}</span>

                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_status">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_status" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <!-- End Checkbox Switch -->
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="mr-2">{{__('Action')}}</span>

                                        <!-- Checkbox Switch -->
                                        <label class="toggle-switch toggle-switch-sm" for="toggleColumn_action">
                                            <input type="checkbox" class="toggle-switch-input" id="toggleColumn_action" checked>
                                            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <!-- End Checkbox Switch -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- End Unfold -->
                    </div>
                </div>
                <div class="table-responsive datatable-custom">
                    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"  data-hs-datatables-options='{
                        "search": "#datatableSearch",
                        "entries": "#datatableEntries",
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false
                            }'>
                        <thead class="thead-light">
                        <tr>
                            <th>{{__('#')}}</th>
                            <th style="width: 20%">{{__('Name')}}</th>
                            <th style="width: 20%">{{__('Price')}}</th>
                            <th style="width: 30%">{{__('Restaurant')}}</th>
                            <th style="width: 10%">{{__('Status')}}</th>
                            <th style="width: 10%">{{__('Action')}}</th>
                        </tr>
                        </thead>

                        <tbody id="set-rows">
                        @foreach($addons as $key=>$addon)
                            <tr>
                                <td>{{$key+ $addons->firstItem()}}</td>
                                <td>
                                <span class="d-block font-size-sm text-body">
                                    {{Str::limit($addon['name'],20,'...')}}
                                </span>
                                </td>
                                <td>{{\App\CentralLogics\Helpers::format_currency($addon['price'])}}</td>
                                <td>{{Str::limit($addon->restaurant?$addon->restaurant->name:__('Restaurant').' '.__('Deleted'),25,'...')}}</td>
                                <td>    
                                    <label class="toggle-switch toggle-switch-sm" for="stausCheckbox{{$addon->id}}">
                                    <input type="checkbox" onclick="location.href='{{route('admin.addon.status',[$addon['id'],$addon->status?0:1])}}'"class="toggle-switch-input" id="stausCheckbox{{$addon->id}}" {{$addon->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-white"
                                        href="{{route('admin.addon.edit',[$addon['id']])}}" title="{{__('Edit addon')}}"><i class="tio-edit"></i></a>
                                    <a class="btn btn-sm btn-white"     href="javascript:"
                                        onclick="form_alert('addon-{{$addon['id']}}','Want to delete this addon ?')" title="{{__('Delete addon')}}"><i class="tio-delete-outlined"></i></a>
                                    <form action="{{route('admin.addon.delete',[$addon['id']])}}"
                                                method="post" id="addon-{{$addon['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center page-area"> 
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            {!! $addons->links() !!}
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
            select: {
                style: 'multi',
                classMap: {
                checkAll: '#datatableCheckAll',
                counter: '#datatableCounter',
                counterInfo: '#datatableCounterInfo'
                }
          },
          language: {
            zeroRecords: '<div class="text-center p-4">' +
                '<img class="mb-3" src="{{asset('public/assets/admin/svg/illustrations/sorry.svg')}}" alt="Image Description" style="width: 7rem;">' +
                '<p class="mb-0">No data to show</p>' +
                '</div>'
          }
        });

        $('#datatableSearch').on('mouseup', function (e) {
          var $input = $(this),
            oldValue = $input.val();

          if (oldValue == "") return;

          setTimeout(function(){
            var newValue = $input.val();

            if (newValue == ""){
              // Gotcha
              datatable.search('').draw();
            }
          }, 1);
        });

        $('#toggleColumn_index').change(function (e) {
          datatable.columns(0).visible(e.target.checked)
        })
        $('#toggleColumn_name').change(function (e) {
          datatable.columns(1).visible(e.target.checked)
        })

        $('#toggleColumn_vendor').change(function (e) {
          datatable.columns(3).visible(e.target.checked)
        })

        $('#toggleColumn_status').change(function (e) {
          datatable.columns(4).visible(e.target.checked)
        })
        $('#toggleColumn_price').change(function (e) {
          datatable.columns(2).visible(e.target.checked)
        })
        $('#toggleColumn_action').change(function (e) {
          datatable.columns(5).visible(e.target.checked)
        })


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#restaurant').select2({
            ajax: {
                url: '{{url('/')}}/admin/vendor/get-restaurants',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#restaurant_id').select2({
            ajax: {
                url: '{{url('/')}}/admin/vendor/get-restaurants',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });


        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.addon.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
@endpush
