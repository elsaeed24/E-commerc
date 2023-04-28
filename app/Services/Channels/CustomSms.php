<?php

namespace App\Services\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class CustomSms
{
    protected $baseUrl = 'https://api.twilio.com/2010-04-01/Accounts';

    protected $twilio_number ="+16076012842";

    public function send($notifiable, Notification $notification)
    {
        $config = config('services.custom-sms');

        // if (!method_exists($notifiable, 'routeNotificationForSms')) {
        //     throw new Exception('You must define method "routeNotificationForSms" in your notifiable model.');
        // }

        // $to = $notifiable->routeNotificationForSms($notification);
        // if (!$to) {
        //     throw new Exception('Empty mobile number');
        // }

        // if (!method_exists($notification, 'toSms')) {
        //     throw new Exception('You must define method "toSms" in your notification class.');
        // }
        // $message = $notification->toSms($notifiable);

      $response=  Http::baseUrl($this->baseUrl)
        ->withBasicAuth($config['account_sid'], $config['auth_token'])
        ->withHeaders([
              'Accept' => 'application/json',
          ]);

          return $response;
    }
}
