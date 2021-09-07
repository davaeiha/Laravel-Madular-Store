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

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware("can:show-notifications")->only(["index"]);
        $this->middleware("can:edit-notification")->only(["edit","update"]);
        $this->middleware("can:create-notification")->only(["create","store"]);
        $this->middleware("can:delete-notification")->only(["destroy"]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $notifications = Notification::paginate(10);
        return view('notification::admin.notifications.all',compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $channels = Channel::all();
        return view('notification::admin.notifications.create',compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        //validation
        $validatedData = $request->validate([
            'title'=>['required'],
            'description'=>['required'],
            'channels'=>['required','array']
        ]);

        //create notification
        $notification = Notification::create([
            'title'=>$validatedData['title'],
            'description'=>$validatedData['description']
        ]);

        //create notification for notifications
        $notification->channels()->sync($validatedData['channels']);

        alert()->success('کانال ارتباطی مورد نظر با موفقیت ساخته شد.');

        return redirect(route('admin.notifications.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Notification $notification
     * @return Renderable
     */
    public function edit(Notification $notification): Renderable
    {
        $channels = Channel::all();
        return view('notification::admin.notifications.edit',compact(['notification','channels']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Notification $notification
     * @return string
     */
    public function update(Request $request, Notification $notification): string
    {
        $validatedData = $request->validate([
            'title'=>['required'],
            'description'=>['required'],
            'channels'=>['required','array']
        ]);

        //update channel
        $notification->update([
            'title'=>$validatedData['title'],
            'description'=>$validatedData['description']
        ]);

        //sync data with notifications
        $notification->channels()->sync($validatedData['channels']);

        //alert user about what happened
        alert()->success('کانال ارتباطی مورد نظر با موفقیت ویرایش شد.');

        //redirecting
        return redirect(route('admin.notifications.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        //delete channel
        $notification->delete();

        //alert
        alert()->success('کانال ارتباطی مورد نظر با موفقیت حذف شد.');

        //redirect back
        return back();
    }
}
