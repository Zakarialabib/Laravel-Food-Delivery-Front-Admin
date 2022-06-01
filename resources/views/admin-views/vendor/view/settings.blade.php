@extends('layouts.admin.app')

@section('title',$restaurant->name."'s Settings")

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Vendor view')}}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-6">
                <h1 class="page-header-title text-break">{{$restaurant->name}}</h1>
            </div>
            <div class="col-6">
                <a href="{{route('admin.vendor.edit',[$restaurant->id])}}" class="btn btn-primary float-right">
                    <i class="tio-edit"></i> {{__('Edit restaurant')}}
                </a>
            </div>
        </div>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
                </a>
            </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
            <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', $restaurant->id)}}">{{__('Restaurant')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'order'])}}"  aria-disabled="true">{{__('Order')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'product'])}}"  aria-disabled="true">{{__('Food')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'discount'])}}"  aria-disabled="true">{{__('Discount')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'settings'])}}"  aria-disabled="true">{{__('Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{__('transaction')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'reviews'])}}"  aria-disabled="true">{{__('Reviews')}}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
        <!-- End Page Header -->
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="vendor">
            <div class="row pt-2" >
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            {{__('Restaurant settings')}}
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-md-center">
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="food_section">
                                        <span class="pr-2">{{__('Food section')}}<span class="input-label-secondary" title="{{__('Show hide food menu')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('Show hide food menu')}}"></span> :</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->food_section?0:1, 'food_section'])}}'" name="food_section" id="food_section" {{$restaurant->food_section?'checked':''}}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="free_delivery">
                                        <span class="pr-2">{{__('Free delivery')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->free_delivery?0:1, 'free_delivery'])}}'" id="free_delivery" {{$restaurant->free_delivery?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="schedule_order">
                                        <span class="pr-2">{{__('Scheduled order')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->schedule_order?0:1, 'schedule_order'])}}'" id="schedule_order" {{$restaurant->schedule_order?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="reviews_section">
                                        <span class="pr-2">{{__('reviews panel')}}<span class="input-label-secondary" title="{{__('Show hide reviews menu')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('Show hide food menu')}}"></span> :</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->reviews_section?0:1, 'reviews_section'])}}'" name="reviews_section" id="reviews_section" {{$restaurant->reviews_section?'checked':''}}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="delivery">
                                            <span class="pr-2">{{__('Delivery')}} :</span> 
                                            <input type="checkbox" name="delivery" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->delivery?0:1, 'delivery'])}}'" id="delivery" {{$restaurant->delivery?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="take_away">
                                        <span class="pr-2 text-capitalize">{{__('Take away')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->take_away?0:1, 'take_away'])}}'" id="take_away" {{$restaurant->take_away?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="self_delivery_system">
                                        <span class="pr-2 text-capitalize">{{__('Self delivery system')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->self_delivery_system?0:1, 'self_delivery_system'])}}'" id="self_delivery_system" {{$restaurant->self_delivery_system?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="pos_system">
                                        <span class="pr-2 text-capitalize">{{__('Pos System')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->pos_system?0:1, 'pos_system'])}}'" id="pos_system" {{$restaurant->pos_system?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @if ($toggle_veg_non_veg)
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="veg">
                                        <span class="pr-2 text-capitalize">{{__('Veg')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->veg?0:1, 'veg'])}}'" id="veg" {{$restaurant->veg?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="non_veg">
                                        <span class="pr-2 text-capitalize">{{__('Non veg')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$restaurant->id,$restaurant->non_veg?0:1, 'non_veg'])}}'" id="non_veg" {{$restaurant->non_veg?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    {{__('Daily time schedule')}}
                                </div>
                                <div class="card-body" id="schedule">
                                    @include('admin-views.vendor.view.partials._schedule', $restaurant)
                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-header">
                                    {{__('Basic settings')}}
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin.vendor.update-settings',[$restaurant['id']])}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf 
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="input-label text-capitalize" for="title">{{__('Minimum order amount')}}</label>
                                                <input type="number" name="minimum_order" step="0.01" min="0" max="100000" class="form-control" placeholder="100" value="{{$restaurant->minimum_order??'0'}}"> 
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="input-label" for="minimum_delivery_time">{{__('Minimum delivery time')}}</label>
                                                <input type="text" name="minimum_delivery_time" class="form-control" placeholder="30" pattern="^[0-9]{2}$" required value="{{explode('-',$restaurant->delivery_time)[0]}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="input-label" for="maximum_delivery_time">{{__('Maximum delivery time')}}</label>
                                                <input type="text" name="maximum_delivery_time" class="form-control" placeholder="40" pattern="[0-9]{2}" required value="{{explode('-',$restaurant->delivery_time)[1]}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"> 
                                                <div class="form-group p-2 border">
                                                    <label class="d-flex justify-content-between switch toggle-switch-sm text-dark" for="comission_status">
                                                        <span>{{__('Admin commission')}}(%) <span class="input-label-secondary" title="{{__('If sales commission disabled system default will be applicable')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('If sales commission disabled system default will be applicable')}}"></span></span>
                                                        <input type="checkbox" class="toggle-switch-input" name="comission_status" id="comission_status" value="1" {{isset($restaurant->comission)?'checked':''}}>
                                                        <span class="toggle-switch-label">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                    <input type="number" id="comission" min="0" max="10000" step="0.01" name="comission" class="form-control" required value="{{$restaurant->comission??'0'}}" {{isset($restaurant->comission)?'':'readonly'}}>
                                                </div>
                                            </div>
                                            <div class="col-6"> 
                                                <div class="form-group p-2 border">
                                                    <label class="d-flex justify-content-between switch toggle-switch-sm text-dark" for="tax">
                                                        <span>{{__('vat/tax')}}(%)</span>
                                                    </label>
                                                    <input type="number" id="tax" min="0" max="10000" step="0.01" name="tax" class="form-control" required value="{{$restaurant->tax??'0'}}" {{isset($restaurant->tax)?'':'readonly'}}>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create schedule modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Create Schedule')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:" method="post" id="add-schedule">
                    @csrf
                    <input type="hidden" name="day" id="day_id_input">
                    <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">{{__('Start time')}}:</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{__('End time')}}:</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();

            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var day_name = button.data('day');
                var day_id = button.data('dayid');
                var modal = $(this);
                modal.find('.modal-title').text('{{__('Create Schedule For ')}} ' + day_name);
                modal.find('.modal-body input[name=day]').val(day_id);
            })
        });
    </script>
    <script>
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

            $('#column3_search').on('change', function () {
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
            $("#comission_status").on('change', function(){
                if($("#comission_status").is(':checked')){
                    $('#comission').removeAttr('readonly');
                } else {
                    $('#comission').attr('readonly', true);
                    $('#comission').val('0');
                }
            });

        });

        function delete_schedule(route) {
            Swal.fire({
                title: '{{__('Are you sure')}}',
                text: '{{__('You want to remove this schedule')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '{{__('no')}}',
                confirmButtonText: '{{__('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data.errors) {
                                for (var i = 0; i < data.errors.length; i++) {
                                    toastr.error(data.errors[i].message, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            } else {
                                $('#schedule').empty().html(data.view);
                                toastr.success('{{__('Schedule removed successfully')}}', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr.error('{{__('Schedule not found')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                }
            })
        };

        $('#add-schedule').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.add-schedule')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#schedule').empty().html(data.view);
                        $('#exampleModal').modal('hide');
                        toastr.success('{{__('Schedule added successfully')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(XMLHttpRequest.responseText, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
