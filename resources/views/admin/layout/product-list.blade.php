<ul>
    @foreach($categories as $category)
        <li>{{$category->name}}</li>

        @include("admin.layout.product-list",["categories"=>$category->child])
    @endforeach
</ul>
