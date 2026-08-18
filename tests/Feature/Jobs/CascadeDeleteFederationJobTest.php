<?php

use App\Jobs\CascadeDeleteFederationJob;
use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationMoresReferencedSets;
use App\Models\FederationSection;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use App\Models\UserRole;
use App\Models\UserRolesRoleSet;
use App\Models\UserWork;
use App\Models\UserWorkMore;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    FederationMoresReferencedSets::firstOrCreate(['id' => 'user_contact_mores']);
    FederationMoresReferencedSets::firstOrCreate(['id' => 'user_works']);

    UserRolesRoleSet::firstOrCreate(['role' => 'secretary']);
    UserRolesRoleSet::firstOrCreate(['role' => 'inspector']);
});

test('cascade delete federation job soft deletes all related records', function () {
    $fedA = Federation::factory()->create(['id' => 'FEDA']);
    $fedB = Federation::factory()->create(['id' => 'FEDB']);

    $user = User::factory()->create();
    $userContact = UserContact::where('id', $user->id)->first() ?? UserContact::factory()->create(['id' => $user->id]);
    $userWork = UserWork::factory()->create(['user_id' => $user->id]);

    // 1. FederationSection
    $sectionA = FederationSection::factory()->create([
        'federation_id' => $fedA->id,
        'code' => 'OPENA',
    ]);
    $sectionB = FederationSection::factory()->create([
        'federation_id' => $fedB->id,
        'code' => 'OPENB',
    ]);

    // 2. FederationMore
    $fedMoreA = FederationMore::factory()->create([
        'federation_id' => $fedA->id,
        'referenced' => 'user_contact_mores',
        'field_name' => 'card_id_a',
        'field_label' => 'Card ID A',
    ]);
    $fedMoreB = FederationMore::factory()->create([
        'federation_id' => $fedB->id,
        'referenced' => 'user_contact_mores',
        'field_name' => 'card_id_b',
        'field_label' => 'Card ID B',
    ]);

    // 3. UserContactMore
    $ucMoreA = UserContactMore::create([
        'user_id' => $userContact->id,
        'federation_id' => $fedA->id,
        'field_name' => $fedMoreA->field_name,
        'field_value' => '12345',
    ]);
    $ucMoreB = UserContactMore::create([
        'user_id' => $userContact->id,
        'federation_id' => $fedB->id,
        'field_name' => $fedMoreB->field_name,
        'field_value' => '67890',
    ]);

    // 4. UserRole
    $userRoleA = UserRole::create([
        'user_id' => $user->id,
        'role' => 'secretary',
        'federation_id' => $fedA->id,
    ]);
    $userRoleB = UserRole::create([
        'user_id' => $user->id,
        'role' => 'secretary',
        'federation_id' => $fedB->id,
    ]);

    // 5. UserWorkMore
    $uwMoreA = UserWorkMore::create([
        'user_work_id' => $userWork->id,
        'federation_id' => $fedA->id,
        'field_name' => $fedMoreA->field_name,
        'field_value' => 'ValA',
    ]);
    $uwMoreB = UserWorkMore::create([
        'user_work_id' => $userWork->id,
        'federation_id' => $fedB->id,
        'field_name' => $fedMoreB->field_name,
        'field_value' => 'ValB',
    ]);

    // Run Job
    CascadeDeleteFederationJob::dispatchSync($fedA);

    // Verify Federation A records are soft deleted
    $this->assertSoftDeleted('federation_sections', ['id' => $sectionA->id]);
    $this->assertSoftDeleted('federation_mores', ['id' => $fedMoreA->id]);
    $this->assertSoftDeleted('user_contact_mores', ['id' => $ucMoreA->id]);
    $this->assertSoftDeleted('user_roles', ['id' => $userRoleA->id]);
    $this->assertSoftDeleted('user_work_mores', ['id' => $uwMoreA->id]);

    // Verify Federation B records are NOT soft deleted
    $this->assertNotSoftDeleted('federation_sections', ['id' => $sectionB->id]);
    $this->assertNotSoftDeleted('federation_mores', ['id' => $fedMoreB->id]);
    $this->assertNotSoftDeleted('user_contact_mores', ['id' => $ucMoreB->id]);
    $this->assertNotSoftDeleted('user_roles', ['id' => $userRoleB->id]);
    $this->assertNotSoftDeleted('user_work_mores', ['id' => $uwMoreB->id]);
});

test('deleting a federation dispatches cascade delete federation job', function () {
    Queue::fake();

    $federation = Federation::factory()->create(['id' => 'FEDDEL']);
    $federation->delete();

    Queue::assertPushed(CascadeDeleteFederationJob::class, function ($job) use ($federation) {
        return $job->federation->id === $federation->id;
    });
});
