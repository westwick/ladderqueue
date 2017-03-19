<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Channels\DiscordChannel;

class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'slack', DiscordChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //return (new MailMessage)
        //            ->line('The introduction to the notification.')
        //            ->action('Notification Action', url('/'))
        //            ->line('Thank you for using our application!');
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
            'username' => $this->user->name,
            'email' => $this->user->email
        ];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Ghost', ':ghost:')
            ->content($this->user->name . ' registered with email ' . $this->user->email);
    }

    public function toDiscord($notifiable)
    {
        return $this->user->name . ' registered with email ' . $this->user->email;
    }
}
