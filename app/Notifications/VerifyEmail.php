<?php

namespace Pterodactyl\Notifications;

use Pterodactyl\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    // Le constructeur de la classe qui reçoit les paramètres nécessaires à la notification
    public function __construct(private User $user, private string $name, private string $token)
    {
    }

    // Méthode via() qui indique les canaux de livraison de la notification, dans ce cas uniquement 'mail'
    public function via(): array
    {
        return ['mail'];
    }

    // Méthode toMail() qui retourne la représentation de l'e-mail de la notification
    public function toMail(): MailMessage
    {
        $message = new MailMessage();

        // Message de salutation personnalisé avec le nom d'utilisateur et le nom de l'application
        $message->greeting('Bonjour ' . $this->user->username . '! Bienvenue sur ' . $this->name . '.');

        // Ligne indiquant à l'utilisateur de cliquer sur le lien pour vérifier son adresse e-mail
        $message->line('Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse e-mail.');

        // Bouton d'action avec le texte "Vérifier l'e-mail" et le lien correspondant
        $message->action('Vérifier l\'e-mail', url('/auth/verify/' . $this->token));

        // Ligne indiquant à l'utilisateur de contacter l'application s'il n'a pas créé ce compte
        $message->line('Si vous n\'avez pas créé ce compte, veuillez contacter ' . $this->name . '.');

        // Retourne l'objet MailMessage contenant toutes les informations de l'e-mail
        return $message;
    }
}
