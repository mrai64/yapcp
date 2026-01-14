<?php

/**
 * Contest Report for federations
 *
 * Federation: FIAF | Federazione Italiana Associazioni Fotografiche - italian photographic societies federation
 * report: 1 People Participant Board w/ section resume
 *
 * cid: contests.id
 * fid: federations.id but fixed 'FIAF'
 */

namespace App\Jobs;

use App\Exports\Fiaf1ParticipantsExport;
use App\Models\User;
use App\Notifications\Fiaf1ParticipantsReadyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class Fiaf1ParticipantsExportJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 450; // 450 secs - 7:30 min

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $cid,
        protected string $fid,
        protected string $filename,
        protected string $userId
    ) {
        // all  in definition
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // prevent dir not found
        $directory = dirname($this->filename);
        if (! Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // build
        Excel::store(
            new Fiaf1ParticipantsExport($this->cid, $this->fid),
            'contests/'.$this->filename,
            'public'
        );

        // And... here we go! It's finished.
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new Fiaf1ParticipantsReadyNotification($this->filename));
        }
    }
}
