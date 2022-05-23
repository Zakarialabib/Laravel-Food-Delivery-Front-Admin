<div>
    <h3 class="qcont px-3 pt-4">{{ __('cash')}} {{ __('transactions by_admin')}}</h3>

    <div class="table-responsive">
        <table id="datatable"
            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
            style="width: 100%">
            <thead class="thead-light">
                <tr>
                    <th>{{__('sl#')}}</th>
                    <th>{{__('Receoved_at')}}</th>
                    <th>{{__('balance_before_transaction')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Reference')}}</th>
                    <th style="width: 5px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
            @php($account_transaction = \App\Models\AccountTransaction::where('from_type', 'restaurant')->where('from_id', $restaurant->vendor->id)->paginate(25))
            @foreach($account_transaction as $k=>$at)
                <tr>
                    <td scope="row">{{$k+$account_transaction->firstItem()}}</td>
                    <td>{{$at->created_at->format('Y-m-d '.config('timeformat'))}}</td>
                    <td>{{$at['current_balance']}}</td>
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
</div>
<div class="card-footer">
    {{$account_transaction->links()}}
</div>