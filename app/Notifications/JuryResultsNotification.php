<?php

/**
 * User Contest Result Notification
 *
 * for a single contest for a single contestParticipant (userContact)
 * pick the contestworks and list them in email
 *
 * Note: report only admit / not admit result and not
 *   award received
 *
 * mail markdown template:
 *
 */

namespace App\Notifications;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Models\UserContact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class JuryResultsNotification extends Notification
{
    use Queueable;

    public $userContact;
    public $contest;
    public $contestParticipant;
    public $contestWorks;

    /**
     * Create a new notification instance
     *
     * @param Contest $contest
     * @param userContact $userContact
     *
     */
    public function __construct(
        Contest $contest,
        UserContact $userContact
    ) {
        $this->contest = $contest;
        $this->userContact = $userContact;
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
      //Log::info('toMail started for: ' . $this->userContact->first_name . ' ' . $this->userContact->last_name);
        $this->contestParticipant = ContestParticipant::where('contest_id', $this->contest->id)
            ->where('user_contact_id', $this->userContact->id)
            ->get();
      //Log::info('toMail 2 for: ' . $this->userContact->first_name . ' ' . $this->userContact->last_name);
        $this->contestWorks = ContestWork::query()
            // join and sorted by
            ->join('contest_sections', 'contest_works.section_id', '=', 'contest_sections.id')
            ->where('contest_works.contest_id', $this->contest->id)
            ->where('contest_works.user_id', $this->userContact->id)
            ->where('contest_sections.contest_id', $this->contest->id)
            ->orderBy('contest_sections.code')
            ->orderBy('contest_works.portfolio_sequence')
            // select only fields from contest_works to avoid field name misunderstand
            ->select('contest_works.*')
            ->get();

      //Log::info('toMail 3 for: ' . $this->userContact->first_name . ' ' . $this->userContact->last_name);
      //Log::info('toMail Contestworks: ' . json_encode($this->contestWorks));

        $subject = (string) "[RESULTS] " . $this->contest->name_en;
        $mailMessage = (new MailMessage())
            ->subject($subject)
        //  ->line('check the site');
            // markdown template
            // resources/views/emails/contest-individual-result.blade.php
            ->markdown('emails.contest-individual-result', [
                'userContact'   => $this->userContact,
                'contest'       => $this->contest,
                'contestWorks'  => $this->contestWorks,
            ]);
      //Log::info('toMail 4 Mailmessage : ' . $this->userContact->first_name . ' ' . $this->userContact->last_name);
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contest_id' => $this->contest->id,
            'user_contact_id' => $this->userContact->id,
        ];
    }
}
