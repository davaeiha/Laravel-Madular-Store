<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link"></a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">محمد مهدی دعواییها</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{route("admin.")}}" class="nav-link {{isActive([".admin"])}}">
                            پنل مدیریت
                        </a>
                    </li>
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                    @can("show-users")
                        <li class="nav-item has-treeview {{ isActive(["admin.users.index","admin.users.create","admin.users.edit"],"menu-open") }}">
                            <a href="#" class="nav-link {{isActive(["admin.users.index","admin.users.create","admin.users.edit"])}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route("admin.users.index")}}" class="nav-link {{ isActive(["admin.users.index","admin.users.create","admin.users.edit"])}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @canany(['show-permissions','show-roles'])
                        <li class="nav-item has-treeview {{ isActive(["admin.permission.index","admin.roles.index"],"menu-open") }}">
                            <a href="#" class="nav-link {{isActive(["admin.permission.index","admin.roles.index"])}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    اجازه دسترسی
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('show-permissions')
                                    <li class="nav-item">
                                        <a href="{{route("admin.permission.index")}}" class="nav-link {{ isActive(["admin.permission.index"])}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه دسترسی ها</p>
                                        </a>
                                    </li>
                                @endcan
                                @can("show-roles")
                                    <li class="nav-item">
                                        <a href="{{route("admin.roles.index")}}" class="nav-link {{ isActive(["admin.roles.index"])}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه مقام</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['show-products','show-categories'])
                        <li class="nav-item has-treeview {{ isActive(["admin.products.index","admin.categories.index"],"menu-open") }}">
                            <a href="#" class="nav-link {{isActive(["admin.products.index","admin.categories.index"])}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                     محصولات و دسته بندی
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('show-products')
                                    <li class="nav-item">
                                        <a href="{{route("admin.products.index")}}" class="nav-link {{ isActive(["admin.products.index"])}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه محصولات</p>
                                        </a>
                                    </li>
                                @endcan
                                @can("show-categories")
                                    <li class="nav-item">
                                        <a href="{{route("admin.categories.index")}}" class="nav-link {{ isActive(["admin.categories.index"])}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه دسته بندی</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['show-comments'])
                        <li class="nav-item has-treeview {{ isActive(["admin.comments.index"],"menu-open") }}">
                            <a href="#" class="nav-link {{isActive(["admin.comments.index"])}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    نظرات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('show-products')
                                    <li class="nav-item">
                                        <a href="{{route("admin.comments.index")}}" class="nav-link {{ isActive(["admin.comments.index"])}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>نظرات محصولات</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    <li class="nav-item has-treeview {{ isActive(['admin.orders.index',] , 'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.orders.index']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                بخش سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'unpaid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'unpaid'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-warning"></i>
                                    <p>پرداخت نشده
                                        <span class="badge badge-warning right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('unpaid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'paid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'paid'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-info"></i>
                                    <p>پرداخت شده
                                        <span class="badge badge-info right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('paid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index'  , ['type' => 'preparation']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'preparation'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-primary"></i>
                                    <p>در حال پردازش
                                        <span class="badge badge-primary right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('preparation')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'posted']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'posted'])) }}">
                                    <i class="fa fa-circle-o nav-icon text text-light"></i>
                                    <p>ارسال شده
                                        <span class="badge badge-light right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('posted')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'received']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'received'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-success"></i>
                                    <p>دریافت شده
                                        <span class="badge badge-success right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('received')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'canceled']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'canceled'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-danger"></i>
                                    <p>کنسل شده
                                        <span class="badge badge-danger right">{{ \Modules\OrderPayment\Entities\Order::whereStatus('canceled')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @foreach(\Nwidart\Modules\Facades\Module::allEnabled() as $enabledModule)
                        @if(\Illuminate\Support\Facades\View::exists("{$enabledModule->getLowerName()}::admin.{$enabledModule->getLowerName()}-side"))
                            @include("{$enabledModule->getLowerName()}::admin.{$enabledModule->getLowerName()}-side")
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
