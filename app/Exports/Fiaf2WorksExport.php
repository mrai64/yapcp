<?php

/**
 * Excel Export Report generate
 *
 * federation: FIAF Italian photographic societes federation Federazione Italiana Associazioni Fotografiche
 * report: Foto partecipanti ed esiti
 */

namespace App\Exports;

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\Federation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Fiaf2WorksExport implements FromView
{
    // data for view
    protected string $contestId; //    cid

    protected string $federationId; // fid

    protected string $thisYear;

    protected $contest;

    protected $partecipazioni;

    protected $reportData;

    /**
     * Fill array for view
     */
    public function __construct(string $cid, string $fid) // from controller
    {
        set_time_limit(120);
        // zero trust
        if (Contest::where('id', $cid)->count() === 0) {
            abort(403);
        }
        $contestId = $cid;
        $this->contestId = $cid;

        if (Federation::where('id', $fid)->count() === 0) {
            abort(403);
        }
        $federationId = $fid;
        $this->federationId = $fid;
        $this->thisYear = date('Y');

        // contest n contest sections
        $this->contest = Contest::with(['sections' => function ($q) {
            $q->orderBy('code');
        }])->find($cid);

        // pick works participation and results
        $partecipazioni = ContestWork::query()
            ->where('contest_works.contest_id', $cid)
            // Carichiamo tutte le relazioni necessarie (Eager Loading)
            ->with([
                'section', //                     contest_work->section
                'work', //                        contest_work->work
                'author' => function ($query) { //contest_work->author
                    $query->select('user_id', 'first_name', 'last_name', 'country_id');
                },
                'author.contactMores' => function ($query) use ($fid) {
                    $query->where('federation_id', $fid);
                },
            ])
            // join and sorted by
            ->join('user_contacts', 'contest_works.user_id', '=', 'user_contacts.user_id')
            ->join('contest_sections', 'contest_works.section_id', '=', 'contest_sections.id')
            ->join('works', 'contest_works.work_id', '=', 'works.id')
            // awards
            ->leftJoin('contest_awards', function ($join) {
                $join->on('contest_works.work_id', '=', 'contest_awards.winner_work_id')
                    ->on('contest_works.section_id', '=', 'contest_awards.section_id');
            })
            ->orderBy('user_contacts.last_name')
            ->orderBy('user_contacts.first_name')
            ->orderBy('contest_sections.code')
            ->orderBy('contest_works.portfolio_sequence')
            // select only fields from contest_works to avoid field name misunderstand
            ->select('contest_works.*', 'contest_awards.award_name AS award_title', 'user_contacts.last_name AS last_name', 'user_contacts.first_name AS first_name')
            ->limit(36) // dbg
            ->get();

        // at last building map
        $reportData = $partecipazioni->map(function ($row) {

            // user_contact_more
            $mores = $row->author->contactMores ?? collect([]);  // data, or empty array
            // function over mores - ?defined for every call?
            $getMore = function ($fieldName) use ($mores) {
                $item = $mores->firstWhere('field_name', $fieldName);

                return $item ? $item->field_value : null; // value or default empty string
            };

            // excel_row
            return [
                'lastName' => $row->last_name,
                'firstName' => $row->first_name,
                'italianTaxId' => $getMore('italianTaxId') ?? 'XXXXXXXXXXXXXXXX',
                'cardId' => $getMore('cardId') ?? '000000',
                'distinction' => $getMore('fiafDistinctions') ?? '$$$$$',
                'section' => 'DIG', // dig | portfolio
                'theme_code' => $row->section->code,
                'work_title' => $row->work->title_en,
                'yof1st' => $row->work->reference_year ?? $this->thisYear,
                'admit' => $row->is_admit,
                'award' => $row->award_title,
            ];
        }); // map()
        $this->reportData = $reportData;

    } // __construct()

    /**
     * Build vew to pass as excel table
     *
     * @return void
     */
    public function view(): View
    {
        set_time_limit(120);

        return view('livewire.contest.report.fiaf2-works', [
            'contest' => $this->contest,
            'patronage_code' => $this->contest->federation_list,
            'reportData' => $this->reportData,
        ]);
    }
}
