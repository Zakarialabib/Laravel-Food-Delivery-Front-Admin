@extends('layouts.admin.app')

@section('title', __('Order details'))

@push('css_or_js')
<style>
    .item-box{
        height:250px;
        width:150px;
        padding:3px;
    }

    .header-item{
        width:10rem;
    }
</style>
@endpush

@section('content')
    <?php $campaign_order=isset($order->details[0]->campaign)?true:false;?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link"
                                   href="{{route('admin.order.list',['status'=>'all'])}}">
                                    {{__('Orders')}} 
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Order details')}}</li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">{{__('Order')}} #{{$order['id']}}</h1>

                        @if($order['payment_status']=='paid')
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{__('Paid')}}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-sm-3">
                                <span class="legend-indicator bg-danger"></span>{{__('unpaid')}}
                            </span>
                        @endif

                        @if($order['order_status']=='pending')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-info text"></span>{{__('Pending')}} 
                            </span>
                        @elseif($order['order_status']=='confirmed')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-info"></span>{{__('Confirmed')}} 
                            </span>
                        @elseif($order['order_status']=='processing')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-warning"></span>{{__('Processing')}}
                            </span>
                        @elseif($order['order_status']=='picked_up')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-warning"></span>{{__('Out for delivery')}}
                            </span>
                        @elseif($order['order_status']=='delivered')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-success"></span>{{__('Delivered')}}
                            </span>
                        @elseif($order['order_status']=='failed')
                            <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                <span class="legend-indicator text-capitalize bg-danger"></span>{{__('Payment failed')}}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @endif
                        @if($campaign_order)
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{__('Campaign order')}}
                            </span>
                        @endif
                        @if($order->edited)
                            <span class="badge badge-soft-dark ml-sm-3">
                                <span class="legend-indicator bg-dark"></span>{{__('Edited')}}
                            </span>
                        @endif
                        <span class="ml-2 ml-sm-3">
                                <i class="tio-date-range"></i> {{date('d M Y '.config('timeformat'),strtotime($order['created_at']))}}
                        </span>
                    </div>

                    <div class="mt-2">
                        <a class="text-body mr-3"
                           href={{route('admin.order.generate-invoice',[$order['id']])}}>
                            <i class="tio-print mr-1"></i> {{__('Print invoice')}}
                        </a>

                        <!-- Unfold -->
                        <div class="hs-unfold ml-1">
                            <h5>
                                <i class="tio-shop"></i>
                                {{__('Restaurant')}} : <label
                                    class="badge badge-secondary">{{Str::limit($order->restaurant?$order->restaurant->name:__('Restaurant deleted!'), 25,'...')}}</label>
                            </h5>
                        </div>
                        @php
                            $refund_amount = $order->order_amount;
                            if($order->order_status == 'delivered')
                            {
                                $refund_amount = $order->order_amount - $order->delivery_charge;
                            }
                        @endphp
                        <div class="hs-unfold ml-1">
                            <h5>
                                <button class="btn btn-xs btn-secondary"  data-toggle="modal" data-target="#locationModal" ><i class="tio-map"></i> {{__('Show locations on map')}}</button>
                                @if($order->payment_method != 'cash_on_delivery' && $order->payment_status == 'paid' && $order->order_status != 'refunded')
                                <button class="btn btn-xs btn-danger"  onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'refunded'])}}','{{__('You want to refund this order', ['amount'=> $refund_amount.' '.\App\CentralLogics\Helpers::currency_code()])}}', '{{__('Are you sure want to refund')}}')" ><i class="tio-money"></i> {{__('refund this order')}}</button>
                                @endif
                            </h5>
                        </div>
                        @if($order->order_status != 'refunded')
                        <div class="hs-unfold float-right">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    {{__('status')}}
                                </button>
                                @php($order_delivery_verification = (boolean)\App\Models\BusinessSetting::where(['key' => 'order_delivery_verification'])->first()->value)
                                <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item {{$order['order_status']=='pending'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'pending'])}}','Change status to pending ?')"
                                       href="javascript:">{{__('Pending')}} </a>
                                    <a class="dropdown-item {{$order['order_status']=='confirmed'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'confirmed'])}}','Change status to confirmed ?')"
                                       href="javascript:">{{__('Confirmed')}} </a>
                                    <a class="dropdown-item {{$order['order_status']=='processing'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'processing'])}}','Change status to processing ?')"
                                       href="javascript:">{{__('Processing')}}</a>
                                    <a class="dropdown-item {{$order['order_status']=='handover'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'handover'])}}','Change status to handover ?')"
                                       href="javascript:">{{__('handover')}}</a>
                                    <a class="dropdown-item {{$order['order_status']=='picked_up'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'picked_up'])}}','Change status to out for delivery ?')"
                                       href="javascript:">{{__('Out for delivery')}}</a>
                                    <a class="dropdown-item {{$order['order_status']=='delivered'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'delivered'])}}','Change status to delivered (payment status will be paid if not)?')"
                                       href="javascript:">{{__('Delivered')}}</a>
                                    <a class="dropdown-item {{$order['order_status']=='canceled'?'active':''}}"
                                       onclick="route_alert('{{route('admin.order.status',['id'=>$order['id'],'order_status'=>'canceled'])}}','Change status to canceled ?')"
                                       href="javascript:">{{__('Canceled')}}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- End Unfold -->
                    </div>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle mr-1"
                       href="{{route('admin.order.details',[$order['id']-1])}}"
                       data-toggle="tooltip" data-placement="top" title="{{__('Previous order')}}">
                        <i class="tio-arrow-backward"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle"
                       href="{{route('admin.order.details',[$order['id']+1])}}" data-toggle="tooltip"
                       data-placement="top" title="{{__('Next order')}}">
                        <i class="tio-arrow-forward"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header" style="display: block!important;">
                        <div class="row">
                            <div class="col-12 pb-2 border-bottom  d-flex justify-content-between">
                                <h4 class="card-header-title">
                                    {{__('Order details')}}
                                    <span
                                        class="badge badge-soft-dark rounded-circle ml-1">{{$order->details->count()}}</span>
                                </h4>
                                @if (!$editing && in_array($order->order_status, ['pending','confirmed','processing','accepted']))
                                <button class="btn btn-sm btn-primary" type="button" onclick="edit_order()">
                                    <i class="tio-edit"></i> {{__('Edit')}}
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 pt-2">
                                <h6 style="color: #8a8a8a;">
                                    {{__('Order note')}} : {{$order['order_note']}}
                                </h6>
                            </div>
                            <div class="col-6 pt-2">
                                <div class="text-right">
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">
                                        {{__('Payment method')}} : {{str_replace('_',' ',$order['payment_method'])}}
                                    </h6>
                                    <h6 class="" style="color: #8a8a8a;">
                                        @if($order['transaction_reference']==null)
                                            {{__('Reference code')}} :
                                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                    data-target=".bd-example-modal-sm">
                                                {{__('Add')}}
                                            </button>
                                        @else
                                            {{__('Reference code')}} : {{$order['transaction_reference']}}
                                        @endif
                                    </h6>
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">{{__('Order type')}} 
                                        : <label style="font-size: 10px"
                                                 class="badge badge-soft-primary">{{str_replace('_',' ',$order['order_type'])}}</label>
                                    </h6>
                                    @if($order->schedule_at && $order->scheduled)
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">{{__('Scheduled_at')}}
                                        : <label style="font-size: 10px"
                                                 class="badge badge-soft-primary">{{date('d M Y '.config('timeformat'),strtotime($order['schedule_at']))}}</label>
                                    </h6>
                                    @endif
                                    @if($order->coupon)
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">{{__('coupon')}}
                                        : <label style="font-size: 10px"
                                                 class="badge badge-soft-primary">{{$order->coupon_code}} ({{__(''.$order->coupon->coupon_type)}})</label>
                                    </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- food cart -->
                        @if($editing && !$campaign_order)
                        <div class="row border-top pt-1">
                            <div class="col-12 d-flex flex-wrap justify-content-between ">
                                <form id="search-form" class="header-item">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch" type="search" value="{{$keyword?$keyword:''}}" name="search" class="form-control" placeholder="{{__('Search here')}}" aria-label="Search here">
                                    </div>
                                    <!-- End Search -->
                                </form>
                                <div class="input-group header-item">
                                    <select name="category" id="category" class="form-control js-select2-custom mx-1" title="{{__('Select category')}}" onchange="set_category_filter(this.value)">
                                        <option value="">{{__("All categories")}}</option>
                                        @foreach ($categories as $item)
                                        <option value="{{$item->id}}" {{$category==$item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-12" id="items">
                                <div class="d-flex flex-wrap mt-2 mb-3" style="justify-content: space-around;">
                                    @foreach($products as $product)
                                        <div class="item-box">
                                            @include('admin-views.order.partials._single_product',['product'=>$product, 'restaurant_data'=>$order->restaurant])
                                            {{--<hr class="d-sm-none">--}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                {!!$products->withQueryString()->links()!!}
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                    <?php
                        $coupon = null;
                        $total_addon_price = 0;
                        $product_price = 0;
                        $restaurant_discount_amount = 0;
                        $del_c=$order['delivery_charge'];
                        if($editing)
                        {
                            $del_c=$order['original_delivery_charge'];
                        }
                        if($order->coupon_code)
                        {
                            $coupon = \App\Models\Coupon::where(['code' => $order['coupon_code']])->first();
                            if($editing && $coupon->coupon_type == 'free_delivery')
                            {
                                $del_c = 0;
                                $coupon = null;
                            }
                        }
                        $details = $order->details;
                        if($editing)
                        {
                            $details = session('order_cart');
                        }
                        else
                        {
                            foreach($details as $key=>$item)
                            {
                                $details[$key]->status = true;
                            }
                        }
                    ?>
                    @foreach($details as $key=>$detail)
                        @if(isset($detail->food_id) && $detail->status)
                        <?php
                            if(!$editing)
                            {
                                $detail->food = json_decode($detail->food_details, true);
                            }
                        ?>
                            
                            <!-- Media -->
                                <div class="media">
                                @if($editing)
                                    <div class="avatar avatar-xl mr-3 cursor-pointer" onclick="quick_view_cart_item({{$key}})" title="{{__('click to edit this item')}}">
                                        <span class="avatar-status avatar-lg-status avatar-status-dark"><i class="tio-edit"></i></span>
                                        <img class="img-fluid"
                                             src="{{asset('storage/app/public/product')}}/{{$detail->food['image']}}"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             alt="Image Description">
                                    </div>
                                @else
                                    <a class="avatar avatar-xl mr-3" href="{{route('admin.food.view', $detail->food['id'])}}">
                                        <img class="img-fluid"
                                             src="{{asset('storage/app/public/product')}}/{{$detail->food['image']}}"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             alt="Image Description">
                                    </a>
                                @endif
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <strong> {{Str::limit($detail->food['name'], 20, '...')}}</strong><br>

                                                @if(count(json_decode($detail['variation'],true))>0)
                                                    <strong><u>{{__('Variation')}} : </u></strong>
                                                    @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                        <div class="font-size-sm text-body">
                                                            <span>{{$key1}} :  </span>
                                                            <span class="font-weight-bold">{{Str::limit($variation,15, '...')}}</span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                                                    @if($key2==0)<strong><u>{{__('Addons')}} : </u></strong>@endif
                                                    <div class="font-size-sm text-body">
                                                        <span>{{Str::limit($addon['name'],20,'...')}} :  </span>
                                                        <span class="font-weight-bold">
                                                            {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                                        </span>
                                                    </div>
                                                    @php($total_addon_price+=$addon['price']*$addon['quantity'])
                                                @endforeach
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h6>{{\App\CentralLogics\Helpers::format_currency($detail['price'])}}</h6>
                                            </div>
                                            <div class="col col-md-1 align-self-center">
                                                <h5>{{$detail['quantity']}}</h5>
                                            </div>

                                            <div class="col col-md-3 align-self-center text-right">
                                                @php($amount=($detail['price'])*$detail['quantity'])
                                                <h5>{{\App\CentralLogics\Helpers::format_currency($amount)}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php($product_price+=$amount)
                                @php($restaurant_discount_amount += ($detail['discount_on_food']*$detail['quantity']))
                            <!-- End Media -->
                                <hr>
                        
                        @elseif(isset($detail->item_campaign_id)  && $detail->status)
                        <?php
                            if(!$editing)
                            {
                                $detail->campaign = json_decode($detail->food_details, true);
                            }
                        ?>
                            <!-- Media -->
                                <div class="media">
                                    @if ($editing)
                                    <div class="avatar avatar-xl mr-3  cursor-pointer" onclick="quick_view_cart_item({{$key}})" title="{{__('click to edit this item')}}">
                                        <span class="avatar-status avatar-lg-status avatar-status-dark"><i class="tio-edit"></i></span>    
                                        <img class="img-fluid"
                                             src="{{asset('storage/app/public/campaign')}}/{{$detail->campaign['image']}}"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             alt="Image Description">
                                    </div>
                                    @else
                                    <a class="avatar avatar-xl mr-3" href="{{route('admin.campaign.view', ['item', $detail->campaign['id']])}}">
                                        <img class="img-fluid"
                                             src="{{asset('storage/app/public/campaign')}}/{{$detail->campaign['image']}}"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             alt="Image Description">
                                    </a>
                                    @endif


                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <strong> {{Str::limit($detail->campaign['name'],20,'...')}}</strong><br>

                                                @if(count(json_decode($detail['variation'],true))>0)
                                                    <strong><u>{{__('Variation')}} : </u></strong>
                                                    @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                        <div class="font-size-sm text-body">
                                                            <span>{{$key1}} :  </span>
                                                            <span class="font-weight-bold">{{Str::limit($variation, 20, '...')}}</span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                                                    @if($key2==0)<strong><u>{{__('Addons')}} : </u></strong>@endif
                                                    <div class="font-size-sm text-body">
                                                        <span>{{Str::limit($addon['name'],20, '...')}} :  </span>
                                                        <span class="font-weight-bold">
                                                            {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                                        </span>
                                                    </div>
                                                    @php($total_addon_price+=$addon['price']*$addon['quantity'])
                                                @endforeach
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h6>{{\App\CentralLogics\Helpers::format_currency($detail['price']) }}</h6>
                                            </div>
                                            <div class="col col-md-1 align-self-center">
                                                <h5>{{$detail['quantity']}}</h5>
                                            </div>

                                            <div class="col col-md-3 align-self-center text-right">
                                                @php($amount=($detail['price'])*$detail['quantity'])
                                                <h5>{{\App\CentralLogics\Helpers::format_currency($amount)}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php($product_price+=$amount)
                                @php($restaurant_discount_amount += ($detail['discount_on_food']*$detail['quantity']))
                            <!-- End Media -->
                                <hr>
                        @endif
                    @endforeach

                    <?php 
                        $coupon_discount_amount = $order['coupon_discount_amount'];

                        $total_price = $product_price + $total_addon_price - $restaurant_discount_amount - $coupon_discount_amount;
                    
                        $total_tax_amount= $order['total_tax_amount'];

                        if($editing)
                        {
                            $restaurant_discount = \App\CentralLogics\Helpers::get_restaurant_discount($order->restaurant);
                            if(isset($restaurant_discount))
                            {
                                if($product_price + $total_addon_price < $restaurant_discount['min_purchase'])
                                {
                                    $restaurant_discount_amount = 0;
                                }
                    
                                if($restaurant_discount_amount > $restaurant_discount['max_discount'])
                                {
                                    $restaurant_discount_amount = $restaurant_discount['max_discount'];
                                }
                            }
                            $coupon_discount_amount = $coupon ? \App\CentralLogics\CouponLogic::get_discount($coupon, $product_price + $total_addon_price - $restaurant_discount_amount) : $order['coupon_discount_amount']; 
                            $tax = $order->restaurant->tax;

                            $total_price = $product_price + $total_addon_price - $restaurant_discount_amount - $coupon_discount_amount;
                    
                            $total_tax_amount = ($tax > 0)?(($total_price * $tax)/100):0;  
                            
                            $total_tax_amount = round($total_tax_amount, 2);

                            $restaurant_discount_amount = round($restaurant_discount_amount, 2);

                            if($order->restaurant->free_delivery)
                            {
                                $del_c = 0;
                            }

                            $free_delivery_over = \App\Models\BusinessSetting::where('key', 'free_delivery_over')->first()->value;
                            if(isset($free_delivery_over))
                            {
                                if($free_delivery_over <= $product_price + $total_addon_price - $coupon_discount_amount - $restaurant_discount_amount)
                                {
                                    $del_c = 0;
                                }
                            }
                        }
                        else
                        {
                            $restaurant_discount_amount = $order['restaurant_discount_amount'];
                        }


                    ?>

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">{{__('Items price')}}:</dt>
                                    <dd class="col-sm-6">{{\App\CentralLogics\Helpers::format_currency($product_price)}}</dd>
                                    <dt class="col-sm-6">{{__('Addon cost')}}:</dt>
                                    <dd class="col-sm-6">
                                        {{\App\CentralLogics\Helpers::format_currency($total_addon_price)}}
                                        <hr>
                                    </dd>

                                    <dt class="col-sm-6">{{__('Subtotal')}}:</dt>
                                    <dd class="col-sm-6">
                                        {{\App\CentralLogics\Helpers::format_currency($product_price+$total_addon_price)}}</dd>
                                    <dt class="col-sm-6">{{__('Discount')}}:</dt>
                                    <dd class="col-sm-6">
                                        - {{\App\CentralLogics\Helpers::format_currency($restaurant_discount_amount)}}</dd>
                                    <dt class="col-sm-6">{{__('Coupon discount')}}:</dt>
                                    <dd class="col-sm-6">
                                        - {{\App\CentralLogics\Helpers::format_currency($coupon_discount_amount)}}</dd>
                                    <dt class="col-sm-6">{{__('vat/tax')}}:</dt>
                                    <dd class="col-sm-6">
                                        + {{\App\CentralLogics\Helpers::format_currency($total_tax_amount)}}</dd>
                                    <dt class="col-sm-6">{{__('Delivery fee')}}:</dt>
                                    <dd class="col-sm-6">
                                        + {{\App\CentralLogics\Helpers::format_currency($del_c)}}
                                        <hr>
                                    </dd>

                                    <dt class="col-sm-6">{{__('total')}}:</dt>
                                    <dd class="col-sm-6">{{\App\CentralLogics\Helpers::format_currency($product_price+$del_c+$total_tax_amount+$total_addon_price-$coupon_discount_amount - $restaurant_discount_amount)}}</dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                            @if($editing)
                            <div class="offset-sm-8 col-sm-4 d-flex justify-content-between">
                                <button class="btn btn-sm btn-danger" type="button" onclick="cancle_editing_order()">{{__('Cancel')}}</button>
                                <button class="btn btn-sm btn-primary" type="button" onclick="update_order()">{{__('Save')}}</button>
                            </div>
                            @endif
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                @if($order['order_type']!='take_away' && !$order->restaurant->self_delivery_system)
                <!-- Card -->
                <div class="card mb-2">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{__('Deliveryman')}}</h4>
                        @if($order->delivery_man && !isset($order->delivered) && !$order->restaurant->self_delivery_system)  
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            {{__('change')}}
                        </button>
                        @endif
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    
                    <div class="card-body">
                    @if($order->delivery_man)    
                        <a class="media align-items-center  deco-none" href="{{route('admin.delivery-man.preview',[$order->delivery_man['id']])}}">                            
                            <div class="avatar avatar-circle mr-3">
    
                                    <img class="avatar-img" style="width: 75px"
                                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                    src="{{asset('storage/app/public/delivery-man/'.$order->delivery_man->image)}}"
                                    alt="Image Description">
                            </div>
                            <div class="media-body">
                                <span class="text-body text-hover-primary">{{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}</span><br>
                                <span class="badge badge-ligh">{{$order->delivery_man->orders_count}} {{__('Orders delivered')}}</span>
                            </div>
                        </a>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{__('Contact info')}}</h5>
                        </div>

                        <ul class="list-unstyled list-unstyled-py-2">
                            <li>
                                <i class="tio-online mr-2"></i>
                                {{$order->delivery_man['email']}}
                            </li>
                            <li>
                                <a class="deco-none" href="tel:{{$order->delivery_man['phone']}}">
                                    <i class="tio-android-phone-vs mr-2"></i>
                                {{$order->delivery_man['phone']}}</a> 
                            </li>
                        </ul>

                        <hr>
                        @php($address=$order->dm_last_location)
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{__('Last location')}}</h5>
                        </div>
                        @if(isset($address))
                        <span class="d-block">
                            <a target="_blank"
                                href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$address['latitude']}}+{{$address['longitude']}}">
                                <i class="tio-map"></i> {{$address['location']}}<br>
                            </a>
                        </span>
                        @else
                        <span class="d-block text-lowercase qcont">
                            {{__('Location not found')}}
                        </span>
                        @endif
           
                    @else
                        <div class="w-100 text-center">
                            <div class="hs-unfold">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-lat='21.03' data-lng='105.85'>
                                    {{__('Assign delivery mam manually')}}
                                </button>
                            </div>
                        </div>
                    @endif    
                    </div>
                    
                <!-- End Body -->
                </div>
                <!-- End Card -->
                @endif
                <!-- Customer Card -->
                <div class="card mb-2">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{__('customer')}}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if($order->customer)
                        <div class="card-body">
     
                            <a class="media align-items-center deco-none" href="{{route('admin.customer.view',[$order->customer['id']])}}">    
                                <div class="avatar avatar-circle mr-3">
                                    
                                    <img class="avatar-img" style="width: 75px"
                                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                    src="{{asset('storage/app/public/profile/'.$order->customer->image)}}"
                                    alt="Image Description">

                                </div>
                                <div class="media-body">
                                    <span class="text-body text-hover-primary">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</span><br>
                                    <span class="badge badge-ligh">{{$order->customer->orders_count}} {{__('Orders')}} </span>
                                </div>
            
                            </a>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{__('Contact info')}}</h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online mr-2"></i>
                                    {{$order->customer['email']}}
                                </li>
                                <li>
                                    <a class="deco-none" href="tel:{{$order->customer['phone']}}">
                                        <i class="tio-android-phone-vs mr-2"></i>
                                        {{$order->customer['phone']}}
                                    </a>
                                </li>
                            </ul>

                            @if($order->delivery_address)
                                <hr>
                                @php($address=json_decode($order->delivery_address,true))
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{__('Delivery info')}}</h5>
                                    @if(isset($address))
                                        <a class="link" data-toggle="modal" data-target="#shipping-address-modal"
                                           href="javascript:">{{__('Edit')}}</a>
                                    @endif
                                </div>
                                @if(isset($address))
                                    <span class="d-block">
                                    {{__('Name')}}: {{$address['contact_person_name']}}<br>
                                    {{__('Contact')}}:<a class="deco-none" href="tel:{{$address['contact_person_number']}}"> {{$address['contact_person_number']}}</a><br>
                                    @if(isset($address['address']))
                                    @if(isset($address['latitude']) && isset($address['longitude']))
                                    <a target="_blank"
                                       href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$address['latitude']}}+{{$address['longitude']}}">
                                       <i class="tio-map"></i>{{$address['address']}}<br>
                                    </a>
                                    @else
                                       <i class="tio-map"></i>{{$address['address']}}<br>
                                    @endif

                                    @endif
                                </span>
                                @endif
                            @endif
                        </div>
                    @endif
                <!-- End Body -->
                </div>
                <!-- End Card -->
                <!-- Restaurant Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{__('Restaurant')}}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if($order->restaurant)
                    <div class="card-body">
                        <a class="media align-items-center deco-none" href="{{route('admin.vendor.view',[$order->restaurant['id']])}}">
                            <div class="avatar avatar-circle mr-3">
                                <img
                                    class="avatar-img" style="width: 75px"
                                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                    src="{{asset('storage/app/public/restaurant/'.$order->restaurant->logo)}}"
                                    alt="Image Description">
                            </div>
                            <div class="media-body">
                                <span class="text-body text-hover-primary text-break">{{$order->restaurant->name}}</span><br>
                                <span class="badge badge-ligh">{{$order->restaurant->orders_count}} {{__('Orders served')}}</span>
                            </div>
                        </a>
                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{__('Contact info')}}</h5>
                        </div>

                        <ul class="list-unstyled list-unstyled-py-2">
                            <li>
                                <i class="tio-online mr-2"></i>
                                {{$order->restaurant['email']}}
                            </li>
                            <li>
                                <a class="deco-none" href="tel:{{$order->restaurant['phone']}}">
                                    <i class="tio-android-phone-vs mr-2"></i>
                                    {{$order->restaurant['phone']}}
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <span class="d-block">
                            <a target="_blank"
                                href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$order->restaurant['latitude']}}+{{$order->restaurant['longitude']}}">
                                <i class="tio-map"></i> {{$order->restaurant['address']}}<br>
                            </a>
                        </span>
                    </div>
                    @endif
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="mySmallModalLabel">{{__('Reference code add')}}</h5>
                    <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                            aria-label="Close">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                </div>

                <form action="{{route('admin.order.add-payment-ref-code',[$order['id']])}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <!-- Input Group -->
                        <div class="form-group">
                            <input type="text" name="transaction_reference" class="form-control"
                                   placeholder="EX : Code123" required>
                        </div>
                        <!-- End Input Group -->
                        <button class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal -->
    <div id="shipping-address-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalTopCoverTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-top-cover bg-dark text-center">
                    <figure class="position-absolute right-0 bottom-0 left-0" style="margin-bottom: -1px;">
                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                             viewBox="0 0 1920 100.1">
                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                        </svg>
                    </figure>

                    <div class="modal-close">
                        <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal"
                                aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                      d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- End Header -->

                <div class="modal-top-cover-icon">
                    <span class="icon icon-lg icon-light icon-circle icon-centered shadow-soft">
                      <i class="tio-location-search"></i>
                    </span>
                </div>

                @if(isset($address))
                    <form action="{{route('admin.order.update-shipping',[$order['id']])}}"
                          method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Type')}}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control" name="address_type"
                                           value="{{$address['address_type']}}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Contact')}}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control" name="contact_person_number"
                                           value="{{$address['contact_person_number']}}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Name')}}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control" name="contact_person_name"
                                           value="{{$address['contact_person_name']}}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Address')}}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control" name="address"
                                           value="{{$address['address']}}"
                                           >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Latitude')}}
                                </label>
                                <div class="col-md-4 js-form-message">
                                    <input type="text" class="form-control" name="latitude"
                                           value="{{$address['latitude']}}"
                                           >
                                </div>
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{__('Longitude')}}
                                </label>
                                <div class="col-md-4 js-form-message">
                                    <input type="text" class="form-control" name="longitude"
                                           value="{{$address['longitude']}}" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">{{__('close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Dm assign Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('assign deliveryman')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 my-2">
                            <ul class="list-group overflow-auto" style="max-height:400px;">
                                @foreach ($deliveryMen as $dm)
                                    <li class="list-group-item"> 
                                        <span class="dm_list" role='button' data-id="{{$dm['id']}}">
                                            <img class="avatar avatar-sm avatar-circle mr-1" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'" src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}" alt="{{$dm['name']}}">
                                            {{$dm['name']}}
                                        </span>    

                                        <a class="btn btn-primary btn-xs float-right" onclick="addDeliveryMan({{$dm['id']}})">{{__('assign')}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-7 modal_body_map">
                            <div class="location-map" id="dmassign-map">
                                <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show locations on map Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="locationModalLabel">{{__('Location data')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 modal_body_map">
                            <div class="location-map" id="location-map">
                                <div style="width: 100%; height: 400px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    
    <div class="modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>
@endsection

@push('script_2')
    
    <script>
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var keyword= $('#datatableSearch').val();
            var nurl = new URL('{!!url()->full()!!}');
            nurl.searchParams.set('keyword', keyword);
            location.href = nurl;
        });
        
        function set_category_filter(id) {
            var nurl = new URL('{!!url()->full()!!}');
            nurl.searchParams.set('category_id', id);
            location.href = nurl;
        }

        function addon_quantity_input_toggle(e)
        {
            var cb = $(e.target);
            if(cb.is(":checked"))
            {
                cb.siblings('.addon-quantity-input').css({'visibility':'visible'});
            }
            else
            {
                cb.siblings('.addon-quantity-input').css({'visibility':'hidden'});
            }
        }

        function quick_view_cart_item(key) {
            $.get({
                url: '{{route('admin.order.quick-view-cart-item')}}',
                dataType: 'json',
                data: {
                    key: key,
                    order_id: '{{$order->id}}',
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function quickView(product_id) {
            $.get({
                url: '{{route('admin.order.quick-view')}}',
                dataType: 'json',
                data: {
                    product_id: product_id,
                    order_id: '{{$order->id}}',
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    console.log("success...")
                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function cartQuantityInitialize() {
            $('.btn-number').click(function (e) {
                e.preventDefault();

                var fieldName = $(this).attr('data-field');
                var type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function () {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                var name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cart',
                        text: 'Sorry, the minimum value was reached'
                    });
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cart',
                        text: 'Sorry, stock limit exceeded.'
                    });
                    $(this).val($(this).data('oldValue'));
                }
            });
            $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }

        function getVariantPrice() {
            if ($('#add-to-cart-form input[name=quantity]').val() > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.food.variant-price') }}',
                    data: $('#add-to-cart-form').serializeArray(),
                    success: function (data) {
                        $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                        $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                    }
                });
            }
        }

        function update_order_item(form_id = 'add-to-cart-form') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.order.add-to-cart') }}',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.data == 1) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cart',
                            text: "{{__('Product already Added in cart')}}"
                        });
                        return false;
                    } 
                    else if (data.data == 0) {
                        toastr.success('{{__('Product has been Added in cart')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        location.reload();
                        return false;
                    }
                    $('.call-when-done').click();

                    toastr.success('{{__('order updated successfully')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    location.reload();
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        }

        function removeFromCart(key) {
            Swal.fire({
                title: '{{__('Are you sure')}}',
                text: '{{__('You want to remove this order item')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{__('no')}}',
                confirmButtonText: '{{__('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post('{{ route('admin.order.remove-from-cart') }}', {_token: '{{ csrf_token() }}', key: key, order_id: '{{$order->id}}'}, function (data) {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            toastr.success('{{__('Item has been removed from cart')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            location.reload();
                        }

                    });
                }
            })

        }

        function edit_order()
        {
            Swal.fire({
                title: '{{__('Are you sure')}}',
                text: '{{__('You want to edit this order')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{__('no')}}',
                confirmButtonText: '{{__('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = '{{route('admin.order.edit', $order->id)}}';
                }
            })
        }

        function cancle_editing_order()
        {
            Swal.fire({
                title: '{{__('Are you sure')}}',
                text: '{{__('You want to cancel editing')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{__('no')}}',
                confirmButtonText: '{{__('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = '{{route('admin.order.edit', $order->id)}}?cancle=true';
                }
            })
        }

        function update_order()
        {
            Swal.fire({
                title: '{{__('Are you sure')}}',
                text: '{{__('You want to submit all changes for this order')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{__('no')}}',
                confirmButtonText: '{{__('yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = '{{route('admin.order.update', $order->id)}}';
                }
            })
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&v=3.45.8"></script>
    <script>
        function addDeliveryMan(id) {
            $.ajax({
                type: "GET",
                url: '{{url('/')}}/admin/order/add-delivery-man/{{$order['id']}}/' + id,
                success: function (data) {
                    location.reload();
                    console.log(data)
                    toastr.success('Successfully added', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                error: function (response) {
                    console.log(response);
                    toastr.error(response.responseJSON.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        function last_location_view() {
            toastr.warning('Only available when order is out for delivery!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
    <script>
        var deliveryMan = <?php echo(json_encode($deliveryMen)); ?>;
        var map = null;
        var myLatlng = new google.maps.LatLng({{$order->restaurant->latitude}}, {{$order->restaurant->longitude}});
        var dmbounds = new google.maps.LatLngBounds (null);
        var locationbounds = new google.maps.LatLngBounds (null);
        var dmMarkers = [];
        dmbounds.extend(myLatlng);
        locationbounds.extend(myLatlng);
        var myOptions = {
            center: myLatlng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,

            panControl: true,
            mapTypeControl: false,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            scaleControl: false,
            streetViewControl: false,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            }
        };
        function initializeGMap() {
            
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var infowindow = new google.maps.InfoWindow();

            var Restaurantmarker = new google.maps.Marker({
                position: new google.maps.LatLng({{$order->restaurant->latitude}}, {{$order->restaurant->longitude}}),
                map: map,
                title: "{{Str::limit($order->restaurant->name, 15, '...')}}",
                icon: "{{asset('public/assets/admin/img/restaurant_map.png')}}"
            });

            google.maps.event.addListener(Restaurantmarker, 'click', (function(Restaurantmarker) {
                return function() {
                    infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/restaurant/'.$order->restaurant->logo)}}'></div><div class='text-break' style='float:right; padding: 10px;'><b>{{Str::limit($order->restaurant->name, 15, '...')}}</b><br/> {{$order->restaurant->address}}</div>");
                    infowindow.open(map, Restaurantmarker);
                }
            })(Restaurantmarker));
            map.fitBounds(dmbounds);
            for (var i = 0; i < deliveryMan.length; i++) {                  
                if(deliveryMan[i].lat)
                {
                    // var contentString = "<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/delivery-man')}}/"+deliveryMan[i].image+"'></div><div style='float:right; padding: 10px;'><b>"+deliveryMan[i].name+"</b><br/> "+deliveryMan[i].location+"</div>";
                    var point = new google.maps.LatLng(deliveryMan[i].lat, deliveryMan[i].lng);
                    dmbounds.extend(point);
                    map.fitBounds(dmbounds);
                    var marker = new google.maps.Marker({
                        position: point,
                        map: map,
                        title: deliveryMan[i].location,
                        icon: "{{asset('public/assets/admin/img/delivery_boy_map.png')}}"
                    });
                    dmMarkers[deliveryMan[i].id]=marker;
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/delivery-man')}}/"+deliveryMan[i].image+"'></div><div style='float:right; padding: 10px;'><b>"+deliveryMan[i].name+"</b><br/> "+deliveryMan[i].location+"</div>");
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }

            };
        }
        $(document).ready(function() {

            // Re-init map before show modal
            $('#myModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                $("#dmassign-map").css("width", "100%");
                $("#map_canvas").css("width", "100%");
            });

            // Trigger map resize event after modal shown
            $('#myModal').on('shown.bs.modal', function() {
                initializeGMap();
                google.maps.event.trigger(map, "resize");
                map.setCenter(myLatlng);
            });

            
            function initializegLocationMap() {
                map = new google.maps.Map(document.getElementById("location_map_canvas"), myOptions);

                var infowindow = new google.maps.InfoWindow();
            
                @if($order->customer && isset($address))
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng({{$address['latitude']}}, {{$address['longitude']}}),
                    map: map,
                    title: "{{$order->customer->f_name}} {{$order->customer->l_name}}",
                    icon: "{{asset('public/assets/admin/img/customer_location.png')}}"
                });

                google.maps.event.addListener(marker, 'click', (function(marker) {
                    return function() {
                        infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/profile/'.$order->customer->image)}}'></div><div style='float:right; padding: 10px;'><b>{{$order->customer->f_name}} {{$order->customer->l_name}}</b><br/>{{$address['address']}}</div>");
                        infowindow.open(map, marker);
                    }
                })(marker));
                locationbounds.extend(marker.getPosition());
                @endif
                @if($order->delivery_man && $order->dm_last_location)
                var dmmarker = new google.maps.Marker({
                    position: new google.maps.LatLng({{$order->dm_last_location['latitude']}}, {{$order->dm_last_location['longitude']}}),
                    map: map,
                    title: "{{$order->delivery_man->f_name}}  {{$order->delivery_man->l_name}}",
                    icon: "{{asset('public/assets/admin/img/delivery_boy_map.png')}}"
                });

                google.maps.event.addListener(dmmarker, 'click', (function(dmmarker) {
                    return function() {
                        infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/delivery-man/'.$order->delivery_man->image)}}'></div><div style='float:right; padding: 10px;'><b>{{$order->delivery_man->f_name}}  {{$order->delivery_man->l_name}}</b><br/> {{$order->dm_last_location['location']}}</div>");
                        infowindow.open(map, dmmarker);
                    }
                })(dmmarker));
                locationbounds.extend(dmmarker.getPosition());
                @endif

                @if ($order->restaurant)
                var Retaurantmarker = new google.maps.Marker({
                    position: new google.maps.LatLng({{$order->restaurant->latitude}}, {{$order->restaurant->longitude}}),
                    map: map,
                    title: "{{Str::limit($order->restaurant->name, 15,'...')}}",
                    icon: "{{asset('public/assets/admin/img/restaurant_map.png')}}"
                });

                google.maps.event.addListener(Retaurantmarker, 'click', (function(Retaurantmarker) {
                    return function() {
                        infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/restaurant/'.$order->restaurant->logo)}}'></div><div style='float:right; padding: 10px;'><b>{{Str::limit($order->restaurant->name, 15, '...')}}</b><br/> {{$order->restaurant->address}}</div>");
                        infowindow.open(map, Retaurantmarker);
                    }
                })(Retaurantmarker));
                locationbounds.extend(Retaurantmarker.getPosition());
                @endif
                
                google.maps.event.addListenerOnce(map, 'idle', function() {
                    map.fitBounds(locationbounds);
                });
            }

            // Re-init map before show modal
            $('#locationModal').on('shown.bs.modal', function(event) {
                initializegLocationMap();
            });


            $('.dm_list').on('click', function() {
                var id = $(this).data('id');
                map.panTo(dmMarkers[id].getPosition());
                map.setZoom(13);
                dmMarkers[id].setAnimation(google.maps.Animation.BOUNCE);
                window.setTimeout(() => {
                    dmMarkers[id].setAnimation(null);
                }, 3);
            });
        })

    </script>
    
@endpush
