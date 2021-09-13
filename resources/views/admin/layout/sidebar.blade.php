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
                    @php
                        $orderedModules = \Nwidart\Modules\Facades\Module::getOrdered();
                        foreach ($orderedModules as $moduleName => $orderedModule){
                            if(\Nwidart\Modules\Facades\Module::isEnabled($moduleName)){
                                $enabeldOrderdModules[$moduleName]=$orderedModule;
                            }
                        }
                    @endphp
                    @foreach($enabeldOrderdModules as $enabledModule)
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
