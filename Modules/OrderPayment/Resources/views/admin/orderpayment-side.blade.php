<li class="nav-item has-treeview {{ isActive(['admin.orders.index'] , 'menu-open') }}">
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
