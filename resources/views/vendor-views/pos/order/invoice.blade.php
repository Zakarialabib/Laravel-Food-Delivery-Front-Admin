<div style="width:410px;">
    <div class="text-center pt-4 mb-3">
        <h2 class="text-break" style="line-height: 1">{{$order->restaurant->name}}</h2>
        <h5 class="text-break" style="font-size: 20px;font-weight: lighter;line-height: 1">
            {{$order->restaurant->address}}
        </h5>
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{__('Phone')}} : {{$order->restaurant->phone}}
        </h5>
        @if($order->restaurant->gst_status)
        <h5 style="font-size: 12px;font-weight: lighter;line-height: 1">
            {{__('Gst No')}} : {{$order->restaurant->gst_code}}
        </h5>
        @endif
    </div>

    <div class="row mt-3 divide-y">
        <div class="col-6">
            <h5>{{__('Order ID')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6">
            <h5 style="font-weight: lighter">
                {{date('d/M/Y '.config('timeformat'),strtotime($order['created_at']))}}
            </h5>
        </div>
        @if($order->customer)
        <div class="col-12 text-break">
            <h5>
                {{__('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}
            </h5>
            <h5>
                {{__('Phone')}} : {{$order->customer['phone']}}
            </h5>
            <h5 class="text-break">
                {{__('Address')}} : {{isset($order->delivery_address)?json_decode($order->delivery_address, true)['address']:''}}
            </h5>
        </div>
        @endif
    </div>
    <h5 class="text-uppercase"></h5>
    
    <table class="table table-bordered mt-3 divide-y" style="width: 98%">
        <thead>
        <tr>
            <th style="width: 10%">{{__('QTY')}}</th>
            <th class="">{{__('DESC')}}</th>
            <th class="">{{__('Price')}}</th>
        </tr>
        </thead>

        <tbody>
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_dis_on_pro=0)
        @php($add_ons_cost=0)
        @foreach($order->details as $detail)
            @if($detail->food)
                <tr>
                    <td class="">
                        {{$detail['quantity']}}
                    </td>
                    <td class="text-break">
                        {{$detail->food['name']}} <br>
                        @if(count(json_decode($detail['variation'],true))>0)
                            <strong><u>Variation : </u></strong>
                            @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                <div class="font-size-sm text-body">
                                    <span>{{$key1}} :  </span>
                                    <span class="font-weight-bold">{{$key1=='price'?\App\CentralLogics\Helpers::format_currency($variation):$variation}}</span>
                                </div>
                            @endforeach
                        @else
                        <div class="font-size-sm text-body">
                            <span>{{'Price'}} :  </span>
                            <span class="font-weight-bold">{{\App\CentralLogics\Helpers::format_currency($detail->price)}}</span>
                        </div>
                        @endif

                        @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                            @if($key2==0)<strong><u>{{__('Addons')}} :</u></strong>@endif
                            <div class="font-size-sm text-body">
                                <span class="text-break">{{$addon['name']}} :  </span>
                                <span class="font-weight-bold">
                                    {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                </span>
                            </div>
                            @php($add_ons_cost+=$addon['price']*$addon['quantity'])
                        @endforeach
                    </td>
                    <td style="width: 28%">
                        @php($amount=($detail['price'])*$detail['quantity'])
                        {{\App\CentralLogics\Helpers::format_currency($amount)}}
                    </td>
                </tr>
                @php($sub_total+=$amount)
                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
            
            @elseif($detail->campaign)
                <tr>
                    <td class="">
                        {{$detail['quantity']}}
                    </td>
                    <td class="text-break">
                        {{$detail->campaign['title']}} <br>
                        @if(count(json_decode($detail['variation'],true))>0)
                            <strong><u>Variation : </u></strong>
                            @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                <div class="font-size-sm text-body">
                                    <span>{{$key1}} :  </span>
                                    <span class="font-weight-bold">{{$key1=='price'?\App\CentralLogics\Helpers::format_currency($variation):$variation}}</span>
                                </div>
                            @endforeach
                        @else
                        <div class="font-size-sm text-body">
                            <span>{{'Price'}} :  </span>
                            <span class="font-weight-bold">{{\App\CentralLogics\Helpers::format_currency($detail->price)}}</span>
                        </div>
                        @endif

                        @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                            @if($key2==0)<strong><u>{{__('Addons')}} :</u></strong>@endif
                            <div class="font-size-sm text-body">
                                <span class="text-break">{{$addon['name']}} :  </span>
                                <span class="font-weight-bold">
                                                {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                            </span>
                            </div>
                            @php($add_ons_cost+=$addon['price']*$addon['quantity'])
                        @endforeach
                    </td>
                    <td style="width: 28%">
                        @php($amount=($detail['price'])*$detail['quantity'])
                        {{\App\CentralLogics\Helpers::format_currency($amount)}}
                    </td>
                </tr>
                @php($sub_total+=$amount)
                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
            @endif
        @endforeach
        </tbody>
    </table>
    <div class="row justify-content-md-end divide-y">
        <div class="col-md-7 col-lg-7">
            <dl class="row text-right">
                <dt class="col-6">{{__('Items Price')}}:</dt>
                <dd class="col-6">{{\App\CentralLogics\Helpers::format_currency($sub_total)}}</dd>
                <dt class="col-6">{{__('Addon Cost')}}:</dt>
                <dd class="col-6">
                    {{\App\CentralLogics\Helpers::format_currency($add_ons_cost)}}
                    <hr>
                </dd>
                <dt class="col-6">{{__('Subtotal')}}:</dt>
                <dd class="col-6">
                    {{\App\CentralLogics\Helpers::format_currency($sub_total+$total_tax+$add_ons_cost)}}</dd>
                <dt class="col-6">{{__('Discount')}}:</dt>
                <dd class="col-6">
                    - {{\App\CentralLogics\Helpers::format_currency($order['restaurant_discount_amount'])}}</dd>
                <dt class="col-6">{{__('Coupon Discount')}}:</dt>
                <dd class="col-6">
                    - {{\App\CentralLogics\Helpers::format_currency($order['coupon_discount_amount'])}}</dd>
                <dt class="col-6">{{__('vat/tax')}}:</dt>
                <dd class="col-6">+ {{\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])}}</dd>
                <dt class="col-6">{{__('Delivery Fee')}}:</dt>
                <dd class="col-6">
                    @php($del_c=$order['delivery_charge'])
                    {{\App\CentralLogics\Helpers::format_currency($del_c)}}
                    <hr>
                </dd>

                <dt class="col-6" style="font-size: 20px">{{__('Total')}}:</dt>
                <dd class="col-6" style="font-size: 20px">{{\App\CentralLogics\Helpers::format_currency($sub_total+$del_c+$order['total_tax_amount']+$add_ons_cost-$order['coupon_discount_amount'] - $order['restaurant_discount_amount'])}}</dd>
            </dl>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-between border-top">
        <span>{{__('Paid by')}}: {{$order->payment_method}}</span>	<span>{{__('Amount')}}: {{$order->order_amount + $order->adjusment}}</span>	<span>Change: {{$order->adjusment}}</span>
    </div>
    <h5 class="text-center pt-3">
        """{{__('THANK YOU')}}"""
    </h5>
</div>