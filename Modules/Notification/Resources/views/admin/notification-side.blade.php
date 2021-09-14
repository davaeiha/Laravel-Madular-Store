@canany(['show-notifications','show-channels'])
    <li class="nav-item has-treeview {{ isActive(["admin.notifications.index","admin.channels.index"],"menu-open") }}">
        <a href="#" class="nav-link {{isActive(["admin.notifications.index","admin.channels.index"])}}">
            <i class="nav-icon fa fa-users"></i>
            <p>
                مدیریت اعلان ها
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('show-notifications')
                <li class="nav-item">
                    <a href="{{route("admin.notifications.index")}}" class="nav-link {{ isActive(["admin.notifications.index"])}}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>اعلان</p>
                    </a>
                </li>
            @endcan
            @can("show-channels")
                <li class="nav-item">
                    <a href="{{route("admin.channels.index")}}" class="nav-link {{ isActive(["admin.channels.index"])}}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>کانال ارتباطی</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
