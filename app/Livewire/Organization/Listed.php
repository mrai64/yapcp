<?php

/**
 * Organization List
 * available from all?
 * 
 * only for registered user but...
 * - admin can modify all organization records
 * - user can modify only him/her organization
 * 
 * @see /resources/views/livewire/organization/listed.blade.php
 * 
 * 
 */
namespace App\Livewire\Organization;

use App\Models\Organization;
use App\Models\UserRole;
use Livewire\Component;

class Listed extends Component
{
    // The Organization list
    public $organization_list = null;

    // are you an admin?
    public bool $isAdmin = false;

    // what are your organization(s)?
    public $userOrganizationsSet;

    // 1. mount 
    public function mount()
    {
        $this->isAdmin = UserRole::isAdmin();
    }

    // 2. render
    public function render()
    {
        $this->organization_list = Organization::countryIdSorted();

        return view('livewire.organization.listed');
    }

    // 3. no validation

    // 4. no store/update
}
