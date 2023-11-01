<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $mail = new MailMessage;
            $mail->subject('Vérification de votre adresse e-mail');
            $mail->line('Veuillez cliquer sur le bouton ci-dessous afin de valider votre compte sur le système de gestion de matériel.');
            $mail->action('Valider mon compte', $url);
            $mail->line('Si vous n\'avez pas demandé la création d\'un compte, vous pouvez ignorer cet e-mail.');
            return $mail;
        });
    }
}
