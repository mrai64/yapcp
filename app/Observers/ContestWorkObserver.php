<?php

/**
 * ContestWork Observer
 *
 * When UserWork became ContestWork,
 * When ContestWork is updated
 * When ContestWork is (soft)deleted
 *
 */

namespace App\Observers;

use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContestWorkObserver
{
    /**
     * Handle the ContestWork "created" event.
     */
    public function created(ContestWork $contestWork): void
    {
        //
        $contestId      = $contestWork->contest_id;
        $sectionId      = $contestWork->section_id;
        $contestWorkId  = $contestWork->id;
        // get original img
        $userWorkPath     = 'photos/' . $contestWork->userWork->file_path;  // extension is included
        $contestWorkPath  = 'contests/' . $contestId . '/' . $sectionId
            . '/' . $contestWorkId . '.' . $contestWork->userWork->file_format;
        Storage::disk('public')->makeDirectory('contests');
        Storage::disk('public')->makeDirectory('contests/' . $contestId);
        Storage::disk('public')->makeDirectory('contests/' . $contestId . '/' . $sectionId);
        Log::info("Required copy from: {$userWorkPath} to: {$contestWorkPath}");
        Storage::disk('public')->copy($userWorkPath, $contestWorkPath);
    }

    /**
     * Handle the ContestWork "updated" event.
     */
    public function updated(ContestWork $contestWork): void
    {
        //
    }

    /**
     * Handle the ContestWork "deleted" event.
     */
    public function deleted(ContestWork $contestWork): void
    {
        //
        $contestId      = $contestWork->contest_id;
        $sectionId      = $contestWork->section_id;
        $contestWorkId  = $contestWork->id;
        $contestWorkExt = $contestWork->userWork->file_format;
        $contestWorkPath  = 'contests/' . $contestId . '/' . $sectionId . '/' . $contestWorkId . '.' . $contestWork->userWork->file_format;
        Log::info("Required remove of: {$contestWorkPath}");
        Storage::disk('public')->delete($contestWorkPath);
    }

    /**
     * Handle the ContestWork "restored" event.
     */
    public function restored(ContestWork $contestWork): void
    {
        $this->created($contestWork);
    }

    /**
     * Handle the ContestWork "force deleted" event.
     */
    public function forceDeleted(ContestWork $contestWork): void
    {
        //
    }
}
