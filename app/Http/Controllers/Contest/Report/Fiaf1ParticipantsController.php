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

namespace App\Http\Controllers\Contest\Report;

use App\Http\Controllers\Controller;
use App\Jobs\Fiaf1ParticipantsExportJob;
use App\Models\Contest;
use App\Models\Federation;
use Illuminate\Support\Facades\Auth;

class Fiaf1ParticipantsController extends Controller
{
    //

    public function exportFiaf1Participants(string $cid, string $fid) // from route
    {
        if (Contest::where('id', $cid)->count() === 0) {
            abort(403);
        }
        if (Federation::where('id', $fid)->count() === 0) {
            abort(403);
        }
        $filename = $cid.'/report/'.'fiaf_partecipanti_ammissioni_ver_'.now()->timestamp.'.xlsx';

        // Take the wheel, Lara vel
        Fiaf1ParticipantsExportJob::dispatch(
            cid: $cid,
            fid: $fid,
            filename: $filename,
            userId: Auth::id()
        );

        ds($filename.' asked to Lara');

        return back()->with('status', __('Well, now writing the report.').__('Check your email for notification in a few minutes.'));
    }
}
