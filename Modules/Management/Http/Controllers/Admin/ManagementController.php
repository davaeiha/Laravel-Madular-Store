<?php

namespace Modules\Management\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Json;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $modules = Module::all();
        return view('management::admin.all',compact('modules'));
    }

    public function enable($moduleName): RedirectResponse
    {
        $module = Module::findOrFail($moduleName);
        $module->enable();
        $moduleInfo = new Json($module->getPath()."\Module.json");
        alert()->success(" ماژول{$moduleInfo->get('alias')} با موفقیت فعال شد ");
        return back();
    }


    public function disable($moduleName): RedirectResponse
    {
        $module = Module::findOrFail($moduleName);
        $module->disable();
        $moduleInfo = new Json($module->getPath()."\Module.json");
        alert()->success(" ماژول{$moduleInfo->get('alias')} با موفقیت فعال شد");
        return back();
    }
}
