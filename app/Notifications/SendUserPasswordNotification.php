<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUserPasswordNotification extends Notification
{
    public function __construct(public string $password)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre compte a été créé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre compte a été créé avec succès.')
            ->line('Email : ' . $notifiable->email)
            ->line('Mot de passe : ' . $this->password)
            ->line('Merci d’utiliser notre plateforme.')
            ->salutation('Cordialement, l’équipe E-Recruit.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
