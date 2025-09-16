<?php
/**
 * User notification that a login was done
 * 
 */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginDone extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        Log::debug( __CLASS__ . ' ' . __FUNCTION__ . ' email:' . $user->email );
        Log::debug( __CLASS__ . ' ' . __FUNCTION__ . ' name:' . $user['name'] );
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
        $subject = (string) env('APP_NAME') . ' security alert for ' . $this->user->email;
        Log::debug( __CLASS__ . ' ' . __FUNCTION__ . ' subject:' . $subject );

        return (new MailMessage)
            ->subject( $subject )
            ->line($this->user['name'] . ', we\'d like to confirm some recent activity on your account.')
            ->line('If this activity is your own, or a co-worker\'s, then you can simply ignore this email.')
            ->line('If this seems odd, we recommend that you see what steps you can take in the event your account has been compromised or get in touch with our support team to report potentially malicious activity on your account.')
            ->line('Thank you for using our contest platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     * 
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
     * 
     */
}
