<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;

class ChannelController extends Controller
{
    public function __construct(){
        $this->middleware("can:show-channels")->only(["index"]);
        $this->middleware("can:edit-channel")->only(["edit","update"]);
        $this->middleware("can:create-channel")->only(["create","store"]);
        $this->middleware("can:delete-channel")->only(["destroy"]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $channels = Channel::paginate(10);
        return view('notification::admin.channels.all',compact('channels'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('notification::admin.channels.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        //validation
        $validatedData = $request->validate([
            'title'=>['required'],
            'description'=>['required'],
        ]);

        //create channel
        $channel = Channel::create([
            'title'=>$validatedData['title'],
            'description'=>$validatedData['description']
        ]);

        alert()->success('کانال ارتباطی مورد نظر با موفقیت ساخته شد.');

        return redirect(route('admin.channels.index'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param Channel $channel
     * @return Renderable
     */
    public function edit(Channel $channel): Renderable
    {
        return view('notification::admin.channels.edit',compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Channel $channel
     * @return string
     */
    public function update(Request $request, Channel $channel): string
    {
        $validatedData = $request->validate([
            'title'=>['required'],
            'description'=>['required'],
        ]);

        //update channel
        $channel->update([
            'title'=>$validatedData['title'],
            'description'=>$validatedData['description']
        ]);

        //alert user about what happened
        alert()->success('کانال ارتباطی مورد نظر با موفقیت ویرایش شد.');

        //redirecting
        return redirect(route('admin.channels.index'));

    }

    /**
     * Remove the specified resource from storage.
     * @param Channel $channel
     * @return RedirectResponse
     */
    public function destroy(Channel $channel): RedirectResponse
    {
        //delete channel
        $channel->delete();

        //alert
        alert()->success('کانال ارتباطی مورد نظر با موفقیت حذف شد.');

        //redirect back
        return back();
    }
}
