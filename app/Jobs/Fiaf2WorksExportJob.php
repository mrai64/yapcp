<?php

/**
 * For the contest {cid} under federation {fid} "FIAF"
 * build excel report for works participant
 * with a timeout of 5 in instead of 0,5 min.
 */

namespace App\Jobs;

use App\Exports\Fiaf2WorksExport;
use App\Models\User;
use App\Notifications\Fiaf2WorksReadyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class Fiaf2WorksExportJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 450; // 450 sec - 7:30 min

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $cid,
        protected string $fid,
        protected string $filename,
        protected string $userId
    ) {
        // all is in definition
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

        // build - get the file content from export
        $export = new Fiaf2WorksExport($this->cid, $this->fid);
        $response = $export->download(basename($this->filename));

        // save the streamed content to disk
        $content = '';
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        // store file
        Storage::disk('public')->put('contests/'.$this->filename, $content);

        // And... here we go! It's finished.
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new Fiaf2WorksReadyNotification($this->filename));
        }
    }
}
