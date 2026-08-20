<?php

namespace App\Notifications;

use App\Models\UserWork;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public UserWork $userWork
    ) {
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
        return (new MailMessage())
            ->subject('Activity in your yaPCP Gallery')
            ->line('We would like to inform you that one of the works displayed in your gallery has just been updated.')
            ->line('Join yaPCP than see your Gallery.')
            ->line('Note: For security reasons, we have not included any clickable links in this message.')
            ->line('Thank you for using our application!');
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
