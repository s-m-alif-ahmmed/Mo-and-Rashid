<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public  $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user =  $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Verification Has Been Approved')
            ->markdown('backend.layouts.mail.VerificationApprovedMail', [
                'user' => $this->user,
            ]);
    }
}
