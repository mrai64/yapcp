<?php
/**
 * User Role Organization Add
 * 
 */
namespace App\Livewire\User\Role\Organization;

use App\Models\Organization;
use App\Models\UserRole;
use App\Models\UserRolesRoleSet;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Add extends Component
{
    // define fields
    public UserRole $user_role;
    public string   $user_id;
    public          $role_list;
    public string   $role;
    public          $organization_list;
    public          $organization_id;
    public          $organization;
    /**
     * 1. Before the show
     */
    public function mount() // no id for user_id
    {
        $this->user_id   = Auth::id();
        $this->role_list = UserRolesRoleSet::valid_roles(); // it's an []
        $this->organization_list = Organization::listed_by_country_id_name(); // country_id, name

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
            'role'            => 'required|exists:user_roles_role_sets,status',
            'organization_id' => 'required|string|exists:organizations,id',
        ];
    }
    /**
     * 4. check! act!
     */
    public function save_user_role()
    {
        // Log::info(__FUNCTION__. ' ' . __LINE__ );
        $validated = $this->validate();

        // integration 
        $validated['user_id'] = $this->user_id;
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['user_id']);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['role']);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['organization_id']);
        
        $this->user_role = UserRole::create($validated);
        // Log::info(__FUNCTION__. ' ' . __LINE__ . $this->user_role );

        return redirect()
          ->route('dashboard')
          ->with('success', __('New Role added to list, enjoy!') );

    }
}
