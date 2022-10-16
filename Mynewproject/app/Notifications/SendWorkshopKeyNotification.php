<?php

namespace App\Notifications;

use App\Workshop;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class SendWorkshopKeyNotification extends Notification
{
    use Queueable;
    public $workshop,$user;

    /**
     * Create a new notification instance.
     * @param Workshop $workshop
     * @param User $user
     *
     * @return void
     */
    public function __construct(Workshop $workshop, User $user)
    {
        $this->workshop = $workshop;
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Access the workshop using this key :' . $this->workshop->workshop_key .'.')
                    ->action('To enter the key...', route('participant', $this->user->id));
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
            //
        ];
    }
}
