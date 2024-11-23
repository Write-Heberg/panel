<?php

namespace Pterodactyl\Notifications;

use Pterodactyl\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(public User $user, public ?string $token = null)
    {
    }

    /**
     * Obtient les canaux de livraison de la notification.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Obtient la représentation de l'e-mail de la notification.
     */
    public function toMail(): MailMessage
    {
        $message = (new MailMessage())
            ->subject("Bienvenue chez Write Heberg'")
            ->greeting('Bonjour ' . $this->user->name . "")
            ->line("Toute l'équipe vous souhaite la bienvenue sur nos infrastructures. Nous sommes heureux de vous informer que votre compte a été créé avec succès.")
            ->line('Voici le détail de vos informations de connexion :')
            ->line('Nom d\'utilisateur : ' . $this->user->username)
            ->line('Adresse e-mail : ' . $this->user->email)
            ->line('Merci de nous faire confiance pour héberger votre projet !')
            ->line('Pour commencer à utiliser vos services, veuillez configurer votre mot de passe en cliquant sur le bouton ci-dessous :');

        if (!is_null($this->token)) {
            $resetPasswordUrl = url('/auth/password/reset/' . $this->token . '?email=' . urlencode($this->user->email));

            $message->action('Configurer mon mot de passe', $resetPasswordUrl)
                ->line('Si vous n\'avez pas fait cette demande, vous pouvez ignorer cet e-mail.');

            $message->line('Le lien de réinitialisation du mot de passe expirera dans ' . config('auth.passwords.users.expire') . ' minutes.');
        }

        return $message;
    }
}