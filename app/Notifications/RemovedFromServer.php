<?php

namespace Pterodactyl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RemovedFromServer extends Notification implements ShouldQueue
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
        ->error()
        ->subject("Vous avez été supprimé d'un serveur !")
        ->greeting('Bonjour !')
        ->line("Vous avez été supprimé en tant que sous-utilisateur du serveur ci-dessous, ce qui vous octroyait certains contrôles sur le serveur d'un client chez nous.")
        ->line("Malheuresement celui-ci a supprimé votre accès. Merci de vous tourner directement vers le propriétaire du serveur afin de restaurer votre accès à son service.")
        ->line('Nom du serveur : ' . $this->server->name)
        ->line('Nous restons à votre disposition pour tous vos besoins ou toute assistance concernant vos services. N\'hésitez pas à nous contacter via les canaux de communication que nous mettons à votre disposition.')
        ->line('Merci de nous faire confiance pour héberger votre projet !');
        
    }
}
