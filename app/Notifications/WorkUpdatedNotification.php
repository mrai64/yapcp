<?php

namespace App\Notifications;

use App\Models\UserWork;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Activity in yaPCP platform')
            ->line('We inform you that one of your works had updated now.')
            ->line('Join yaPCP than see your Gallery.')
            ->line('Thank you for using our application!');
            //->action('Join yaPCP than see your Gallery', route('user.work.listed1'))
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        //
        return [
            'user_work_id' => $this->userWork->id,
            'title_en' => $this->userWork->title_en,
            'is_monochromatic' => $this->userWork->is_monochromatic,
            'has_raw_file' => $this->userWork->has_raw_file,
        ];
    }
}
