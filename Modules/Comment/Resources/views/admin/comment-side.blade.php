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
