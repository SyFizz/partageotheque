<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ResetPasswordNotification extends Notification
{
    use Queueable;

    private string $token;

    /**
     * Create a new notification instance.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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

        $url = url(config('app.url').route('password.reset', $this->token, false)) . '?email=' . urlencode($notifiable->email);

        return (new MailMessage)
                    ->subject('Réinitialisation de votre mot de passe')
                    ->line('Vous recevez cet e-mail parce que nous avons reçu une demande de réinitialisation du mot de passe de votre compte.')
                    ->action('Réinitialiser mon mot de passe', $url)
                    ->line('Ce lien de réinitialisation du mot de passe expirera dans 60 minutes.')
                    ->line('Si vous n\'avez pas demandé la réinitialisation de votre mot de passe, aucune autre action n\'est requise.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
