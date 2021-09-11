<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'Illuminate\\Auth\\Events\\Registered' => 
    array (
      0 => 'Illuminate\\Auth\\Listeners\\SendEmailVerificationNotification',
    ),
  ),
  'Modules\\Notification\\Providers\\EventServiceProvider' => 
  array (
    'Illuminate\\Auth\\Events\\Registered' => 
    array (
      0 => 'Modules\\Notification\\Listeners\\SetUserDefaultNotifySetting',
    ),
  ),
  'Modules\\OrderPayment\\Providers\\EventServiceProvider' => 
  array (
    'Modules\\OrderPayment\\Events\\Paid' => 
    array (
      0 => 'Modules\\OrderPayment\\Listeners\\SendSmsNotification',
      1 => 'Modules\\OrderPayment\\Listeners\\SendEmailNotification',
    ),
  ),
);