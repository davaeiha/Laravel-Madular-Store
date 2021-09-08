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
     * save notification settings for user
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        //validation
        $validatedData = $request->validate([
            'notification'=>['array'],
        ]);

        $notifications = Notification::all();

        //traverse collection of notification
        $notifications->each( function ($notification) use ($validatedData, $request) {
            //traverse collection of channels of a notification
            $notification->channels->each(function ($channel) use ($validatedData, $notification, $request) {
                //check settings already set in database
                if ($request->user()->checkNotificationChannel($notification,$channel)){
                    //check existence of a notification-channel request
                    if (!isset($validatedData['notification'][$notification->id][$channel->id])){
                        //detach data if a notification-channel is unchecked
                        $request->user()
                            ->notificationRelations()
                            ->where('notification_id',$notification->id)
                            ->wherePivot('channel_id',$channel->id)
                            ->detach($notification->id);
                    }
                }else{
                    //check existence of a notification-channel request
                    if(isset($validatedData['notification'][$notification->id][$channel->id])){
                        //attach data if a notification-channel is checked
                        $request->user()
                            ->notificationRelations()
                            ->attach($notification->id,['channel_id'=>$channel->id]);
                    }
                }
            });
        });
        //alert
        alert()->success('سیستم اعلان شما با موفقیت ثبت شد');
        //redirect back
        return back();

    }

}
