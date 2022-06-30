@extends('layouts.vendor.app')

@section('title', __('Food Preview'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="page-header-title text-break">{{$product['name']}}</h1>
                </div>
                <div class="col-6">
                    <a href="{{route('vendor.food.edit',[$product['id']])}}" class="btn btn-primary float-right">
                        <i class="tio-edit"></i> {{__('Edit')}}
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center">
                    <div class="col-md-auto mb-3 mb-md-0">
                        <div class="d-flex align-items-center">
                            <img class="avatar avatar-xxl avatar-4by3 mr-4"
                                 src="{{asset('storage/app/public/product')}}/{{$product['image']}}"
                                 onerror="this.src='data:image/svg+xml,%3Csvg%20width%3D%22344%22%20height%3D%22194%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cdefs%3E%3Cpath%20id%3D%22a%22%20d%3D%22M-1%200h344v194H-1z%22%2F%3E%3C%2Fdefs%3E%3Cg%20transform%3D%22translate(1)%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cmask%20id%3D%22b%22%20fill%3D%22%23fff%22%3E%3Cuse%20xlink%3Ahref%3D%22%23a%22%2F%3E%3C%2Fmask%3E%3Cuse%20fill%3D%22%23BDBDBD%22%20xlink%3Ahref%3D%22%23a%22%2F%3E%3Cg%20mask%3D%22url(%23b)%22%3E%3Cpath%20d%3D%22M173.65%2069.238L198.138%2027%20248%20112.878h-49.3c.008.348.011.697.011%201.046%200%2028.915-23.44%2052.356-52.355%2052.356C117.44%20166.28%2094%20142.84%2094%20113.924c0-28.915%2023.44-52.355%2052.356-52.355%2010%200%2019.347%202.804%2027.294%207.669zm0%200l-25.3%2043.64h50.35c-.361-18.478-10.296-34.61-25.05-43.64z%22%20fill%3D%22%23757575%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E'"
                                 alt="Image Description">
                            <div class="d-block">
                                <h4 class="display-2 text-dark mb-0">{{round($product->avg_rating,1)}}</h4>
                                <p> {{__('of')}} {{$product->reviews->count()}} {{__('Reviews')}}
                                    <span class="badge badge-soft-dark badge-pill ml-1"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <ul class="list-unstyled list-unstyled-py-2 mb-0">

                        @php($total=$product->rating?array_sum(json_decode($product->rating, true)):0)
                        <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                @php($five=$product->rating?json_decode($product->rating, true)[5]:0)
                                <span
                                    class="mr-3">5 {{__('star')}}</span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{$total==0?0:($five/$total)*100}}%;"
                                        aria-valuenow="{{$total==0?0:($five/$total)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3">{{$five}}</span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                @php($four=$product->rating?json_decode($product->rating, true)[4]:0)
                                <span class="mr-3">4 {{__('star')}}</span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{$total==0?0:($four/$total)*100}}%;"
                                        aria-valuenow="{{$total==0?0:($four/$total)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3">{{$four}}</span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                @php($three=$product->rating?json_decode($product->rating, true)[3]:0)
                                <span class="mr-3">3 {{__('star')}}</span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{$total==0?0:($three/$total)*100}}%;"
                                        aria-valuenow="{{$total==0?0:($three/$total)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3">{{$three}}</span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                @php($two=$product->rating?json_decode($product->rating, true)[2]:0)
                                <span class="mr-3">2 {{__('star')}}</span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{$total==0?0:($two/$total)*100}}%;"
                                        aria-valuenow="{{$total==0?0:($two/$total)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3">{{$two}}</span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                @php($one=$product->rating?json_decode($product->rating, true)[1]:0)
                                <span class="mr-3">1 {{__('star')}}</span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{$total==0?0:($one/$total)*100}}%;"
                                        aria-valuenow="{{$total==0?0:($one/$total)*100}}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3">{{$one}}</span>
                            </li>
                            <!-- End Review Ratings -->
                        </ul>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-4 pt-2">
                        <h4 class="border-bottom">{{$product['name']}}</h4>
                        <span>{{__('Price')}} :
                            <span>{{\App\CentralLogics\Helpers::format_currency($product['price'])}}</span>
                        </span><br>
                        <span>{{__('tax')}} :
                            <span>{{\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::tax_calculate($product,$product['price']))}}</span>
                        </span><br>
                        <span>{{__('Discount')}} :
                            <span>{{\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::discount_calculate($product,$product['price']))}}</span>
                        </span><br>
                        <span>
                            {{__('Available time starts')}} : {{date(config('timeformat'), strtotime($product['available_time_starts']))}}
                        </span><br>
                        <span>
                            {{__('Available time ends')}} : {{date(config('timeformat'), strtotime($product['available_time_ends']))}}
                        </span>
                        <h4 class="border-bottom mt-2"> {{__('Variations')}} </h4>
                        @foreach(json_decode($product['variations'],true) as $variation)
                            <span class="text-capitalize">
                              {{$variation['type']}} : {{\App\CentralLogics\Helpers::format_currency($variation['price'])}}
                            </span><br>
                        @endforeach
                        <h4 class="border-bottom mt-2"> Addons </h4>
                        @foreach(\App\Models\AddOn::whereIn('id',json_decode($product['add_ons'],true))->get() as $addon)
                            <span class="text-capitalize">
                              {{$addon['name']}} : {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                            </span><br>
                        @endforeach
                    </div>

                    <div class="col-8 pt-2 border-left">
                        <h4>{{__('Short description')}} : </h4>
                        <p>{{$product['description']}}</p>
                    </div>
                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
        @if(\App\CentralLogics\Helpers::get_restaurant_data()->reviews_section)
        <!-- Card -->
        <div class="card">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table"
                       data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0, 3, 6],
                        "orderable": false
                      }],
                     "order": [],
                     "info": {
                       "totalQty": "#datatableWithPaginationInfoTotalQty"
                     },
                     "search": "#datatableSearch",
                     "entries": "#datatableEntries",
                     "pageLength": 25,
                     "isResponsive": false,
                     "isShowPaging": false,
                     "pagination": "datatablePagination"
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th>{{__('reviewer')}}</th>
                        <th>{{__('review')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($reviews as $review)
                        <tr>
                            <td>
                                @if ($review->customer)
                                    <a class="d-flex align-items-center"
                                    href="{{route('admin.customer.view',[$review['user_id']])}}">
                                        <div class="avatar avatar-circle">
                                            <img class="avatar-img" width="75" height="75"
                                                onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                src="{{asset('storage/app/public/profile/'.$review->customer->image)}}"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3">
                                        <span class="d-block h5 text-hover-primary mb-0">{{$review->customer['f_name']." ".$review->customer['l_name']}} <i
                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                title="{{__('Verified Customer')}}"></i></span>
                                            <span class="d-block font-size-sm text-body">{{$review->customer->email}}</span>
                                        </div>
                                    </a>
                                @else
                                    {{__('Customer not found')}}
                                @endif

                            </td>
                            <td>
                                <div class="text-wrap" style="width: 18rem;">
                                    <div class="d-flex mb-2">
                                        <label class="badge badge-soft-info">
                                            {{$review->rating}} <i class="tio-star"></i>
                                        </label>
                                    </div>

                                    <p>
                                        {{$review['comment']}}
                                    </p>
                                </div>
                            </td>
                            <td>
                                {{date('d M Y '.config('timeformat'),strtotime($review['created_at']))}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-12">
                        {!! $reviews->links() !!}
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
        @endif
    </div>
@endsection