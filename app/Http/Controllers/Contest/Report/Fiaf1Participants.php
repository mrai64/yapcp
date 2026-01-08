<?php

/**
 * Contest report for federations
 *
 * federation: FIAF italian photographic societies federation
 * report: participants list
 */

namespace App\Http\Controllers\Contest\Report;

use App\Exports\ContestParticipantExport;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Federation;
use Maatwebsite\Excel\Facades\Excel;

class Fiaf1Participants extends Controller
{
    public string $contest_id;

    public $contest;

    public $federation_id;

    public $federation;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function export(string $cid, string $fid) // route
    {
        // basic check
        if (Contest::where('id', $cid)->count() === 0) {
            abort(403);
        }
        if (Federation::where('id', $fid)->count() === 0) {
            abort(403);
        }

        return Excel::download(new ContestParticipantExport($cid, $fid), 'fiaf_participants.xlsx');
    }
}
