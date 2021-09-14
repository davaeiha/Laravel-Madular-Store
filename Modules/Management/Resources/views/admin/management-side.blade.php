@can('module-management')
    <li class="nav-item has-treeview {{ isActive(['admin.management',] , 'menu-open') }}">
        <a href="{{route("admin.management")}}" class="nav-link {{ isActive(['admin.management']) }}">
            <i class="nav-icon fa fa-users"></i>
            <p>
                مدیریت ماژول ها
            </p>
        </a>
    </li>
@endcan
