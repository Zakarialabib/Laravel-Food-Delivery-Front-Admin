@extends('layouts.admin.app')

@section('title','Vendor List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{__('restaurants')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$restaurants->total()}}</span></h1>
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
                @if(!isset(auth('admin')->user()->zone_id))
                <div class="col-sm-auto" style="min-width: 306px;">
                    <select name="zone_id" class="form-control js-select2-custom"
                            onchange="set_zone_filter('{{route('admin.vendor.list')}}',this.value)">
                        <option value="all">All Zones</option>
                        @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                            <option
                                value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                {{$z['name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header pb-1 pt-1" >
                        <h5>{{__('restaurants list')}}</h5>
                        <form action="javascript:" id="search-form" >
                                        <!-- Search -->
                            @csrf
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{__('Search')}}" aria-label="{{__('Search')}}" required>
                                <button type="submit" class="btn btn-primary">{{__('Search')}}</button>

                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false

                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 10%;">{{__('#')}}</th>
                                <th style="width: 10%;">{{__('Logo')}}</th>
                                <th style="width: 20%;">{{__('Restaurant')}}</th>
                                <th style="width: 15%;">{{__('Owner')}}</th>
                                <th style="width: 15%;">{{__('Zone')}}</th>
                                <th style="width: 10%;">{{__('Phone')}}</th>
                                <th class="text-uppercase" style="width: 10%;">{{__('Active')}}/{{__('Inactive')}}</th>
                                <th style="width: 10%;">{{__('Action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($restaurants as $key=>$dm)
                                <tr>
                                    <td>{{$key+$restaurants->firstItem()}}</td>
                                    <td>
                                        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
                                            <a href="{{route('admin.vendor.view', $dm->id)}}" alt="view restaurant">
                                            <img width="60" style="border-radius: 50%; height:100%;"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/restaurant')}}/{{$dm['logo']}}"></a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.vendor.view', $dm->id)}}" alt="view restaurant">
                                            <span class="d-block font-size-sm text-body">
                                                {{Str::limit($dm->name,20,'...')}}<br>
                                                {{__('id')}}:{{$dm->id}}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$dm->vendor->f_name.' '.$dm->vendor->l_name}}
                                        </span>
                                    </td>
                                    <td>
                                        {{$dm->zone?$dm->zone->name:__('Zone').' '.__('deleted')}}
                                        {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                                    </td>
                                    <td>
                                        {{$dm['phone']}}
                                    </td>
                                    <td>
                                        @if(isset($dm->vendor->status))
                                            @if($dm->vendor->status)
                                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$dm->id}}">
                                                <input type="checkbox" onclick="status_change_alert('{{route('admin.vendor.status',[$dm->id,$dm->status?0:1])}}', '{{__('you_want_to_change_this_restaurant_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$dm->id}}" {{$dm->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            @else
                                            <span class="badge badge-soft-danger">{{__('Denied')}}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-soft-danger">{{__('Pending')}} </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.vendor.view',[$dm['id']])}}" title="{{__('view restaurant')}}"><i class="tio-visible text-success"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.vendor.edit',[$dm['id']])}}" title="{{__('edit restaurant')}}"><i class="tio-edit text-primary"></i>
                                        </a>
                                        {{--<a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('vendor-{{$dm['id']}}','Want to remove this information ?')" title="{{__('delete restaurant')}}"><i class="tio-delete-outlined text-danger"></i>
                                        </a>
                                        <form action="{{route('admin.vendor.delete',[$dm['id']])}}" method="post" id="vendor-{{$dm['id']}}">
                                            @csrf @method('delete')
                                        </form>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $restaurants->links() !!}
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
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        }
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.total);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
