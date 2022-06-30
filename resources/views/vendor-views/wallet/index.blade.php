@extends('layouts.vendor.app')

@section('title',__('Restaurant wallet'))

 
@section('content')
<div class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="page-header-title text-capitalize">{{__('Restaurant wallet')}}</h4>
        </div>
        <div class="card-body row">
        <?php
            $wallet = \App\Models\RestaurantWallet::where('vendor_id',\App\CentralLogics\Helpers::get_vendor_id())->first();
            if(isset($wallet)==false){
                \Illuminate\Support\Facades\DB::table('restaurant_wallets')->insert([
                    'vendor_id'=>\App\CentralLogics\Helpers::get_vendor_id(),
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
                $wallet = \App\Models\RestaurantWallet::where('vendor_id',\App\CentralLogics\Helpers::get_vendor_id())->first();
            }
        ?>
                    <!-- Earnings (Monthly) Card Example -->
            <div class="for-card col-md-4 mb-1">
                <div class="card for-card-body-2 shadow h-100 text-white"  style="background: #8d8d8d;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase for-card-text mb-1">
                                    {{__('Withdraw able balance')}}
                                </div>
                                <div
                                    class="for-card-count">{{$wallet->balance}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"  style="background: #8d8d8d; border:none;">
                        @if(\App\CentralLogics\Helpers::get_vendor_data()->account_no==null || \App\CentralLogics\Helpers::get_vendor_data()->bank_name==null)
                        <a tabindex="0" class="btn btn w-100 btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="{{__('warning missing bank info')}}" data-content="{{__('Warning add bank info')}}">{{__('Request withdraw')}}</a>
                        @else   
                        <a class="btn w-100" style="background: #f9fafc;" href="javascript:" data-toggle="modal" data-target="#balance-modal">{{__('Request withdraw')}}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <!-- Panding Withdraw Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card  shadow h-100 for-card-body-3  badge-secondary" >
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" font-weight-bold for-card-text text-uppercase mb-1">{{__('Pending withdraw')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->pending_withdraw}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card  shadow h-100 for-card-body-3 text-white"  style="background: #2C2E43;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" font-weight-bold for-card-text text-uppercase mb-1">{{__('withdrawn')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->total_withdrawn}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill fa-2x for-fa-3 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collected Cash Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card r shadow h-100 for-card-body-4  badge-dark">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" for-card-text font-weight-bold  text-uppercase mb-1">{{__('Collected cash')}}</div>
                                        <div
                                            class="for-card-count">{{$wallet->collected_cash}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="for-card col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                        <div class="card r shadow h-100 for-card-body-4 text-white" style="background:#362222;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div
                                            class=" for-card-text font-weight-bold  text-uppercase mb-1">{{__('Total earning')}} </div>
                                        <div
                                            class="for-card-count">{{$wallet->total_earning}}</div>
                                    </div>
                                    <div class="col-auto for-margin">
                                        <i class="fas fa-money-bill for-fa-fa-4  fa-2x text-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>

    <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Withdraw request')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('vendor.wallet.withdraw-request')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{__('Amount')}}:</label>
                            <input type="number" name="amount" step="0.01"
                                    value="{{$wallet->balance}}" 
                                    class="form-control" id="" min="0" max="{{$wallet->balance}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Content Row -->
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Withdraw request table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%"
                                data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('#')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Note')}}</th>
                                <th>{{__('Request time')}}</th>
                                <th>{{__('Status')}}</th>
                                <th style="width: 5px">{{__('Close')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraw_req as $k=>$wr)
                                <tr>
                                    <td scope="row">{{$k+$withdraw_req->firstItem()}}</td>
                                    <td>{{$wr['amount']}}</td>
                                    <td>{{$wr->transaction_note}}</td>
                                    <td>{{date('Y-m-d '.config('timeformat'),strtotime($wr->created_at))}}</td>
                                    <td>
                                        @if($wr->approved==0)
                                            <label class="badge badge-primary">{{__('Pending')}} </label>
                                        @elseif($wr->approved==1)
                                            <label class="badge badge-success">{{__('Approved')}}</label>
                                        @else
                                            <label class="badge badge-danger">{{__('Denied')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($wr->approved==0)
                                            {{-- <a href="{{route('vendor.withdraw.close',[$wr['id']])}}"
                                                class="btn btn-danger btn-sm">
                                                {{__('Delete')}}
                                            </a> --}}
                                            <a class="btn btn-sm btn-danger" href="javascript:" onclick="form_alert('withdraw-{{$wr['id']}}','Want to delete this  ?')" title="{{__('Delete')}}"><i class="tio-delete-outlined"></i>
                                        </a>

                                            <form action="{{route('vendor.wallet.close-request',[$wr['id']])}}"
                                                    method="post" id="withdraw-{{$wr['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        @else
                                            <label>{{__('Complete')}}</label>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$withdraw_req->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection