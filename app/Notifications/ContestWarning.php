<?php

/**
 * Contest participant receive a warning
 * about a userWork excluded by a contest and
 * a "because" from organization member
 *
 */

namespace App\Notifications;

use App\Models\ContestWaiting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class ContestWarning extends Notification
{
    use Notifiable;
    use Queueable;

    public $contestWaiting;

    public $contest;

    public $section;

    public $userWork;

    public $participantUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContestWaiting $contestWaiting)
    {
        // ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $this->contestWaiting = $contestWaiting;
        $this->contest   = $this->contestWaiting->contest;
        $this->section   = $this->contestWaiting->contestSection;
        $this->userWork  = $this->contestWaiting->userWork;
        $this->participantUser = $this->contestWaiting->participantUser;
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
     * Alternative to add email col in ContestWaiting table
     */
    public function routeNotificationForMail(Notification $notification)
    {
        return [$this->participantUser->email => (
            $this->participantUser->first_name . ' '
            . $this->participantUser->last_name
        )];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = config('app.name') . ' about your work "' . $this->userWork->title_en . '"';

        $mailMessage = (new MailMessage())
            ->subject($subject)
            ->line($this->participantUser->first_name . ', ')
            ->line('unfortunately your work titled')
            ->line($this->userWork->title_en)
            ->line("participating to our contest ")
            ->line($this->contest->name_en)
            ->line("appears to have encountered a minor issue during a manual review carried out by us, and has therefore been temporarily(!) excluded from the competition for the time being.")
            ->line("Because: \n" . $this->contestWaiting->because . "\n\n")
            ->line('We suggest you upload a new version of your entry as soon as possible, or contact us.')
            ->line('Thank you for the patience!');

        return $mailMessage;
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
     */
}
