<?php

/**
 * Send a notification for every userContact participant in contest
 *
 */

namespace App\Jobs;

use App\Models\Contest;
use App\Models\UserContact;
use App\Notifications\JuryResultsNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendJuryResultJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    public $contest;
    public $userContact;

    public function __construct(
        Contest $contest,
        UserContact $userContact
    ) {
        $this->contest = $contest;
        $this->userContact = $userContact;
    }
    //
    public function middleware(): array
    {
        return [new RateLimited('emails')];
    }
    //
    public function handle(): void
    {
        // Se il batch è stato cancellato, interrompi l'esecuzione del job
        if ($this->batch()->cancelled()) {
          //Log::info('SendJuryResultJob - batch cancelled.');
            return;
        }

        // Invia la notifica (che a sua volta ha 'mail' e 'database' nei canali)
        $this->userContact->notify(new JuryResultsNotification($this->contest, $this->userContact));
      //Log::info('SendJuryResultJob - notify for: ' . $this->contest->name_en . ' participant: ' . $this->userContact->first_name . ' ' . $this->userContact->last_name);
    }
}
