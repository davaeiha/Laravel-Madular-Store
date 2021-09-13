@component('admin.layout.content' , ['title' => 'لیست ماژول ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">مدیریت ماژول ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ماژول ها</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($modules as $module)

                            @php
                                $moduleInfo = new \Nwidart\Modules\Json($module->getPath()."\Module.json");
                            @endphp

                            @if(\Nwidart\Modules\Facades\Module::canDisable($module))
                                <div class="col-sm-2">

                                    <div class="mt-3">
                                        <h4>{{$moduleInfo->get('alias')}}</h4>
                                        <p>{{$moduleInfo->get('description')}}</p>
                                    </div>

                                    @if(\Nwidart\Modules\Facades\Module::isEnable($module->getName()))
                                        <form action="{{ route('admin.management.disable',['moduleName'=>$module->getName()])}}" method="post" id="disable-{{$module->getName()}}">
                                            @csrf
                                            @method('patch')
                                        </form>
                                        <button  class="btn btn-sm btn-danger" onclick="event.preventDefault();document.getElementById('disable-{{$module->getName()}}').submit()">غیر فعالسازی</button>
                                    @else
                                        <form action="{{ route('admin.management.enable',['moduleName'=>$module->getName()])}}" method="post" id="enable-{{$module->getName()}}">
                                            @csrf
                                            @method('patch')
                                        </form>
                                        <button  class="btn btn-sm btn-success" onclick="event.preventDefault();document.getElementById('enable-{{$module->getName()}}').submit()">فعالسازی</button>
                                    @endif

                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
