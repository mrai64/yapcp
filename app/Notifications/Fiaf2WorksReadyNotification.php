<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class Fiaf2WorksReadyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $filename)
    {
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
        // download
        // $downloadUrl = Storage::disk('public')->url('contests/'.$this->filename);
        $downloadUrl = asset('contests/'.$this->filename);

        return (new MailMessage())
            ->line('Work Done. Your waited report is ready to download.')
            ->line('Named: FIAF Foto Partecipanti ed Esiti.')
            ->action('Download report', $downloadUrl)
            ->line('The file will remain available even after downloading.')
            ->line('This URL address is to be considered personal and confidential and should not be distributed.')
            ->line('Thank you for using our application!');
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
