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
                                class="nav-subtitle">{{__('messages.order')}} {{__('messages.section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/order*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.order')}}">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.orders')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/order*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/order/list/pending')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['pending'])}}"
                                       title="{{__('messages.pending')}} {{__('messages.orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.pending')}}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Models\Order::Pending()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/order/list/accepted')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['accepted'])}}"
                                       title="{{__('messages.acceptedbyDM')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('messages.accepted')}}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                            {{\App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/processing')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['processing'])}}"
                                       title="{{__('messages.preparingInRestaurants')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.processing')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Models\Order::Preparing()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/food_on_the_way')?'active':''}}">
                                    <a class="nav-link text-capitalize"
                                       href="{{route('admin.order.list',['food_on_the_way'])}}"
                                       title="{{__('messages.foodOnTheWay')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.foodOnTheWay')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Models\Order::FoodOnTheWay()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/delivered')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['delivered'])}}"
                                       title="{{__('messages.delivered')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('messages.delivered')}}
                                            <span class="badge badge-success badge-pill ml-1">
                                            {{\App\Models\Order::Delivered()->Notpos()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/canceled')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['canceled'])}}"
                                       title="{{__('messages.canceled')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('messages.canceled')}}
                                            <span class="badge badge-soft-warning bg-light badge-pill ml-1">
                                            {{\App\Models\Order::Canceled()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/failed')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['failed'])}}"
                                       title="{{__('messages.payment')}} {{__('messages.failed')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">
                                        {{__('messages.payment')}} {{__('messages.failed')}}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            {{\App\Models\Order::failed()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/refunded')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.order.list',['refunded'])}}"
                                       title="{{__('messages.refunded')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('messages.refunded')}}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            {{\App\Models\Order::Refunded()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/order/list/scheduled')?'active':''}}">
                                    <a class="nav-link" href="{{route('admin.order.list',['scheduled'])}}"
                                       title="{{__('messages.scheduled')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                        {{__('messages.scheduled')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::Scheduled()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/order/list/all')?'active':''}}">
                                    <a class="nav-link" href="{{route('admin.order.list',['all'])}}"
                                       title="{{__('messages.all')}} {{__('messages.orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.all')}}
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
                               href="javascript:" title="{{__('messages.dispatchManagement')}}">
                                <i class="tio-clock nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.dispatchManagement')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/dispatch*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/dispatch/list/searching_for_deliverymen')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.dispatch.list',['searching_for_deliverymen'])}}"
                                       title="{{__('messages.searchingDM')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.searchingDM')}}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Models\Order::SearchingForDeliveryman()->OrderScheduledIn(30)->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/dispatch/list/on_going')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.dispatch.list',['on_going'])}}"
                                       title="{{__('messages.ongoingOrders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{__('messages.ongoingOrders')}}
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
                               title="{{__('messages.restaurant')}} {{__('messages.section')}}">{{__('messages.restaurant')}} {{__('messages.management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::module_permission_check('zone'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/zone*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.zone.home')}}" title="{{__('messages.zone')}}">
                                <i class="tio-city nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.delivery_zone')}}                                </span>
                            </a>
                        </li>
                    @endif
                    @if(\App\CentralLogics\Helpers::module_permission_check('restaurant'))
                    <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/vendor*') && !Request::is('admin/vendor/withdraw_list'))?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                            href="javascript:" title="{{__('messages.vendor')}}"
                        >
                            <i class="tio-filter-list nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.restaurants')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{(Request::is('admin/vendor*') && !Request::is('admin/vendor/withdraw_list'))?'block':'none'}}">
                            <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/add')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.vendor.add')}}"
                                title="{{__('messages.register')}} {{__('messages.restaurant')}}"
                                >
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{__('messages.add')}} {{__('messages.restaurant')}}
                                    </span>
                                </a>
                            </li>

                            <li class="navbar-item {{Request::is('admin/vendor/list')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.vendor.list')}}"
                                title="{{__('messages.restaurant')}} {{__('messages.list')}}"
                                >
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.restaurants')}} {{__('list')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('admin/vendor/bulk-import')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.bulk-import')}}"
                                    title="{{__('messages.bulk_import')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{__('messages.bulk_import')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('admin/vendor/bulk-export')?'active':''}}">
                                <a class="nav-link " href="{{route('admin.vendor.bulk-export-index')}}"
                                    title="{{__('messages.bukl_export')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{__('messages.bulk_export')}}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    <!-- End Restaurant -->

                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('messages.food')}} {{__('messages.section')}}">{{__('messages.food')}} {{__('messages.management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- Category -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('category'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/category*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.category')}}"
                            >
                                <i class="tio-category nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.categories')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/category*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/category/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="{{__('messages.category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.category')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-category')}}"
                                       title="{{__('messages.sub_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.sub_category')}}</span>
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
                                       title="{{__('messages.bulk_import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/category/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.bulk-export-index')}}"
                                       title="{{__('messages.bukl_export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_export')}}</span>
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
                               href="{{route('admin.attribute.add-new')}}" title="{{__('messages.attributes')}}"
                            >
                                <i class="tio-apps nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.attributes')}}
                                </span>
                            </a>
                        </li>
                    @endif
                    <!-- End Attributes -->

                    <!-- AddOn -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('addon'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/addon*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.addons')}}"
                            >
                                <i class="tio-add-circle-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.addons')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/addon*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/addon/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.add-new')}}"
                                       title="{{__('messages.addon')}} {{__('messages.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.list')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/addon/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.bulk-import')}}"
                                       title="{{__('messages.bulk_import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/addon/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.addon.bulk-export-index')}}"
                                       title="{{__('messages.bukl_export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_export')}}</span>
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
                               href="javascript:" title="{{__('messages.food')}}"
                            >
                                <i class="tio-premium-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.foods')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/food*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/food/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.add-new')}}"
                                       title="{{__('messages.add')}} {{__('messages.new')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('messages.add')}} {{__('messages.new')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.list')}}"
                                       title="{{__('messages.food')}} {{__('messages.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.list')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/reviews')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.reviews')}}"
                                       title="{{__('messages.review')}} {{__('messages.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.review')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.bulk-import')}}"
                                       title="{{__('messages.bulk_import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/food/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.food.bulk-export-index')}}"
                                       title="{{__('messages.bukl_export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">{{__('messages.bulk_export')}}</span>
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
                                   title="{{__('messages.deliveryman')}} {{__('messages.section')}}">{{__('messages.deliveryman')}} {{__('messages.section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/add')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.add')}}"
                               title="{{__('messages.add_delivery_man')}}"
                            >
                                <i class="tio-running nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.add_delivery_man')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.list')}}"
                               title="{{__('messages.deliveryman')}} {{__('messages.list')}}"
                            >
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.deliverymen')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man/reviews/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.delivery-man.reviews.list')}}" title="{{__('messages.reviews')}}"
                            >
                                <i class="tio-star-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.reviews')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End DeliveryMan -->
                    <!-- Marketing section -->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('messages.employee_handle')}}">{{__('messages.marketing')}} {{__('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <!-- Campaign -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('campaign'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/campaign*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.campaign')}}"
                            >
                                <i class="tio-layers-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.campaigns')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/campaign*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('admin/campaign/basic/*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.campaign.list', 'basic')}}"
                                       title="{{__('messages.basic_campaign')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('messages.basic_campaign')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/campaign/item/*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.campaign.list', 'item')}}"
                                       title="{{__('messages.item')}} {{__('messages.campaign')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('messages.item')}} {{__('messages.campaign')}}</span>
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
                               href="{{route('admin.banner.add-new')}}" title="{{__('messages.banner')}}"
                            >
                                <i class="tio-image nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.banners')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Banner -->
                    <!-- Coupon -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('coupon'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/coupon*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.coupon.add-new')}}" title="{{__('messages.coupon')}}"
                            >
                                <i class="tio-gift nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.coupons')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Coupon -->
                    <!-- Notification -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('notification'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/notification*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.notification.add-new')}}"
                               title="{{__('messages.send')}} {{__('messages.notification')}}"
                            >
                                <i class="tio-notifications nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.push')}} {{__('messages.notification')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End Notification -->

                    <!-- End marketing section -->

                    <!-- Business Section-->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('messages.business')}} {{__('messages.section')}}">{{__('messages.business')}} {{__('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- withdraw -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('withdraw_list'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/vendor/withdraw*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.vendor.withdraw_list')}}"
                               title="{{__('messages.restaurant')}} {{__('messages.withdraws')}}"
                            >
                                <i class="tio-table nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.restaurant')}} {{__('messages.withdraws')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End withdraw -->
                    <!-- account -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('account'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/account-transaction*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.account-transaction.index')}}"
                               title="{{__('messages.collect')}} {{__('messages.cash')}}"
                            >
                                <i class="tio-money nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.collect')}} {{__('messages.cash')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End account -->

                    <!-- provide_dm_earning -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('provide_dm_earning'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/provide-deliveryman-earnings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.provide-deliveryman-earnings.index')}}"
                               title="{{__('messages.deliverymen_earning_provide')}}"
                            >
                                <i class="tio-send nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.deliverymen_earning_provide')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End provide_dm_earning -->
                    <!-- Custommer -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('customerList'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/customer*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.customer.list')}}" title="{{__('messages.customers')}}"
                            >
                                <i class="tio-poi-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.customers')}}
                                </span>
                            </a>
                        </li>
                    @endif
                <!-- End Custommer -->

                    <!-- Business Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.business')}} {{__('messages.settings')}}">{{__('messages.business')}} {{__('messages.settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/business-setup')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.business-setup')}}"
                               title="{{__('messages.business')}} {{__('messages.setup')}}"
                            >
                                <span class="tio-settings nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.business')}} {{__('messages.setup')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/payment-method')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.payment-method')}}"
                               title="{{__('messages.payment')}} {{__('messages.methods')}}"
                            >
                                <span class="tio-atm nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.payment')}} {{__('messages.methods')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/mail-config')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.mail-config')}}"
                               title="{{__('messages.mail')}} {{__('messages.config')}}"
                            >
                                <span class="tio-email nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.mail')}} {{__('messages.config')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/sms-module')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.sms-module')}}"
                               title="{{__('messages.sms')}} {{__('messages.module')}}">
                                <span class="tio-message nav-icon"></span>
                                <span class="text-truncate">{{__('messages.sms')}} {{__('messages.module')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/fcm-index')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.fcm-index')}}"
                               title="{{__('messages.push')}} {{__('messages.notification')}}">
                                <span class="tio-notifications nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.notification')}} {{__('messages.settings')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End Business Settings -->

                    <!-- web & adpp Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.business')}} {{__('messages.settings')}}">{{__('messages.web_and_app')}} {{__('messages.settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/app-settings*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.app-settings')}}"
                               title="{{__('messages.app_settings')}}"
                            >
                                <span class="tio-android nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.app_settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/landing-page-settings*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.landing-page-settings', 'index')}}"
                               title="{{__('messages.landing_page_settings')}}"
                            >
                                <span class="tio-website nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.landing_page_settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/config*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.config-setup')}}"
                               title="{{__('messages.third_party_apis')}}"
                            >
                                <span class="tio-key nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.third_party_apis')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/pages*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.pages')}} {{__('messages.setup')}}"
                            >
                                <i class="tio-pages nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.pages')}} {{__('messages.setup')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/business-settings/pages*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('admin/business-settings/pages/terms-and-conditions')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.terms-and-conditions')}}"
                                       title="{{__('messages.terms_and_condition')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.terms_and_condition')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/privacy-policy')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.privacy-policy')}}"
                                       title="{{__('messages.privacy_policy')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.privacy_policy')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/about-us')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.about-us')}}"
                                       title="{{__('messages.about_us')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.about_us')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/file-manager*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.file-manager.index')}}"
                               title="{{__('messages.third_party_apis')}}"
                            >
                                <span class="tio-album nav-icon"></span>
                                <span
                                    class="text-truncate text-capitalize">{{__('messages.gallery')}}</span>
                            </a>
                        </li>

                        {{--<li class="navbar-vertical-aside-has-menu {{Request::is('admin/social-login/view')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.social-login.view')}}">
                                <i class="tio-twitter nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.social_login')}}
                                </span>
                            </a>
                        </li>--}}

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/recaptcha*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.recaptcha_index')}}"
                                title="{{__('messages.reCaptcha')}}">
                                <span class="tio-top-security-outlined nav-icon"></span>
                                <span class="text-truncate">{{__('messages.reCaptcha')}}</span>
                            </a>
                        </li>

                    @endif
                <!-- End web & adpp Settings -->

                    <!-- Report -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('report'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.report_and_analytics')}}">{{__('messages.report_and_analytics')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/day-wise-report')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.report.day-wise-report')}}"
                               title="{{__('messages.day_wise_report')}}">
                                <span class="tio-report nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.day_wise_report')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/food-wise-report')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.report.food-wise-report')}}"
                               title="{{__('messages.food_wise_report')}}">
                                <span class="tio-report nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.food_wise_report')}}</span>
                            </a>
                        </li>
                    @endif

                <!-- Employee-->

                    <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('messages.employee_handle')}}">{{__('messages.employee')}} {{__('section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::module_permission_check('custom_role'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.custom-role.create')}}"
                               title="{{__('messages.employee')}} {{__('messages.Role')}}">
                                <i class="tio-incognito nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.employee')}} {{__('messages.Role')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(\App\CentralLogics\Helpers::module_permission_check('employee'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/employee*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:"
                               title="{{__('messages.Employee')}}">
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.employees')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/employee*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/employee/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.add-new')}}"
                                       title="{{__('messages.add')}} {{__('messages.new')}} {{__('messages.Employee')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('messages.add')}} {{__('messages.new')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/employee/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.list')}}"
                                       title="{{__('messages.Employee')}} {{__('messages.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.list')}}</span>
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
