@component("admin.layout.content",["title"=>"محصولات"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">محصولات</li>
        </ol>
    @endslot

    @slot('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            // set file link
            function fmSetLink($url) {
                document.getElementById('image_label').value = $url;
            }


        </script>

        <script>
            let changeAttributeValues = (event , id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers : {
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type' : 'application/json'
                    }
                })

                $.ajax({
                    type : 'POST',
                    url : '/admin/attribute/values',
                    data : JSON.stringify({
                        name : event.target.value
                    }),
                    success : function(data) {
                        valueBox.html(`
                            <option selected>انتخاب کنید</option>
                            ${
                            data.data.map(function (item) {
                                return `<option value="${item}">${item}</option>`
                            })
                        }
                        `);

                        $('.attribute-select').select2({ tags : true });
                    }
                });
            }

            let createNewAttr = ({ attributes , id }) => {
                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                 <label>عنوان ویژگی</label>
                                 <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                        <option value="" > انتخاب کنید</option>
                                    ${
                    attributes.map(function(item) {
                        return `<option value="${item}">${item}</option>`
                    })
                }
                                 </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                 <label>مقدار ویژگی</label>
                                 <select name="attributes[${id}][value]" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                 </select>
                            </div>
                        </div>
                         <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
            }

            $('#add_product_attribute').click(function() {
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length;

                attributesSection.append(
                    createNewAttr({
                        attributes : [],
                        id
                    })
                );

                $('.attribute-select').select2({ tags : true });
            });
        </script>
    @endslot

    <div class="card-header">
        <h3 class="card-title">ویرایش محصول</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.products.update",["product"=>$product->id])}}" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام محصول</label>

                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputName3" placeholder="نام محصول را وارد کنید" value="{{old('title',$product->title)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح محصول</label>
                <textarea class="form-control" name="description" id="inputName4" cols="30" rows="10" >{{old("description",$product->description)}}</textarea>
            </div>

            <div class="form-group">
                <label for="inputName5" class="col-sm-2 control-label">قیمت</label>

                <div class="col-sm-10">
                    <input type="number" name="price" class="form-control" id="inputName5" placeholder="قیمت محصول را وارد کنید" value="{{old("price",$product->price)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName6" class="col-sm-2 control-label">موجودی</label>

                <div class="col-sm-10">
                    <input type="number" name="inventory" class="form-control" id="inputName6" placeholder="تعداد کالای موجود در انبار" value="{{old('inventory',$product->inventory)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">آپلود تصویر شاخص</label>
                <div class="input-group">
                    <input type="text" id="image_label" class="form-control mb-2" name="image"
                           aria-label="Image" aria-describedby="button-image" dir="ltr" value="{{$product->image}}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب </button>
                    </div>
                </div>
                <hr>
                <img src="{{$product->image}}" class="w-25" alt="">
            </div>

            @php
                $categories =\Modules\CategoryProduct\Entities\Category::all();

                foreach($categories as $category){
                    if ($category->child->isEmpty()){
                        $lastLevelCategory[] = $category;
                    }
                }
            @endphp
            <div class="form-group">
                <label for="category"  class="col-sm-2 control-label">دسته بندی</label>
                <select name="category[]" id="category" class="form-control" multiple>
                    @foreach($lastLevelCategory as $category )
                        <option value="{{$category->id}}" name="{{$category->name}}" {{$product->categories->contains($category) ? "selected" : ""}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <h6>ویژگی های محصول</h6>
            <hr>
            <div id="attribute_section">
                @foreach($product->attributes as $productAttr)
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                <label>عنوان ویژگی</label>
                                <select  name="attributes[{{$productAttr->id}}-def][name]"
                                        class="attribute-select form-control">
                                    <option value="{{$productAttr->name}}" selected> {{$productAttr->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>مقدار ویژگی</label>
                                <select  name="attributes[{{$productAttr->id}}-def][value]"
                                        class="attribute-select form-control">
                                    @foreach($productAttr->values as $value)
                                        <option value="{{$value->value}}" {{\Nwidart\Modules\Facades\Module::productValue($productAttr)->id == $value->id ? 'selected' :''}} > {{$value->value}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-sm btn-danger" type="button" id="add_product_attribute">ویژگی جدید</button>
        </div>


        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ویرایش محصول</button>
            <a href="{{route("admin.products.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>

@endcomponent
