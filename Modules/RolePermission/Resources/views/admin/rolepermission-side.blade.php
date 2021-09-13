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
