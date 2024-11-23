<?php

namespace Pterodactyl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddedToServer extends Notification implements ShouldQueue
{
    use Queueable;

    public object $server;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(array $server)
    {
        $this->server = (object) $server;
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
        return (new MailMessage())
            ->subject("Vous êtes sous utilisateur !")
            ->greeting('Bonjour !')
            ->line("Vous avez été ajouté en tant que sous-utilisateur pour le serveur ci-dessous, vous permettant d'avoir certains contrôles sur le serveur d'un client chez nous.")
            ->line("Merci de vous tournez directement vers le propiétaire du serveur afin de vous accordez plus d'autorisation au besoin sur son service.")
            ->line('Nom du serveur : ' . $this->server->name)
            ->line('Nous restons à votre disposition pour tout besoin ou assistance concernant vos services. N\'hésitez pas à nous contacter via les canaux de communication que nous mettons à votre disposition.')
            ->action('Visiter le serveur', url('/server/' . $this->server->uuidShort))
            ->line('Merci de nous faire confiance pour héberger votre projet !');
    }
}