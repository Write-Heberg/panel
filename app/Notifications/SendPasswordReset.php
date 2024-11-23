<?php

namespace Pterodactyl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendPasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(public string $token)
    {
    }

    /**
     * Récupère les canaux de diffusion de la notification.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Récupère la représentation de l'e-mail de la notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Réinitialisation du mot de passe')
            ->greeting('Bonjour !')
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->line("Vous trouverez donc ci-dessous un bouton vous permettant de réaliser l'opération demandée.")
            ->action('Réinitialiser le mot de passe', url('/auth/password/reset/' . $this->token . '?email=' . urlencode($notifiable->email)))
            ->line("Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action supplémentaire n'est nécessaire.")
            ->line('Merci de nous faire confiance pour héberger votre projet !');
    }
}