<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
        <div class="content container-fluid">
            <div class="row">
                <div class="col-5">
                    <div class="text-center pt-4 mb-3">
                        <h2 style="line-height: 1">{{$order->restaurant->name}}</h2>
                        <h5 class="text-break" style="font-size: 20px;font-weight: lighter;line-height: 1">
                            {{$order->restaurant->address}}
                        </h5>
                        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                            {{__('Phone')}} : {{$order->restaurant->phone}}
                        </h5>
                        @if($order->restaurant->gst_status)
                        <h5 style="font-size: 12px;font-weight: lighter;line-height: 1">
                            {{__('ICE No')}} : {{$order->restaurant->gst_code}}
                        </h5>
                        @endif
                    </div>
    
                    <span>---------------------------------------------------------------------------------</span>
                    <div class="row mt-3">
                        <div class="col-6">
                            <h5>{{__('Order id')}} : {{$order['id']}}</h5>
                        </div>
                        <div class="col-6">
                            <h5 style="font-weight: lighter">
                                {{date('d/M/Y '.config('timeformat'),strtotime($order['created_at']))}}
                            </h5>
                        </div>
                        <div class="col-12">
                            <h5>
                                {{__('Customer name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}
                            </h5>
                            <h5>
                                {{__('Phone')}} : {{$order->customer['phone']}}
                            </h5>
                            <h5 class="text-break">
                                {{__('Address')}} : {{isset($order->delivery_address)?json_decode($order->delivery_address, true)['address']:''}}
                            </h5>
                        </div>
                    </div>
                    <h5 class="text-uppercase"></h5>
                    <span>---------------------------------------------------------------------------------</span>
                    <table class="table table-bordered mt-3" style="width: 98%">
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
                                            <strong><u>{{__('Variation')}} : </u></strong>
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
                                    <td class="">
                                        {{$detail->campaign['title']}} <br>
                                        @if(count(json_decode($detail['variation'],true))>0)
                                            <strong><u>{{__('Variation')}} : </u></strong>
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
                                                <span>{{$addon['name']}} :  </span>
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
                    <span>---------------------------------------------------------------------------------</span>
                    <div class="row justify-content-md-end mb-3" style="width: 97%">
                        <div class="col-md-7 col-lg-7">
                            <dl class="row text-right">
                                <dt class="col-6">{{__('Items price')}}:</dt>
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
                                <dt class="col-6">{{__('Coupon discount')}}:</dt>
                                <dd class="col-6">
                                    - {{\App\CentralLogics\Helpers::format_currency($order['coupon_discount_amount'])}}</dd>
                                <dt class="col-6">{{__('vat/tax')}}:</dt>
                                <dd class="col-6">+ {{\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])}}</dd>
                                <dt class="col-6">{{__('Delivery fee')}}:</dt>
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
                    @if ($order->edited && $order->payment_method != 'cash_on_delivery')
                        
                    @endif
                    <div class="d-flex flex-row justify-content-between border-top">
                        <span>{{__('Paid by')}}: {{$order->payment_method}}</span>	<span>{{__('Amount')}}: {{$order->order_amount + $order->adjusment}}</span>	<span>{{__('Change')}}: {{$order->adjusment}}</span>
                    </div>
                    <span>---------------------------------------------------------------------------------</span>
                    <h5 class="text-center pt-3">
                        """{{__('THANK YOU')}}"""
                    </h5>
                    <span>---------------------------------------------------------------------------------</span>
                </div>
            </div>
        </div>
    
    
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>
