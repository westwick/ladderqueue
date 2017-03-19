<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class DiscordChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDiscord($notifiable);

        $url = 'https://discordapp.com/api/webhooks/293092709009457152/6T6c7abzi88xLtMmNR8h5HVsFwivZ9gBooEmYW0UrClqpc0KdgsF03u9qERU5Pjs1-w5';

        $guzzle = new Client();
        $res = $guzzle->request('POST', $url, [
            'json' => ['content' => $message]
        ]);

        return true;
    }
}