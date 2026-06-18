<?php

namespace App\Jobs;

use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CascadeDeleteOrganizationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Organization $organization)
    {
    }

    public function handle(): void
    {
        // 1. Recuperiamo i contest dell'organizzazione (anche quelli già soft-deletati se necessario)
        // Usiamo chunkById per processarli a lotti in modo sicuro
        // prende dentro anche quelli già cancellati in precedenza
        $this->organization->contests()->withTrashed()->chunkById(100, function ($contestsSet) {
            foreach ($contestsSet as $contest) {

                // 2. Per ogni contest, cancelliamo a lotti i dati correlati più pesanti (es. i voti)
                // prende dentro anche quelli già cancellati in precedenza
                $contest->contestVotes()->withTrashed()->chunkById(500, function ($votesSet) {
                    foreach ($votesSet as $vote) {
                        $vote->delete(); // Soft-delete del voto
                    }
                });

                // 3. Cancelliamo a lotti le opere del concorso
                // prende dentro anche quelli già cancellati in precedenza
                $contest->contestWorks()->withTrashed()->chunkById(500, function ($contestWorksSet) {
                    foreach ($contestWorksSet as $contestWork) {
                        $contestWork->delete(); // Soft-delete dell'opera a concorso
                    }
                });

                // 4. Infine, facciamo il soft-delete del contest stesso
                $contest->delete();
            }
        });
    }
}
