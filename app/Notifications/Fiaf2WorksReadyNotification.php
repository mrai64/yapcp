<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class Fiaf2WorksReadyNotification extends Notification
{
    use Queueable;

    protected string $filename;

    /**
     * Create a new notification instance.
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
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
        $downloadUrl = Storage::disk('public')->url('contest/'.$this->filename);

        return (new MailMessage)
            ->line('Work Done. Your waited report is ready to download.')
            ->action('Download report', $downloadUrl)
            ->line('The file will remain available even after downloading.')
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
