@extends('layouts.admin.app')

@section('title',__('Account transaction'))

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Account transaction')}}  </li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <!-- <h4 class=" mb-0 text-black-50">{{__('Account transaction')}}</h4> -->
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="text-capitalize">{{__('Add account transaction')}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.account-transaction.store')}}" method='post' id="add_transaction">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="input-label" for="type">{{__('Type')}}<span class="input-label-secondary"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="deliveryman">{{__('Deliveryman')}}</option>
                                <option value="restaurant">{{__('Restaurant')}}</option>
                            </select>
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="restaurant">{{__('Restaurant')}}<span class="input-label-secondary"></span></label>
                            <select id="restaurant" name="restaurant_id" data-placeholder="{{__('Select restaurant')}}" onchange="getAccountData('{{url('/')}}/admin/vendor/get-account-data/',this.value,'restaurant')" class="form-control" title="Select Restaurant" disabled>
                                                    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="deliveryman">{{__('Deliveryman')}}<span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="{{__('Select deliveryman')}}" onchange="getAccountData('{{url('/')}}/admin/delivery-man/get-account-data/',this.value,'deliveryman')" class="form-control" title="Select deliveryman">
                                                    
                            </select>
                        </div>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="method">{{__('method')}}<span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" required maxlength="191">
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="ref">{{__('Reference')}}<span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" maxlength="191">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="amount">{{__('Amount')}}<span class="input-label-secondary" id="account_info"></span></label>
                            <input class="form-control" type="number" min=".01" step="0.01" name="amount" id="amount" max="999999999999.99">
                        </div>
                    </div>  
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{{__('Save')}}" >
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Account transaction table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('#')}}</th>
                                    <th>{{ __('Received from') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{__('Received at')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Reference')}}</th>
                                    <th style="width: 5px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($account_transaction as $k=>$at)
                                <tr>
                                    <td scope="row">{{$k+$account_transaction->firstItem()}}</td>
                                    <td>
                                        @if($at->restaurant)
                                        <a href="{{route('admin.vendor.view',[$at->restaurant['id']])}}">{{ Str::limit($at->restaurant->name, 20, '...') }}</a>
                                        @elseif($at->deliveryman)
                                        <a href="{{route('admin.delivery-man.preview',[$at->deliveryman->id])}}">{{ $at->deliveryman->f_name }} {{ $at->deliveryman->l_name }}</a>
                                        @else
                                            {{__('Not found')}}
                                        @endif
                                    </td>
                                    <td><label class="text-uppercase">{{$at['from_type']}}</label></td>
                                    <td>{{$at->created_at->format('Y-m-d '.config('timeformat'))}}</td>
                                    <td>{{$at['amount']}}</td>
                                    <td>{{$at['ref']}}</td>
                                    <td>
                                        <a href="{{route('admin.account-transaction.show',[$at['id']])}}"
                                        class="btn btn-white btn-sm"><i class="tio-visible"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$account_transaction->links()}}
                </div>
            </div>
        </div>
     </div>
</div>
@endsection

@push('script_2')
<script>
    $(document).on('ready', function () {
        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        $('#type').on('change', function() {
            if($('#type').val() == 'restaurant')
            {
                $('#restaurant').removeAttr("disabled");
                $('#deliveryman').val("").trigger( "change" );
                $('#deliveryman').attr("disabled","true");
            }
            else if($('#type').val() == 'deliveryman')
            {
                $('#deliveryman').removeAttr("disabled");
                $('#restaurant').val("").trigger( "change" );
                $('#restaurant').attr("disabled","true");
            }
        });
    });
    $('#restaurant').select2({
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

    $('#deliveryman').select2({
        ajax: {
            url: '{{url('/')}}/admin/delivery-man/get-deliverymen',
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

    function getAccountData(route, data_id, type)
    {
        $.get({
                url: route+data_id,
                dataType: 'json',
                success: function (data) {
                    $('#account_info').html('({{__('Cash in hand')}}: '+data.cash_in_hand+' {{__('Earning balance')}}: '+data.earning_balance+')');
                },
            });
    }
</script>
<script>
    $('#add_transaction').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '{{route('admin.account-transaction.store')}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success('{{__('Transaction saved')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setTimeout(function () {
                        location.href = '{{route('admin.account-transaction.index')}}';
                    }, 2000);
                }
            }
        });
    });
</script>
@endpush