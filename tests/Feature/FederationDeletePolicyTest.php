<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use App\Models\Contest; // uncomment if Contest factory exists
use App\Models\Federation;
use App\Models\User;
use App\Models\UserRole;

class FederationDeletePolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Note: these tests are a scaffold outlining the expected behaviours.
     * Depending on the available model factories and route names in the
     * project you may need to adapt the factories creation and the route
     * used in the feature tests.
     */

    public function test_policy_allows_admin_when_no_active_contests()
    {
        $this->markTestIncomplete('Implement factories and FederationPolicy before running this test.');

        // Suggested flow once factories/policy exist:
        // 1. create user and assign admin role (active now)
        // 2. create a federation with no active contests
        // 3. assert Gate::forUser($user)->allows('delete', $federation)
    }

    public function test_policy_denies_admin_when_active_contests_present()
    {
        $this->markTestIncomplete('Implement factories and FederationPolicy before running this test.');

        // Suggested flow once factories/policy exist:
        // 1. create user and assign admin role
        // 2. create federation and attach/create an active contest for it
        // 3. assert Gate::forUser($user)->denies('delete', $federation)
    }

    public function test_non_admin_cannot_delete_even_with_no_active_contests()
    {
        $this->markTestIncomplete('Implement factories and FederationPolicy before running this test.');

        // 1. create regular user
        // 2. create federation with no active contests
        // 3. assert Gate::forUser($user)->denies('delete', $federation)
    }

    // Feature tests (controller) - scaffold
    public function test_delete_endpoint_returns_403_when_active_contests_exist()
    {
        $this->markTestIncomplete('Uncomment and adapt when route / controller exist.');

        // Example (adapt route name to your app):
        // $admin = User::factory()->create();
        // UserRole::create([...]); // assign admin role
        // $federation = Federation::factory()->create();
        // create active contest linked to $federation
        // $response = $this->actingAs($admin)->delete(route('federation.destroy', $federation));
        // $response->assertStatus(403);
    }

    public function test_delete_endpoint_deletes_when_no_active_contests()
    {
        $this->markTestIncomplete('Uncomment and adapt when route / controller exist.');

        // Example (adapt route name to your app):
        // $admin = User::factory()->create();
        // UserRole::create([...]); // assign admin role
        // $federation = Federation::factory()->create();
        // $response = $this->actingAs($admin)->delete(route('federation.destroy', $federation));
        // $response->assertStatus(204);
        // $this->assertSoftDeleted('federations', ['id' => $federation->id]);
    }
}
