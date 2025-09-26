<?php
/**
 * User Role list
 * child table of Users
 * must have user_id
 * <livewire:user.role.listed :uid="" >
 * 
 */
namespace App\Livewire\User\Role;

use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Listed extends Component
{
    // input parm 
    public $uid; // same name of 

    public User $user;
    public $user_role;
    public Organization $organization_list;
    public Contest $contest_list;
    public Federation $federation_list;
    public $user_role_list = [];

    /**
     * 1. before the show
     */
    public function mount() 
    {
        $this->uid               = Auth::id();
        $this->user              = User::findOrFail($this->uid);
        $this->user_role         = UserRole::whereNull('deleted_at')->where('user_id', $this->uid)->orderBy('updated_at', 'desc')->get();

        foreach($this->user_role as $role) {
            $this->user_role_list[] = [
                'id'              =>  $role->id,
                'role'            =>  $role->role,
                'organization_id' => ($role->organization_id > '') ? $role->organization_id : '',
                'organization'    => ($role->organization_id > '') ? Organization::whereNull('deleted_at')->where( 'id', $role->organization_id )->get('name')[0]['name'] : '',
                'federation_id'   => ($role->federation_id > '')   ? $role->federation_id : '',
                'federation'      => ($role->federation_id > '')   ? Federation::whereNull('deleted_at')->where('id', $role->federation_id)->get('name')[0]['name'] : '',
                'contest_id'      => ($role->contest_id > '')      ? $role->contest_id : '', 
                'contest'         => ($role->contest_id > '')      ? Contest::get_name_en( $role->contest_id) : '', 
                'start'           =>  $role->role_opening->format('Y-m-d'),
                'end'             =>  $role->role_closing->format('Y-m-d'),
            ];
        }

    }
    /**
     * 2. on air
     */
    public function render()
    {
        return view('livewire.user.role.listed');
    }
}
