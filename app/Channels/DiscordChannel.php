<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class DiscordChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDiscord($notifiable);

        $url = 'https://discordapp.com/api/webhooks/292860031940952064/i0J_apRBWX2tRHBzOTNF46Fp6tDF5Czn6P2zpeCV51nXWqn5kryjRDVMACLlwBt9xUx8';

        $guzzle = new Client();
        $res = $guzzle->request('POST', $url, [
            'json' => ['content' => $message]
        ]);

        return true;
    }
}