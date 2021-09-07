<?php

namespace Modules\Notification\Http\Controllers\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Notification\Entities\Channel;
use Modules\Notification\Entities\Notification;

class NotificationController extends Controller
{
    /**
     * show profile notification table
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $channels = Channel::all();
        $notifications = Notification::all();
        return view('notification::profile.notification',compact(['channels','notifications']));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        //validation
        $validatedData = $request->validate([
            'notification'=>['required','array'],
        ]);
        //TODO detach null checkbox from database
        //sync data in notification_user table in database
        collect($validatedData['notification'])->each(function ($channels,$notificationId) use ($request) {
            collect($channels)->each(function ($check,$channelId) use ($notificationId, $request){
                $request->user()->notificationRelations()->attach($notificationId,['channel_id'=>$channelId]);
            });
        });

        //alert
        alert()->success('سیستم اعلان شما با موفقیت ثبت شد');

        //redirect back
        return back();

    }

}
