<?php

namespace Pterodactyl\Notifications;

use Pterodactyl\Models\User;
use Illuminate\Bus\Queueable;
use Pterodactyl\Events\Event;
use Pterodactyl\Models\Server;
use Illuminate\Container\Container;
use Pterodactyl\Events\Server\Installed;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pterodactyl\Contracts\Core\ReceivesEvents;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Notifications\Messages\MailMessage;

class ServerInstalled extends Notification implements ShouldQueue, ReceivesEvents
{
    use Queueable;

    public Server $server;
    public User $user;

    /**
     * Gère un appel direct à cette notification depuis l'événement d'installation du serveur. Cela est configuré
     * dans le fournisseur de services d'événements.
     */
    public function handle(Event|Installed $event): void
    {
        $event->server->loadMissing('user');

        $this->server = $event->server;
        $this->user = $event->server->user;

        // Puisque nous appelons cette notification directement depuis un écouteur d'événements, nous devons déclencher le dispatcher
        // pour envoyer l'e-mail maintenant. N'utilisez pas send() sinon vous déclencherez deux événements différents.
        Container::getInstance()->make(Dispatcher::class)->sendNow($this->user, $this);
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
        ->subject('Votre serveur est prêt')
        ->greeting('Bonjour ' . $this->user->name . "")
        ->line('Nous avons le plaisir de vous informer que votre serveur a terminé son installation et est maintenant prêt à être utilisé.')
        ->line('Nom de votre serveur : ' . $this->server->name)
        ->action('Se connecter et commencer à utiliser', route('index'))
        ->line('Nous restons à votre disposition pour tout besoin ou assistance concernant vos services. N\'hésitez pas à nous contacter via les canaux de communication que nous mettons à votre disposition.')
        ->line('Toute l\'équipe de Write Heberg\' vous remercie de nous faire confiance pour vous accompagner vers le succès de votre projet !');    
    }
}