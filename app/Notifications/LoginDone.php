<?php

/**
 * User notification that a login was done
 */

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginDone extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $subject = (string) config('app.name').' security alert for '.$this->user->email;
        $mailMessage = (new MailMessage())
            ->subject($subject)
            ->line($this->user['name'].", we'd like to confirm some recent activity on your account.")
            ->line("If this activity is your own, or a co-worker's, then you can simply ignore this email.")
            ->line('If this seems odd, we recommend that you see what steps you can take in the event your account has been compromised or get in touch with our support team to report potentially malicious activity on your account.')
            ->line('Thank you for using our contest platform!')
            ->line('-- -- --')
            ->line("The information contained in this electronic message is intended only for the personal and confidential use of the recipients designated in the original message. The message may contain privileged and confidential information, or information of a proprietary nature. If you are not the intended recipient, or any agent responsible for delivering it to the intended recipient, you are hereby notified that you have received this document in error, and that any review, dissemination, printing, or copying of this message is strictly prohibited. If you have received this communication in error, please delete it immediately.");

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     *
     *
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
     *
     *
     */
}
