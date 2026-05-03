<?php

/**
 * Excel Export Report generate
 *
 * federation: FIAF Italian photographic societies federation | Federazione Italiana Associazioni Fotografiche
 * report: Foto partecipanti ed esiti
 */

namespace App\Exports;

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\Federation;
use App\Models\UserContact;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Fiaf2WorksExport
{
    // data for view
    protected string $contestId; //    cid

    protected string $federationId; // fid

    protected string $thisYear;

    protected $contest;
    protected UserContact $usercontact;
    protected $participantWorks;

    protected array $reportData;

    /**
     * Fill array for view
     */
    /**
     * instance Constructor
     *
     * @param string $cid contest id
     * @param string $fid federation id
     */
    public function __construct(string $cid, string $fid) // from controller
    {
        $contest = Contest::findOrFail($cid);
        $contestId = $cid;
        $this->contestId = $cid;

        $federation = Federation::findOrFail($fid);
        $federationId = $fid;
        $this->federationId = $fid;
        $this->thisYear = (string) date('Y');

        // contest n contest sections
        $this->contest = Contest::with(['sections' => function ($q) {
            $q->orderBy('code');
        }])->find($cid);

        // pick works participation and results
        $participantWorks = ContestWork::query()
            ->where('contest_works.contest_id', $cid)
            // Carichiamo tutte le relazioni necessarie (Eager Loading)
            ->with([
                'section', //                   contest_work->section - contest_section
                'userWork', //                  contest_work->userWork
                //                              contest_work->author - user_contact
                'author' => function ($query) {
                    $query->select('id', 'first_name', 'last_name', 'country_id');
                },
                'author.contactMores' => function ($query) use ($fid) {
                    $query->where('federation_id', $fid);
                },
            ])
            // join and sorted by
            ->join('user_contacts', 'contest_works.user_id', '=', 'user_contacts.id') // was: 'user_contacts.user_id')
            ->join('contest_sections', 'contest_works.section_id', '=', 'contest_sections.id')
            ->join('user_works', 'contest_works.work_id', '=', 'user_works.id')
            // awards
            ->leftJoin('contest_awards', function ($join) {
                $join->on('contest_works.work_id', '=', 'contest_awards.winner_work_id')
                    ->on('contest_works.section_id', '=', 'contest_awards.section_id');
            })
            ->orderBy('user_contacts.country_id')
            ->orderBy('user_contacts.last_name')
            ->orderBy('user_contacts.first_name')
            ->orderBy('contest_sections.code')
            ->orderBy('contest_works.portfolio_sequence')
            // select only fields from contest_works to avoid field name misunderstand
            ->select('contest_works.*', 'contest_awards.award_name AS award_title', 'user_contacts.last_name AS last_name', 'user_contacts.first_name AS first_name')
            ->get();

        // at last building map
        $reportData = $participantWorks->map(function ($row) {
            /** @var ContestWork&object{last_name: string, first_name: string, award_title: ?string} $row */

            // user_contact_more
            $mores = $row->author->contactMores ?? collect([]);  // data, or empty array
            // function over mores - ?defined for every call?
            $getMore = function ($fieldName) use ($mores) {
                $item = $mores->firstWhere('field_name', $fieldName);

                return $item ? $item->field_value : null; // value or default empty string
            };

            // excel_row
            return [
                'lastName'      => $row->last_name,
                'firstName'     => $row->first_name,
                'italianTaxId'  => $getMore('italianTaxId') ?? 'XXXXXXXXXXXXXXXX',
                'cardId'        => $getMore('cardId') ?? '000000',
                'distinction'   => $getMore('fiafDistinctions') ?? '$$$$$',
                'section'       => 'DIG', // dig | portfolio
                'theme_code'    => $row->section->code,
                'work_title'    => $row->userWork->title_en,
                'yof1st'        => $row->userWork->reference_year ?? $this->thisYear,
                'admit'         => $row->is_admit,
                'award'         => $row->award_title,
            ];
        })->all(); // map() collection to array
        $this->reportData = $reportData;
    }

    /**
     * Genera e scarica il file Excel usando PhpSpreadsheet.
     */
    public function download(string $filename): StreamedResponse
    {
        $html = view('livewire.contest.report.fiaf2-works', [
            'contest' => $this->contest,
            'patronage_code' => $this->contest->federation_list,
            'reportData' => $this->reportData,
        ])->render();

        $reader = new Html();
        $spreadsheet = $reader->loadFromString($html);

        return new StreamedResponse(function () use ($spreadsheet) {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
