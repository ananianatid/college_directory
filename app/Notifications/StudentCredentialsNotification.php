<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentCredentialsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vos identifiants Defitech')
            ->greeting("Bonjour {$notifiable->first_names},")
            ->line('Votre inscription à Defitech a été validée.')
            ->line('Voici vos identifiants pour accéder aux services numériques de l\'université :')
            ->line('**Email académique :** ' . $this->email)
            ->line('**Mot de passe temporaire :** ' . $this->password)
            ->action('Accéder au portail', url('/login'))
            ->line('Il est fortement conseillé de changer votre mot de passe lors de votre première connexion.')
            ->line('Cordialement,')
            ->line('L\'administration Defitech');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->email,
        ];
    }
}