<?php

/**
 * Federation: FIAF
 * Report : Partecipanti e Ammessi
 */

namespace App\Exports;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\FederationMore;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Section[] $sections
 */

final class Fiaf1ParticipantsExport implements FromView
{
    // data to be passed to view
    protected string $contestId;

    protected string $federationId;

    protected $contest;

    protected $federationMores;

    protected $contestParticipants;

    protected $excelRows;

    // 1st: construct pick param then fill data for
    // TODO havying federationId in input, when more than a federationId is in contests.federation_list todo build a "loop_on" federatonId.
    // TODO Check for federationId == '' (no federation sponsor)
    public function __construct(string $cid, string $fid)
    {
        ds(__CLASS__ . ' f:' . __FUNCTION__ . ' cid:' . $cid . ' fid:' . $fid);
        $this->contestId = $cid;
        $this->federationId = $fid;

        // 1. 2. pick contest n contest_sections
        $this->contest = Contest::with(['sections' => function ($q) {
            $q->orderBy('code');
        }])->find($this->contestId);
        $contest = $this->contest;
        ds('contest for cid:' . $cid);
        ds($this->contest);

        // 3. more fields - which
        $this->federationMores = FederationMore::where('federation_id', $this->federationId)
            ->orderBy('field_name')
            ->get();
        ds('federationMores for:' . $fid);
        ds($this->federationMores);
        $federationMores = $this->federationMores;

        // the fab 4. eager loaders
        $this->contestParticipants = ContestParticipant::query()
            ->where('contest_id', $this->contestId)
            ->with([
                'contact',
                'works' => function ($q) use ($cid) {
                    $q->whereHas('section', fn ($s) => $s->where('contest_id', $cid))
                        ->select('id', 'user_id', 'section_id', 'is_admit');
                },
                'works.section:id,code',
                'contactMores' => function ($q) use ($fid) {
                    $q->where('federation_id', $fid);
                },
            ])
            ->get()
            ->keyBy('user_id');
        ds('contestParticipants for cid:' . $cid . ' & fid:' . $fid);
        ds($this->contestParticipants);

        // At last, the lego building blocks
        $this->excelRows = $this->contestParticipants->map(function ($participant) {

            // participants info - see view/blade
            $row = [
                'user_id' => $participant->user_id,
                'first_name' => $participant->contact->first_name,
                'last_name' => $participant->contact->last_name,
                'address' => $participant->contact->address,
                'postal_code' => $participant->contact->postal_code,
                'city' => $participant->contact->city,
                'region' => $participant->contact->region,
                'email' => $participant->contact->email,
                // ... others
            ];

            // number and admission number  / section
            $worksBySection = $participant->works->groupBy('section.code');

            foreach ($this->contest->sections as $section) {
                $works = $worksBySection->get($section->code, collect());

                $row["sez_{$section->code}_has"] = $works->count() ? 'S' : 'N'; // Y/N in italian 0 not participant >0 yes
                $row["sez_{$section->code}_admit"] = $works->sum('is_admit') ? $works->sum('is_admit') : ''; // void when 0
            }
            // $row["sez_{$section->code}_count"] = $works->count();
            // $row["sez_{$section->code}_admit"] = $works->sum('is_admit');

            // add federationMore fields
            $userValues = $participant->contactMores->pluck('field_value', 'field_name');

            foreach ($this->federationMores as $field) {
                // Set users value over default value
                $val = $userValues->get($field->field_name, $field->field_default_value);

                $row["fed_{$field->field_name}"] = $val;
            }

            return $row;
        });

        ds($this->excelRows);
    }

    // 2nd: fill the view and export
    public function view(): View
    {
        ds(__CLASS__ . ' f:' . __FUNCTION__);

        return view('livewire.contest.report.fiaf1-participants', [
            'contest' => $this->contest,
            'excelRows' => $this->excelRows,
        ]);
    }
}
