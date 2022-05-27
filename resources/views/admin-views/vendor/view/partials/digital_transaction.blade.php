<div>
    <h3 class="qcont px-3 pt-4">{{ __('Order')}} {{ __('transactions')}}</h3>

    <div class="table-responsive">
        <table id="datatable"
            class="table table-thead-bordered table-align-middle card-table"
            style="width: 100%">
            <thead class="thead-light">
                <tr>
                    <th style="width: 10%">{{__('sl#')}}</th>
                    <th style="width: 10%">{{__('order id')}}</th>
                    <th style="width: 20%">{{__('Total order_amount')}}</th>
                    <th style="width: 20%">{{__('restaurant earned')}}</th>
                    <th style="width: 15%">{{__('admin')}}  {{__('earned')}}</th>
                    <th style="width: 15%">{{__('Delivery')}}  {{__('fee')}}</th>
                    <th style="width: 10%">{{__('vat/tax')}}</th>
                </tr>
            </thead>
            <tbody>
            @php($digital_transaction = \App\Models\OrderTransaction::where('vendor_id', $restaurant->vendor->id)->latest()->paginate(25))
            @foreach($digital_transaction as $k=>$dt)
                <tr>
                    <td scope="row">{{$k+$digital_transaction->firstItem()}}</td>
                    <td><a href="{{route('admin.order.details',$dt->order_id)}}">{{$dt->order_id}}</a></td>
                    <td>{{$dt->order_amount}}</td>
                    <td>{{$dt->restaurant_amount - $dt->tax}}</td>
                    <td>{{$dt->admin_commission}}</td>
                    <td>{{$dt->delivery_charge}}</td>
                    <td>{{$dt->tax}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="card-footer">
    {!!$digital_transaction->links()!!}
</div>