<?php
/**
 * Contest participant receive a warning
 * about a work excluded by a contest and
 * a "because"
 * 
 */
namespace App\Notifications;

use App\Models\ContestWaiting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ContestWarning extends Notification
{
    use Queueable,Notifiable;

    public $contest_waiting;
    public $contest;
    public $section;
    public $work;
    public $participant_user;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContestWaiting $contest_waiting)
    {
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
        $this->contest_waiting  = $contest_waiting;
        $this->contest          = $this->contest_waiting->contest;
        $this->section          = $this->contest_waiting->section;
        $this->work             = $this->contest_waiting->work;
        $this->participant_user = $this->contest_waiting->participant_user;
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' contest_waiting:' . json_encode( $this->contest_waiting) );
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' contest:' . json_encode( $this->contest) );
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' section:' . json_encode( $this->section) );
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' work:' . json_encode( $this->work) );
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' participant_user:' . json_encode( $this->participant_user) );

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
        return ['mail'];
    }

    /**
     * Alternative to add email col in ContestWaiting table
     */
    public function routeNotificationForMail(Notification $notification) 
    {
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
        return [$this->participant_user->email => ($this->participant_user->first_name.' '.$this->participant_user->last_name)];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
        $subject = env('APP_NAME') . ' about your work "' . $this->work->title_en .'"';
        
        $mail_message = (new MailMessage)
            ->subject( $subject )
            ->line($this->participant_user->first_name . ', ')
            ->line("unfortunately your work titled [" .  $this->work->title_en . "], \nparticipating to our contest [" . $this->contest->name_en . "], \nseem have a little problem during a human check, and now it's temporary excluded from contest.")
            ->line("Because: \n" . $this->contest_waiting->because . "\n\n")
            ->line("At now suggest you to upload another version of your work ASAP, thru your personal dashboard, or contact Contest Organization.")
            ->line('Thank you for using our contest platform!');
        Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' mail_message:' . json_encode($mail_message) );

        return $mail_message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     * 
        public function toArray(object $notifiable): array
        {
            Log::info('Notification '. __CLASS__ .' f/'. __FUNCTION__ .':'. __LINE__ .' called' );
            return [
                //
            ];
        }
     * 
     * 
     */
}
