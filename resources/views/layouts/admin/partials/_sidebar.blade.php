<style>
    .nav-sub{
        background: #334257!important;
    }
</style>

<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                @php($restaurant_logo=\App\Models\BusinessSetting::where(['key'=>'logo'])->first()->value)
                <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                    <img class="navbar-brand-logo" style="max-height: 55px; border-radius: 8px;max-width: 100%!important;"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}"
                         alt="Logo">
                    <img class="navbar-brand-logo-mini" style="max-height: 55px; border-radius: 8px;max-width: 100%!important;"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content" style="background-color: #334257;">
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('admin')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('admin.dashboard')}}" title="{{__('Dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{__('Dashboard')}}
                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->

                    <!-- Orders -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('order'))
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{__('Order section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/order*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('Order')}}">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Orders')}} 
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/order*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/order/list/pending')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['pending'])}}"
                                       title="{{__('Pending orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('Pending')}} 
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Models\Order::Pending()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/order/list/accepted')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['accepted'])}}"
                                       title="{{__('AcceptedbyDM')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('Accepted')}}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                            {{\App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/processing')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['processing'])}}"
                                       title="{{__('preparing In Restaurants')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('Processing')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Models\Order::Preparing()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/food_on_the_way')?'active':''}}">
                                    <a class="nav-link text-capitalize"
                                       href="{{route('admin.order.list',['food_on_the_way'])}}"
                                       title="{{__('food On The Way')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('Foods on the way')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Models\Order::FoodOnTheWay()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/delivered')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['delivered'])}}"
                                       title="{{__('Delivered')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('Delivered')}}
                                            <span class="badge badge-success badge-pill ml-1">
                                            {{\App\Models\Order::Delivered()->Notpos()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/canceled')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['canceled'])}}"
                                       title="{{__('Canceled')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('Canceled')}}
                                            <span class="badge badge-soft-warning bg-light badge-pill ml-1">
                                            {{\App\Models\Order::Canceled()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/failed')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['failed'])}}"
                                       title="{{__('Payment failed')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">
                                        {{__('Payment failed')}}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            {{\App\Models\Order::failed()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/refunded')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['refunded'])}}"
                                       title="{{__('Refunded')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('Refunded')}}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            {{\App\Models\Order::Refunded()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/order/list/scheduled')?'active':''}}">
                                    <a class="nav-link" href="{{route('admin.order.list',['scheduled'])}}"
                                       title="{{__('Scheduled')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('Scheduled')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::Scheduled()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/all')?'active':''}}">
                                    <a class="nav-link" href="{{route('admin.order.list',['all'])}}"
                                       title="{{__('all orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('All')}}
                                            <span class="badge badge-info badge-pill ml-1">
                                                {{\App\Models\Order::Notpos()->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Order dispachment -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/dispatch/*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('dispatch Management')}}">
                                <i class="tio-clock nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('dispatch Management')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/dispatch*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/dispatch/list/searching_for_deliverymen')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.dispatch.list',['searching_for_deliverymen'])}}"
                                       title="{{__('searching DM')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('searching DM')}}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Models\Order::SearchingForDeliveryman()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/dispatch/list/on_going')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.dispatch.list',['on_going'])}}"
                                       title="{{__('Ongoing orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('Ongoing orders')}}
                                                <span class="badge badge-soft-dark bg-light badge-pill ml-1">
                                                {{\App\Models\Order::Ongoing()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Order dispachment End-->
                    @endif
                <!-- End Orders -->

                    <!-- Restaurant -->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('restaurant section')}}">{{__('restaurant management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::module_permission_check('zone'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/zone*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.zone.home')}}" title="{{__('Zone')}}">
                                <i class="tio-city nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Delivery zone')}}                                </span>
                            </a>
                        </li>
                    @endif
                    @if(\App\CentralLogics\Helpers::module_permission_check('restaurant'))
                    <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/vendor*') && !Request::is('admin/vendor/withdraw_list'))?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                            href="javascript:" title="{{__('Vendor')}}"
                        >
                            <i class="tio-filter-list nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('restaurants')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{(Request::is('admin/vendor*') && !Request::is('admin/vendor/withdraw_list'))?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/add')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.vendor.add')}}"
                                title="{{__('register restaurant')}}"
                                >
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{__('Add restaurant')}}
                                    </span>
                                </a>
                            </li>

                            <li class="navbar-item {{Request::is('admin/vendor/list')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.vendor.list')}}"
                                title="{{__('restaurant list')}}"
                                >
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('restaurants')}} {{__('List')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('admin/vendor/bulk-import')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.bulk-import')}}"
                                    title="{{__('Bulk import')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{__('Bulk import')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('admin/vendor/bulk-export')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.bulk-export-index')}}"
                                    title="{{__('Bulk export')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{__('Bulk export')}}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    <!-- End Restaurant -->

                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('Food section')}}">{{__('Food management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- Category -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('category'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/category*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('Category')}} "
                            >
                                <i class="tio-category nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('categories')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/category*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/category/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="{{__('Category')}} ">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('Category')}} </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-category')}}"
                                       title="{{__('Sub category')}} ">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('Sub category')}} </span>
                                    </a>
                                </li>

                                {{--<li class="nav-item {{Request::is('admin/category/add-sub-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-sub-category')}}"
                                        title="add new sub sub category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">Sub-Sub-Category</span>
                                    </a>
                                </li>--}}
                                <li class="nav-item {{Request::is('admin/category/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.bulk-import')}}"
                                       title="{{__('Bulk import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/category/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.bulk-export-index')}}"
                                       title="{{__('Bulk export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk export')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- End Category -->

                    <!-- Attributes -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('attribute'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/attribute*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.attribute.add-new')}}" title="{{__('attributes')}}"
                            >
                                <i class="tio-apps nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Attributes')}}
                                </span>
                            </a>
                        </li>
                    @endif
                    <!-- End Attributes -->

                    <!-- AddOn -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('addon'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/addon*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('Addons')}}"
                            >
                                <i class="tio-add-circle-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('Addons')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/addon*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/addon/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.add-new')}}"
                                       title="{{__('Addon list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('List')}} </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/addon/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.bulk-import')}}"
                                       title="{{__('Bulk import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/addon/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.bulk-export-index')}}"
                                       title="{{__('Bulk export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk export')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                <!-- End AddOn -->
                    <!-- Food -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('food'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/food*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('Food')}}"
                            >
                                <i class="tio-premium-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('Foods')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/food*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/food/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.add-new')}}"
                                       title="{{__('Add new')}} ">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('Add new')}} </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.list')}}"
                                       title="{{__('Food list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('List')}} </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/reviews')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.reviews')}}"
                                       title="{{__('review list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('review')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.bulk-import')}}"
                                       title="{{__('Bulk import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.bulk-export-index')}}"
                                       title="{{__('Bulk export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('Bulk export')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                <!-- End Food -->
                <!-- DeliveryMan -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('deliveryman'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('Deliveryman section')}}">{{__('Deliveryman section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/add')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.add')}}"
                               title="{{__('Add delivery man')}}"
                            >
                                <i class="tio-running nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Add delivery man')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.list')}}"
                               title="{{__('Deliveryman list')}} "
                            >
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Deliverymen')}} 
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/reviews/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.reviews.list')}}" title="{{__('Reviews')}}"
                            >
                                <i class="tio-star-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Reviews')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End DeliveryMan -->
                    <!-- Marketing section -->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('Employee handle')}}">{{__('Marketing section')}} </small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <!-- Campaign -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('campaign'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/campaign*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('Campaign')}}"
                            >
                                <i class="tio-layers-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('campaigns')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/campaign*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('admin/campaign/basic/*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.campaign.list', 'basic')}}"
                                       title="{{__('Basic campaign')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('Basic campaign')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/campaign/item/*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.campaign.list', 'item')}}"
                                       title="{{__('item campaign')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('item campaign')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                <!-- End Campaign -->
                    <!-- Banner -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('banner'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/banner*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.banner.add-new')}}" title="{{__('banner')}}"
                            >
                                <i class="tio-image nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('banners')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Banner -->
                    <!-- Coupon -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('coupon'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/coupon*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.coupon.add-new')}}" title="{{__('coupon')}}"
                            >
                                <i class="tio-gift nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('coupons')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Coupon -->
                    <!-- Notification -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('notification'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/notification*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.notification.add-new')}}"
                               title="{{__('send notification')}}"
                            >
                                <i class="tio-notifications nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('push notification')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End Notification -->

                    <!-- End marketing section -->

                    <!-- Business Section-->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('Business section')}}">{{__('Business section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- withdraw -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('withdraw_list'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/withdraw*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.vendor.withdraw_list')}}"
                               title="{{__('restaurant withdraws')}}"
                            >
                                <i class="tio-table nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('restaurant withdraws')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End withdraw -->
                    <!-- account -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('account'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/account-transaction*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.account-transaction.index')}}"
                               title="{{__('collect cash')}}"
                            >
                                <i class="tio-money nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('collect cash')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End account -->

                    <!-- provide_dm_earning -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('provide_dm_earning'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/provide-deliveryman-earnings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.provide-deliveryman-earnings.index')}}"
                               title="{{__('Deliveryman earning_provide')}}"
                            >
                                <i class="tio-send nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('Deliveryman earning_provide')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End provide_dm_earning -->
                    <!-- Custommer -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('customerList'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.customer.list')}}" title="{{__('Customers')}}"
                            >
                                <i class="tio-poi-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Customers')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End Custommer -->

                    <!-- Business Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('business settings')}}">{{__('business settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/business-setup')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.business-setup')}}"
                               title="{{__('business setup')}}"
                            >
                                <span class="tio-settings nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('business setup')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/payment-method')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.payment-method')}}"
                               title="{{__('Payment methods')}}"
                            >
                                <span class="tio-atm nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('Payment methods')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/mail-config')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.mail-config')}}"
                               title="{{__('mail config')}}"
                            >
                                <span class="tio-email nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('mail config')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/sms-module')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.sms-module')}}"
                               title="{{__('sms module')}}">
                                <span class="tio-message nav-icon"></span>
                                <span class="text-truncate">{{__('sms module')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/fcm-index')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.fcm-index')}}"
                               title="{{__('push notification')}}">
                                <span class="tio-notifications nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('notification settings')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Business Settings -->

                    <!-- web & adpp Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('business settings')}}">{{__('Web and app settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/app-settings*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.app-settings')}}"
                               title="{{__('App settings')}}"
                            >
                                <span class="tio-android nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('App settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/landing-page-settings*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.landing-page-settings', 'index')}}"
                               title="{{__('Landing page settings')}}"
                            >
                                <span class="tio-website nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('Landing page settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/config*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.config-setup')}}"
                               title="{{__('Third party apis')}}"
                            >
                                <span class="tio-key nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('Third party apis')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/pages*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('pages setup')}}"
                            >
                                <i class="tio-pages nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('pages setup')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/business-settings/pages*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('admin/business-settings/pages/terms-and-conditions')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.terms-and-conditions')}}"
                                       title="{{__('Terms and condition')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('Terms and condition')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/privacy-policy')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.privacy-policy')}}"
                                       title="{{__('Privacy policy')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('Privacy policy')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/about-us')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.about-us')}}"
                                       title="{{__('About us')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('About us')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/file-manager*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.file-manager.index')}}"
                               title="{{__('Third party apis')}}"
                            >
                                <span class="tio-album nav-icon"></span>
                                <span
                                    class="text-truncate text-capitalize">{{__('gallery')}}</span>
                            </a>
                        </li>

                        {{--<li class="navbar-vertical-aside-has-menu {{Request::is('admin/social-login/view')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.social-login.view')}}">
                                <i class="tio-twitter nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('Social login')}}
                                </span>
                            </a>
                        </li>--}}

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/recaptcha*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.recaptcha_index')}}"
                                title="{{__('reCaptcha')}}">
                                <span class="tio-top-security-outlined nav-icon"></span>
                                <span class="text-truncate">{{__('reCaptcha')}}</span>
                            </a>
                        </li>

                    @endif
                <!-- End web & adpp Settings -->

                    <!-- Report -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('report'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('Report and analytics')}}">{{__('Report and analytics')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/day-wise-report')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.report.day-wise-report')}}"
                               title="{{__('Day wise report')}}">
                                <span class="tio-report nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('Day wise report')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/food-wise-report')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.report.food-wise-report')}}"
                               title="{{__('Food wise report')}}">
                                <span class="tio-report nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('Food wise report')}}</span>
                            </a>
                        </li>
                    @endif

                <!-- Employee-->

                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('Employee handle')}}">{{__('Employee section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::module_permission_check('custom_role'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.custom-role.create')}}"
                               title="{{__('Employee role')}}">
                                <i class="tio-incognito nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('Employee role')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(\App\CentralLogics\Helpers::module_permission_check('employee'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/employee*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:"
                               title="{{__('Employee')}}">
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('Employees')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/employee*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/employee/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.add-new')}}"
                                       title="{{__('Add new Employee')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('Add new')}} </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/employee/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.list')}}"
                                       title="{{__('Employee list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('List')}} </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                @endif
                <!-- End Employee -->


                    <li class="nav-item" style="padding-top: 100px">

                    </li>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>
