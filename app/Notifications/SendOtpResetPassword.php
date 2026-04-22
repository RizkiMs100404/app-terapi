<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpResetPassword extends Notification
{
    use Queueable;
    public $otp;
    /**
     * Create a new notification instance.
     */
    public function __construct($otp) {
    $this->otp = $otp;
}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable) {
    return ['mail'];
}

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) {
    return (new \Illuminate\Notifications\Messages\MailMessage)
        ->subject('Kode Verifikasi Reset Password - Sistem Terapi SLB')
        ->greeting('Halo!')
        ->line('Kami menerima permintaan reset password untuk akun Anda.')
        ->line('Berikut adalah kode OTP Anda:')
        ->line('**' . $this->otp . '**')
        ->line('Kode ini hanya berlaku selama 60 menit.')
        ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.');
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
