<?php

namespace App\Notifications;

use App\Models\Apply;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAppyNotification extends Notification
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
            ->subject('Votre candidature a été reçue')
            ->greeting('Bonjour ' . $notifiable->first_name . ' ' . $notifiable->last_name)
            ->line('Vous avez postulé à l’offre : ' . $this->apply->offer->title)
            ->line('Nous vous remercions pour votre candidature.')
            ->action('Voir l’offre', url('/jobs/' . $this->apply->offer->id))
            ->line('Bonne chance !')
            ->salutation('Cordialement, l’équipe E-Recruit.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
