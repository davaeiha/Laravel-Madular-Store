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
