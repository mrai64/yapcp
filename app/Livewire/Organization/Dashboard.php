<?php

/**
 * Organization/Dashboard
 * - list member of organization
 * - list contest of organization
 */

namespace App\Livewire\Organization;

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserRole;
use Livewire\Component;

class Dashboard extends Component
{
    public $id;

    public $organization;

    public $organizationMembersRolesSet;

    public $contestSet;

    public $user;

    /**
     * 1. before show
     */
    public function mount(Organization $organization) // as in route/web.php
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->organization = $organization;
        $this->id = $organization->id;
        
        $this->organizationMembersRolesSet = UserRole::where('organization_id', $this->id)
            ->orderBy('role')
            ->orderBy('updated_at')
            ->get(['id', 'user_id', 'role', 'role_opening', 'role_closing']);
        $this->contestSet = Contest::where('organization_id', $this->id)
            ->orderBy('updated_at')
            ->get(['id', 'name_en', 'day_2_closing']);

    }

    /**
     * 2. show must go
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return view('livewire.organization.dashboard');
    }
}
