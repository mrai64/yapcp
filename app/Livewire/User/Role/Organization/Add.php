<?php

/**
 * User Role Organization Add
 */

namespace App\Livewire\User\Role\Organization;

use App\Models\Organization;
use App\Models\UserRole;
use App\Models\UserRolesRoleSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    // define fields
    public UserRole $userRole;

    public string $userId;

    public $roleList;

    public string $role;

    public $organizationList;

    public $organizationId;

    public $organization;

    /**
     * 1. Before the show
     */
    public function mount() // no id for user_id
    {
        $this->userId = Auth::id();
        $this->roleList = UserRolesRoleSet::validRoles(); // it's an []
        $this->organizationList = Organization::countryIdSorted(); // country_id, name
    }

    /**
     * 2. The show
     */
    public function render()
    {
        return view('livewire.user.role.organization.add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        return [
            'role' => 'required|exists:user_roles_role_sets,role',
            'organizationId' => 'required|string|exists:organizations,id',
        ];
    }

    /**
     * 4. check! act!
     */
    public function saveUserRole()
    {
        // Log::info(__FUNCTION__. ' ' . __LINE__ );
        $validated = $this->validate();
        $validated['organization_id'] = $validated['organizationId'];

        // integration
        $validated['user_id'] = $this->userId;
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['user_id']);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['role']);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['organization_id']);

        $this->userRole = UserRole::create($validated);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . $this->user_role );

        return redirect()
            ->route('dashboard')
            ->with('success', __('New Role added to list, enjoy!'));
    }
}
