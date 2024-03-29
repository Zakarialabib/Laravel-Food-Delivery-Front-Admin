@extends('layouts.admin.app')

@section('title', __('Edit account transaction'))

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
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="input-label" for="type">{{__('Type')}}<span class="input-label-secondary"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="deliveryman" {{$account_transaction->from_type=='deliveryman'?'selected':''}}>{{__('Deliveryman')}}</option>
                                <option value="restaurant" {{$account_transaction->from_type=='deliveryman'?'selected':''}}>{{__('Restaurant')}}</option>
                            </select>
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="restaurant">{{__('Restaurant')}}<span class="input-label-secondary"></span></label>
                            <select id="restaurant" name="restaurant_id" data-placeholder="{{__('Select restaurant')}}" class="form-control" title="Select Restaurant" {{$account_transaction->deliveryman?'disabled':''}}>
                                                    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="deliveryman">{{__('Deliveryman')}}<span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="{{__('Select deliveryman')}}" class="form-control" title="Select deliveryman" {{$account_transaction->restaurant?'disabled':''}}>
                                                    
                            </select>
                        </div>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="method">{{__('method')}}<span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" value="{{$account_transaction->method}}" maxlength="191">
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="ref">{{__('Reference')}}<span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" value="{{$account_transaction->ref}}" maxlength="191">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="amount">{{__('Amount')}}<span class="input-label-secondary"></span></label>
                            <input class="form-control" type="number" min=".01" step="0.01" name="amount" id="amount" value="{{$account_transaction->amount}}" max="999999999999.99">
                        </div>
                    </div>  
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{{__('Save')}}" >
                </div>
            </form>
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
            url: '{{route('admin.account-transaction.update')}}',
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
                    toastr.success('{{__('Transaction updated')}}', {
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