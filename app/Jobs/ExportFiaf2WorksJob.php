<?php

/**
 * For the contest {cid} under federation {fid} "FIAF"
 * build excel report for works participant
 * with a timeout of 5 in instead of 0,5 min.
 */

namespace App\Jobs;

use App\Exports\Fiaf2WorksExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ExportFiaf2WorksJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300; // 300 sec - 5 min

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $cid,
        protected string $fid,
        protected string $filename
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // notify work in progress

        Excel::store(
            new Fiaf2WorksExport($this->cid, $this->fid),
            'contests/'.$this->cid.'/report/'.$this->filename,
            'public'
        );

        // notify work done
    }
}
