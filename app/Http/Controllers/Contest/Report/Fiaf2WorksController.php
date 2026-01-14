<?php

/**
 * Contest report for federations
 *
 * federation: FIAF Italian Photographic societies federation
 * report: works and results
 */

namespace App\Http\Controllers\Contest\Report;

use App\Exports\Fiaf2WorksExport;
use App\Http\Controllers\Controller;
use App\Jobs\Fiaf2WorksExportJob;
use App\Models\Contest;
use App\Models\Federation;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Fiaf2WorksController extends Controller
{
    // called from route, call excel export
    public function exportFiaf2Works(string $cid, string $fid) // route
    {
        // zero trust - basic check
        if (Contest::where('id', $cid)->count() === 0) {
            abort(403);
        }
        if (Federation::where('id', $fid)->count() === 0) {
            abort(403);
        }

        /**
         * Direct download
         *
        return Excel::download(new Fiaf2WorksExport($cid, $fid), 'fiaf_foto_partecipanti_ed_esiti.xlsx');
         *
         **/

        /**
         * Call job to do
         * filename contains also path w/contest_id
         */
        $filename = $cid.'/report/'.'fiaf_foto_partecipanti_ed_esiti_ver_'.now()->timestamp.'.xlsx';
        ds($filename.' is running');

        // dispatch job with named arguments
        Fiaf2WorksExportJob::dispatch(
            cid: $cid,
            fid: $fid,
            filename: $filename,
            userId: Auth::id()
        );

        ds($filename.' is ready');

        // job asked
        return back()
            ->with('status', __('Writing the Report(s). Check your email for notification in a few minutes.'));
    }
}
