@foreach($orders as $key=>$order)

    <tr class="status-{{$order['order_status']}} class-all">
        <td class="">
            {{$key+1}}
        </td>
        <td class="table-column-pl-0">
            <a href="{{route('admin.order.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
        </td>
        <td>{{date('d M Y',strtotime($order['created_at']))}}</td>
        <td>
            @if($order->customer)
                <a class="text-body text-capitalize"
                    href="{{route('admin.customer.view',[$order['user_id']])}}">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</a>
            @else
                <label class="badge badge-danger">{{__('invalid customer data')}}</label>
            @endif
        </td>
        <td>
            <label class="badge badge-soft-primary">{{Str::limit($order->restaurant?$order->restaurant->name:__('Restaurant deleted!'), 25, '...')}}</label>
        </td>
        <td>
            @if($order->payment_status=='paid')
                <span class="badge badge-soft-success">
                    <span class="legend-indicator bg-success"></span>{{__('Paid')}}
                </span>
            @else
                <span class="badge badge-soft-danger">
                    <span class="legend-indicator bg-danger"></span>{{__('unpaid')}}
                </span>
            @endif
        </td>
        <td>{{\App\CentralLogics\Helpers::format_currency($order['order_amount'])}}</td>
        <td class="text-capitalize">
            @if($order['order_status']=='pending')
                <span class="badge badge-soft-info ml-2 ml-sm-3">
                    <span class="legend-indicator bg-info"></span>{{__('Pending')}} 
                </span>
            @elseif($order['order_status']=='confirmed')
                <span class="badge badge-soft-info ml-2 ml-sm-3">
                    <span class="legend-indicator bg-info"></span>{{__('Confirmed')}} 
                </span>
            @elseif($order['order_status']=='processing')
                <span class="badge badge-soft-warning ml-2 ml-sm-3">
                    <span class="legend-indicator bg-warning"></span>{{__('Processing')}}
                </span>
            @elseif($order['order_status']=='out_for_delivery')
                <span class="badge badge-soft-warning ml-2 ml-sm-3">
                    <span class="legend-indicator bg-warning"></span>{{__('Out for delivery')}}
                </span>
            @elseif($order['order_status']=='delivered')
                <span class="badge badge-soft-success ml-2 ml-sm-3">
                    <span class="legend-indicator bg-success"></span>{{__('Delivered')}}
                </span>
            @else
                <span class="badge badge-soft-danger ml-2 ml-sm-3">
                    <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}
                </span>
            @endif
        </td>
        <td>
            <a class="btn btn-sm btn-white"
                        href="{{route('admin.order.details',['id'=>$order['id']])}}"><i
                            class="tio-visible"></i> {{__('view')}}</a>
            <a class="btn btn-sm btn-white" target="_blank"
                        href="{{route('admin.order.generate-invoice',[$order['id']])}}"><i
                            class="tio-download"></i> {{__('invoice')}}</a>
        </td>/div>
        </td>
    </tr>

@endforeach
