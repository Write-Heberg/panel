<?php

namespace Pterodactyl\Notifications;

use Pterodactyl\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MailTested extends Notification
{
    public function __construct(private User $user)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject('Message de test Pterodactyl')
            ->greeting('Bonjour ' . $this->user->name . ' !')
            ->line('Ceci est un test du système de messagerie de Pterodactyl. Tout fonctionne correctement !');
    }
}

