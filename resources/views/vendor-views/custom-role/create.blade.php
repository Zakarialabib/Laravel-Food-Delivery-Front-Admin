@extends('layouts.vendor.app')
@section('title','Create Role')
 
@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('Custom role')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black">{{__('Custom role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('Role form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('vendor.custom-role.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="input-label qcont" for="name">{{__('Role name')}}</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="Ex : Store" required>
                        </div>

                        <label class="input-label qcont" for="name">{{__('Module permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="food" class="form-check-input"
                                           id="food">
                                    <label class="form-check-label input-label qcont" for="food">{{__('Food')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order">
                                    <label class="form-check-label input-label qcont" for="order">{{__('Order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="restaurant_setup" class="form-check-input"
                                           id="restaurant_setup">
                                    <label class="form-check-label input-label qcont" for="restaurant_setup">{{__('Restaurant setup')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon">
                                    <label class="form-check-label input-label qcont" for="addon">{{__('Addon')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                           id="wallet">
                                    <label class="form-check-label input-label qcont" for="wallet">{{__('Wallet')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                           id="bank_info">
                                    <label class="form-check-label input-label qcont" for="bank_info">{{__('Bank info')}} </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee">
                                    <label class="form-check-label input-label qcont" for="employee">{{__('Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                           id="my_shop">
                                    <label class="form-check-label input-label qcont" for="my_shop">{{__('My shop')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role">
                                    <label class="form-check-label input-label qcont" for="custom_role">{{__('Custom role')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign">
                                    <label class="form-check-label input-label qcont" for="campaign">{{__('Campaign')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                           id="reviews">
                                    <label class="form-check-label input-label qcont" for="reviews">{{__('Reviews')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos">
                                    <label class="form-check-label input-label qcont" for="pos">{{__('Pos')}} </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">
                    <h5>{{__('Roles table')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$rl->total()}}</span></h5>
                    <form action="javascript:" id="search-form">
                        @csrf
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{__('Search')}}" aria-label="{{__('Search')}}">
                            <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 50px">{{__('#')}}</th>
                                    <th scope="col" style="width: 50px">{{__('Role name')}}</th>
                                    <th scope="col" style="width: 200px">{{__('Modules')}}</th>
                                    <th scope="col" style="width: 50px">{{__('Created at')}}</th>
                                    {{--<th scope="col" style="width: 50px">{{__('Status')}}</th>--}}
                                    <th scope="col" style="width: 50px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody  id="set-rows">
                            @foreach($rl as $k=>$r)
                                <tr>
                                    <td scope="row">{{$k+$rl->firstItem()}}</td>
                                    <td>{{Str::limit($r['name'],20,'...')}}</td>
                                    <td class="text-capitalize">
                                        @if($r['modules']!=null)
                                            @foreach((array)json_decode($r['modules']) as $key=>$m)
                                               {{str_replace('_',' ',$m)}},
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{date('d-M-y',strtotime($r['created_at']))}}</td>
                                    {{--<td>
                                        {{$r->status?'Active':'Inactive'}}
                                    </td>--}}
                                    <td class="d-flex flex-row">
                                        <a class="btn btn-sm bg-green-500 mr-1"
                                            href="{{route('vendor.custom-role.edit',[$r['id']])}}" title="{{__('Edit role')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" href="javascript:"
                                            onclick="form_alert('role-{{$r['id']}}','{{__('Want to delete this role')}}')" title="{{__('Delete role')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('vendor.custom-role.delete',[$r['id']])}}"
                                                method="post" id="role-{{$r['id']}}">
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
                                <tfoot>
                                {!! $rl->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.custom-role.search')}}',
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
        $(document).ready(function() {
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));
        });
    </script>
@endpush
