<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAdminNotification extends Notification
{
    use Queueable;

    public  $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user  = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new verification submission has been received for user: ' . $this->user->name,
            'user_id' => $this->user->id,
            'user_email' => $this->user->email,
        ];
    }
}
