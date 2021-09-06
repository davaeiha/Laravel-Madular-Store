<?php

namespace Modules\TwoFacAuth\Notifications\Channel;

use Kavenegar\KavenegarApi;
use Modules\TwoFacAuth\Notifications\ActiveCodeNotification;

class SMSChannel
{
    /**
     * @throws \Exception
     */
    public function send($notifiable, ActiveCodeNotification $notification){

        $data = $notification->toSMSChannel();
        try {
            $sender = "1000596446";
            $receptor = $data['receptor'];
            $message =$data['message'];
            $api = new KavenegarApi(config('twofacauth.kavenegar.api_key'));
            $api -> Send ( $sender,$receptor,$message);
        }catch (\Exception $e){
            throw $e;
        }

    }
}
