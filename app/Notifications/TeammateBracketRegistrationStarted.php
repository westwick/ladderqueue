<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Party;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TeammateBracketRegistrationStarted extends Notification implements ShouldQueue
{
    use Queueable;

    public $party;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Party $party)
    {
        $this->party = $party;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'partyId' => $this->party->id
        ];
    }

    public function toBroadcast($notifiable)
    {
        // need to load up associated player models
        $party = Party::with('players')->find($this->party->id);
        return new BroadcastMessage([
            'data' => [
                'party' => $party,
                'creator' => $this->party->creator
            ]
        ]);
    }
}
