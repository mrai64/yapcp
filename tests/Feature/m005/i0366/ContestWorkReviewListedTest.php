<?php

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserWork;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

test('authenticated admin can access contest work review listed page with proper data', function () {
    // Setup Organization
    $this->organization = Organization::factory()->create();

    // Setup Contest linked to Organization
    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    // Setup ContestSection linked to Contest
    $this->section = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
    ]);

    // Setup Participant User (competitor)
    $this->participant = User::factory()->create();

    // Setup UserWork for participant
    $this->participantWork = UserWork::factory()->create([
        'user_id' => $this->participant->id,
    ]);

    // Setup ContestWork linking UserWork to Contest and Section
    $this->contestWork = ContestWork::factory()->create([
        'contest_id' => $this->contest->id,
        'user_work_id' => $this->participantWork->id,
        'section_id' => $this->section->id,
    ]);

    // Admin accesses the route
    $response = $this->actingAs($this->admin)
        ->get(route('organization.contest-work.listed', ['contest' => $this->contest]));

    $response->assertStatus(200)
        ->assertSee("Contest participant works review");

    // Verify the contest work is displayed in the list
    $response->assertSee($this->participantWork->title_en);
});
