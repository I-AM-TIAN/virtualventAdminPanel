<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredencialesCorporativo extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $email,
        public string $password
    ) {
        //
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
            ->subject('Tus credenciales de acceso')
            ->greeting('¡Bienvenido!')
            ->line('Tu cuenta ha sido creada exitosamente.')
            ->line("**Correo:** {$this->email}")
            ->line("**Contraseña:** {$this->password}")
            ->line('Puedes iniciar sesión usando estos datos.')
            ->action('Iniciar sesión', url('/login'))
            ->line('Recuerda cambiar tu contraseña después de ingresar por primera vez.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
