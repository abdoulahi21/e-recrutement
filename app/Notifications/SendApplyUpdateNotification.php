<?php

namespace App\Notifications;

use App\Models\Apply;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendApplyUpdateNotification extends Notification
{
    public function __construct(Apply $apply)
    {
        $this->apply = $apply;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Mise à jour de votre candidature')
            ->greeting('Bonjour ' . $notifiable->first_name . ' ' . $notifiable->last_name)
            ->line('Votre candidature a été mise à jour.')
            ->line('Nous vous remercions pour votre patience.')
            ->action('Voir votre candidature', url('/jobs/' . $this->apply->offer->id))
            ->line('Cordialement, l’équipe E-Recruit.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
