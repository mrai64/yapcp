<?php

namespace App\Observers;

use App\Models\Organization;
use App\Models\UserRolesRoleSet; // Assumendo l'esistenza di un modello Role
use App\Models\UserRolesContextSet; // Assumendo l'esistenza di un modello Context
use App\Models\UserRole; // Assumendo l'esistenza di un modello UserRole per la tabella pivot
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrganizationObserver
{
    /**
     * Handle the Organization "after created" event.
     *
     * created, after. not creating, before.
     */
    public function created(Organization $organization): void
    {
        Log::info("OrganizationObserver: Metodo created attivato per l'organizzazione " . $organization->id);

        // Assicurati che un utente sia autenticato per assegnarlo come primo membro
        if (Auth::check()) {
            $user = Auth::user();

            try {
                // Trova l'ID del ruolo 'member'
                // $memberRole = UserRolesRoleSet::where('role', 'member')->firstOrFail();
                // Trova l'ID del contesto 'organization'
                // $organizationContext = UserRolesContextSet::where('context_type', 'organization')->firstOrFail();

                // Assegna l'utente autenticato come 'member' della nuova organizzazione
                UserRole::create([
                    'user_id' => $user->id,
                    'role' => 'member', // was: $memberRole->role,
                    'organization_id' => $organization->id, // L'ID della nuova organizzazione
                    // 'contest_id'      => null,
                    // federation_id
                    // datetime - role_opening
                    // datetime - role_closing
                ]);

                Log::info("User {$user->id} assigned as 'member' of new organization {$organization->id}.");

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::error("Failed to assign first member to organization {$organization->id}: Role or Context not found. Error: " . $e->getMessage());
            } catch (\Throwable $th) {
                Log::error("Failed to assign first member to organization {$organization->id} for user {$user->id}. Error: " . $th->getMessage());
            }
        } else {
            Log::warning("Organization {$organization->id} created without an authenticated user. No first member assigned.");
        }
    }

    /**
     * Handle the Organization "deleting" event.
     * Anticipa la cancellazione eliminando i record figli (UserRole).
     */
    public function deleting(Organization $organization): void
    {
        //
    }

    /**
     * Handle the Organization "deleted" event.
     */
    public function deleted(Organization $organization): void
    {
        //
    }

    /**
     * Handle the Organization "restored" event.
     */
    public function restored(Organization $organization): void
    {
        //
    }

    /**
     * Handle the Organization "force deleted" event.
     */
    public function forceDeleted(Organization $organization): void
    {
        //
    }
}
