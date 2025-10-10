<?php
/**
 * User Role Federation Add
 */

namespace App\Livewire\User\Role\Federation;

use App\Models\Federation;
use App\Models\UserRole;
use App\Models\UserRolesRoleSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    // form field and class attribute
    public UserRole $user_role;
    public string   $user_id;
    public          $role_list;
    public string   $role;
    public          $federation_list;
    public          $federation_id;
    public          $federation;

    /**
     * 1. Before the show
     */
    public function mount() // no id use Auth::id()
    {
        $this->user_id = Auth::id();
        $this->role_list  = UserRolesRoleSet::valid_roles(); // []
        $this->federation_list =Federation::listed_by_country_id_name();
    }
    /**
     * 2. Show
     */
    public function render()
    {
        return view('livewire.user.role.federation.add');
    }
    /**
     * 3. Validation rules
     */
    public function rules()
    {
        return [
         // 'role'          => 'required|string|max:255',
            'role'          => 'required|exists:user_roles_role_sets,status',
            'federation_id' => 'required|string|exists:federations,id',
        ];
    }
    /**
     * 4. check n save
     */
    public function save_user_role()
    {
        Log::info(__FUNCTION__. ' ' . __LINE__ );
        $validated = $this->validate();

        // integration 
        $validated['user_id'] = $this->user_id;
        Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['user_id']);
        Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['role']);
        Log::info(__FUNCTION__. ' ' . __LINE__ . ' ' . $validated['federation_id']);
        
        $this->user_role = UserRole::create($validated);
        Log::info(__FUNCTION__. ' ' . __LINE__ . $this->user_role );

        return redirect()
          ->route('dashboard')
          ->with('success', __('New Role added to list, enjoy!') );
    }
}
