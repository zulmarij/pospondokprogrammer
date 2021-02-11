<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $urlToResetForm = "http://localhost:8000/reset-password-form/?token=". $this->token;
        return (new MailMessage)
            ->subject(Lang::get('Pospro Mart - Token atur ulang kata sandi'))
            // ->greeting(lang::get('Assalamualaikum'))
            ->line(Lang::get('Jangan pernah memberikan token ini ke siapapun!'))
            ->action(Lang::get($this->token), $this->token)
            ->line(Lang::get('Gunakan token sebelum lewat :count menit.', ['count' => config('auth.passwords.users.expire')]));
            // ->line(Lang::get('If you did not request a password reset, no further action is required. Token: ==>'. $this->token));

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
