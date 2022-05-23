@extends('layouts.admin.app')

@section('title','Food List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"> {{__('Food list')}}<span class="badge badge-soft-dark ml-2" id="foodCount">{{$foods->total()}}</span></h1>
                </div>
                @if ($toggle_veg_non_veg)
                <!-- Veg/NonVeg filter -->
                <div class="col-sm-auto mb-1 mb-sm-0">
                    <select name="category_id" onchange="set_filter('{{url()->full()}}',this.value, 'type')" data-placeholder="{{__('All')}}" class="form-control">
                        <option value="all" {{$type=='all'?'selected':''}}>{{__('All')}}</option>
                        <option value="veg" {{$type=='veg'?'selected':''}}>{{__('Veg')}}</option>
                        <option value="non_veg" {{$type=='non_veg'?'selected':''}}>{{__('Non veg')}}</option>
                    </select>
                </div>
                <!-- End Veg/NonVeg filter -->
                @endif
                <div class="col-sm-auto" style="min-width: 306px;">
                    <select name="restaurant_id" id="restaurant" onchange="set_restaurant_filter('{{url()->full()}}',this.value)" data-placeholder="{{__('Select restaurant')}}" class="js-data-example-ajax form-control" onchange="getRestaurantData('{{url('/')}}/admin/vendor/get-addons?data[]=0&restaurant_id=',this.value,'add_on')" required title="Select Restaurant" oninvalid="this.setCustomValidity('{{__('please_select_restaurant')}}')">
                    @if($restaurant)    
                    <option value="{{$restaurant->id}}" selected>{{$restaurant->name}}</option>
                    @else
                    <option value="all" selected>{{__('All restaurants')}}</option>
                    @endif
                    </select>
                </div>
            </div>
            
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header p-1">
                        <div class="row justify-content-between align-items-center flex-grow-1">
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
                                        <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="{{__('Search here')}}" aria-label="{{__('Search here')}}">
                                        <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>

                            <div class="col-auto">
                                <!-- Unfold -->
                                <div class="hs-unfold mr-2" style="width: 306px;">
                                    <select name="category_id" id="category" onchange="set_filter('{{url()->full()}}',this.value, 'category_id')" data-placeholder="{{__('Select category')}}" class="js-data-example-ajax form-control">
                                        @if($category)    
                                            <option value="{{$category->id}}" selected>{{$category->name}} ({{$category->position == 0?__('main'):__('sub')}})</option>
                                        @else
                                            <option value="all" selected>{{__('All categories')}}</option>
                                        @endif
                                    </select>
                                </div>
                                <!-- End Unfold -->

                                <!-- Unfold -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                                        data-hs-unfold-options='{
                                        "target": "#showHideDropdown",
                                        "type": "css-animation"
                                        }'>
                                        <i class="tio-table mr-1"></i> {{__('Columns')}} <span class="badge badge-soft-dark rounded-circle ml-1">7</span>
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
                                                    <span class="mr-2">{{__('Category')}} </span>

                                                    <!-- Checkbox Switch -->
                                                    <label class="toggle-switch toggle-switch-sm" for="toggleColumn_type">
                                                        <input type="checkbox" class="toggle-switch-input" id="toggleColumn_type" checked>
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
                                                    <span class="mr-2">{{__('status')}}</span>

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
                        <!-- End Row -->
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom" id="table-div">
                        <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                "columnDefs": [{
                                    "targets": [],
                                    "width": "5%",
                                    "orderable": false
                                }],
                                "order": [],
                                "info": {
                                "totalQty": "#datatableWithPaginationInfoTotalQty"
                                },

                                "entries": "#datatableEntries",
     
                                "isResponsive": false,
                                "isShowPaging": false,
                                "paging":false
                            }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('#')}}</th>
                                <th style="width: 20%">{{__('Name')}}</th>
                                <th style="width: 20%">{{__('Category')}} </th>
                                <th style="width: 15%">{{__('Restaurant')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($foods as $key=>$food)
                                <tr>
                                    <td>{{$key+$foods->firstItem()}}</td>
                                    <td>
                                        <a class="media align-items-center" href="{{route('admin.food.view',[$food['id']])}}">
                                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$food['image']}}" 
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$food->name}} image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{Str::limit($food['name'],20,'...')}}</h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                    {{Str::limit($food->category,20,'...')}}
                                    </td>
                                    <td>
                                    {{Str::limit($food->restaurant?$food->restaurant->name:__('Restaurant deleted!'), 20, '...')}}
                                    </td>
                                    <td>{{\App\CentralLogics\Helpers::format_currency($food['price'])}}</td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$food->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.food.status',[$food['id'],$food->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$food->id}}" {{$food->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.food.edit',[$food['id']])}}" title="{{__('Edit food')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                            onclick="form_alert('food-{{$food['id']}}','{{__('Want_to_delete_this_item')}}')" title="{{__('Delete food')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.food.delete',[$food['id']])}}"
                                                method="post" id="food-{{$food['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="page-area">
                            <table>
                                <tfoot class="border-top">
                                {!! $foods->withQueryString()->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
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

        $('#toggleColumn_type').change(function (e) {
          datatable.columns(2).visible(e.target.checked)
        })

        $('#toggleColumn_vendor').change(function (e) {
          datatable.columns(3).visible(e.target.checked)
        })

        $('#toggleColumn_status').change(function (e) {
          datatable.columns(5).visible(e.target.checked)
        })
        $('#toggleColumn_price').change(function (e) {
          datatable.columns(4).visible(e.target.checked)
        })
        $('#toggleColumn_action').change(function (e) {
          datatable.columns(6).visible(e.target.checked)
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

        $('#category').select2({
            ajax: {
                url: '{{route("admin.category.get-all")}}',
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

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.food.search')}}',
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
                    $('#foodCount').html(data.count);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
