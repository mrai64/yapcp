<?php

namespace App\Observers;

use App\Models\UserContact;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserContactObserver
{
    /**
     * Handle the UserContact "created" event.
     *
     * We need not only creare a record but also a folder
     * to store user works. info:
     * <https://laravel.com/docs/12.x/filesystem>
     *
     */
    public function created(UserContact $userContact): void
    {
        $photoBox = $userContact->photoBox();
        try {
            if (!Storage::disk('public')->makeDirectory('/photos/'.$photoBox)) {
                throw new Exception("Creating user work folder");
            }
        } catch (\Throwable $th) {
            Log::error("Creating user works folder for id: {$userContact->id}, person: {$userContact->last_name}, {$userContact->first_name}", [
                'error' => $th->getMessage()
            ]);
            //
            throw $th;
        }
        //
        try {
            $anonPassportPhotoFile = '/photos/anon.jpg';
            $newPassportPhotoFile = '/photos/' . $photoBox . '/__passport_photo.jpg';
            Storage::disk('public')->copy($anonPassportPhotoFile, $newPassportPhotoFile);
            $newPassportPhotoFile = '/photos/' . $photoBox . '/300___passport_photo.jpg';
            Storage::disk('public')->copy($anonPassportPhotoFile, $newPassportPhotoFile);
            // shh update without observer
            $userContact->passport_photo = $photoBox . '/__passport_photo.jpg';
            $userContact->saveQuietly();
        } catch (\Throwable $th) {
            Log::error("Creating user anon passport photo for id: {$userContact->id}, person: {$userContact->last_name}, {$userContact->first_name}", [
                'error' => $th->getMessage()
            ]);
            //
            throw $th;
        }
    }

    /**
     * Handle the UserContact "updated" event.
     */
    public function updating(UserContact $userContact): void
    {
        // move old > new Photobox
        if ($userContact->isDirty('country_id') || $userContact->isDirty('last_name') || $userContact->isDirty('first_name')) {
            $oldPhotoBox = $userContact->getOriginal('passport_photo');
            $oldPhotoBox = Str::replace(
                search:'/__passport_photo.jpg',
                replace: '',
                subject: $oldPhotoBox,
                caseSensitive: false
            );
            $newPhotoBox = $userContact->photoBox();
            try {
                Storage::disk('public')->move('/photos/' . $oldPhotoBox, '/photos/' . $newPhotoBox);
                $userContact->passport_photo = $newPhotoBox . '/__passport_photo.jpg';
            } catch (\Throwable $th) {
                Log::error("moving old/new folder for id: {$userContact->id}, person: {$userContact->last_name}, {$userContact->first_name}", [
                    'error' => $th->getMessage()
                ]);
                //
                throw $th;
            }
        }
    }

    public function updated(UserContact $userContact): void
    {
        //
    }

    /**
     * Handle the UserContact "deleted" event.
     */
    public function deleted(UserContact $userContact): void
    {
        //
    }

    /**
     * Handle the UserContact "restored" event.
     */
    public function restored(UserContact $userContact): void
    {
        //
    }

    /**
     * Handle the UserContact "force deleted" event.
     */
    public function forceDeleted(UserContact $userContact): void
    {
        //
    }
}
