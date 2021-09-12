<?php


use Illuminate\Support\Facades\Broadcast;
use Modules\OrderPayment\Entities\Payment;


/**
 *
 */
Broadcast::channel('payments.{paymentId}',function ($user, $paymentId){
    return $user->id === Payment::findOrFail($paymentId)->order()->user->id;
});
