<?php

/**
 * To generare userRoles to apply in test
 */

namespace Tests\Traits;

use App\Models\User;

trait HasTestRoles
{
    protected User $admin;
    protected User $juror;

    protected function setupRoles(): void
    {
        $this->admin = User::factory()->admin()->create();
        // $this->juror = User::factory()->juror()->create();
    }
}
