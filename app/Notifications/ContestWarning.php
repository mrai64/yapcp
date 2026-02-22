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
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $this->contestWaiting = $contestWaiting;
        $this->contest = $this->contestWaiting->contest;
        $this->section = $this->contestWaiting->section;
        $this->userWork = $this->contestWaiting->work;
        $this->participantUser = $this->contestWaiting->participantUser;

        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' contestWaiting:' . json_encode($this->contestWaiting));
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' contest:' . json_encode($this->contest));
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' section:' . json_encode($this->section));
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' userWork:' . json_encode($this->userWork));
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' participantUser:' . json_encode($this->participantUser));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return ['mail'];
    }

    /**
     * Alternative to add email col in ContestWaiting table
     */
    public function routeNotificationForMail(Notification $notification)
    {
        ds('Notification ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');

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
        ds('Notification '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $subject = config('app.name') . ' about your work "' . $this->userWork->title_en . '"';

        $mail_message = (new MailMessage())
            ->subject($subject)
            ->line($this->participantUser->first_name.', ')
            ->line('unfortunately your work titled ['.$this->userWork->title_en."], \nparticipating to our contest [".$this->contest->name_en."], \nseem have a little problem during a human check, and now it's temporary excluded from contest.")
            ->line("Because: \n".$this->contestWaiting->because."\n\n")
            ->line('At now suggest you to upload another version of your work ASAP, thru your personal dashboard, or contact Contest Organization.')
            ->line('Thank you for using our contest platform!');
        ds('Notification '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' mail_message:'.json_encode($mail_message));

        return $mail_message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     *
        public function toArray(object $notifiable): array
        {
            ds('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
            return [
                //
            ];
        }
     */
}
