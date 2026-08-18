<?php

namespace App\Jobs;

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationSection;
use App\Models\UserContactMore;
use App\Models\UserRole;
use App\Models\UserWorkMore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CascadeDeleteFederationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Federation $federation)
    {
    }

    public function handle(): void
    {
        // 1. Cancelliamo a lotti i dati correlati in UserWorkMore
        $this->federation->moreWorkFields()->withTrashed()->chunkById(100, function ($userWorkMoresSet) {
            foreach ($userWorkMoresSet as $userWorkMore) {
                $userWorkMore->delete();
            }
        });

        // 2. Cancelliamo a lotti i dati correlati in UserContactMore
        $this->federation->moreUserFields()->withTrashed()->chunkById(100, function ($userContactMoresSet) {
            foreach ($userContactMoresSet as $userContactMore) {
                $userContactMore->delete();
            }
        });

        // 3. Cancelliamo a lotti le definizioni dei campi extra in FederationMore
        $this->federation->moreFedFields()->withTrashed()->chunkById(100, function ($federationMoresSet) {
            foreach ($federationMoresSet as $federationMore) {
                $federationMore->delete();
            }
        });

        // 4. Cancelliamo a lotti le sezioni della federazione in FederationSection
        $this->federation->sections()->withTrashed()->chunkById(100, function ($sectionsSet) {
            foreach ($sectionsSet as $section) {
                $section->delete();
            }
        });

        // 5. Cancelliamo a lotti i ruoli utente associati alla federazione in UserRole
        $this->federation->userRoles()->withTrashed()->chunkById(100, function ($userRolesSet) {
            foreach ($userRolesSet as $userRole) {
                $userRole->delete();
            }
        });
    }
}
