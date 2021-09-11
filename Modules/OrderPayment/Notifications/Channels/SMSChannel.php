<?php

namespace Modules\OrderPayment\Notifications\Channels;

use Kavenegar\KavenegarApi;
use Modules\OrderPayment\Notifications\PaidSmsNotification;

class SMSChannel
{
    /**
     * @throws \Exception
     */
    public function send($notifiable, PaidSmsNotification $notification){

        $data = $notification->toSMSChannel();
        try {
            $sender = "1000596446";
            $receptor = $data['receptor'];
            $message =$data['message'];
            $api = new KavenegarApi(config('orderpayment.kavenegar.api_key'));
            $api -> Send ( $sender,$receptor,$message);
        }catch (\Exception $e){
            throw $e;
        }

    }
}
