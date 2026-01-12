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
use App\Models\Contest;
use App\Models\Federation;
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

        return Excel::download(new Fiaf2WorksExport($cid, $fid), 'fiaf_foto_partecipanti_ed_esiti.xlsx');
    }
}
