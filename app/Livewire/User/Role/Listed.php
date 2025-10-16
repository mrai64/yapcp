<?php
/**
 * User Role list
 * child table of Users
 * 
 * must have user_id
 * <livewire:user.role.listed :uid="" >
 * 
 * 2025-10-08 reformat mount() to avoid duplicate rec (usually juror for more section)
 * 2025-10-16 federation table changed
 */
namespace App\Livewire\User\Role;

use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $sorted_user_role_list = [];

    /**
     * 1. before the show
     */
    public function mount() 
    {
        $this->uid               = Auth::id();
        $this->user              = User::findOrFail($this->uid);
        $this->user_role         = UserRole::select( DB::raw('max(id) AS `id_max` '), 'role', 'organization_id', 'federation_id', 'contest_id')
            ->where('user_id', $this->uid)
            ->groupBy('organization_id')
            ->groupBy('federation_id')
            ->groupBy('contest_id')
            ->groupBy('role')
            ->orderBy('organization_id')
            ->orderBy('federation_id')
            ->orderBy('contest_id')
            ->orderBy('role')
            ->get();

        foreach($this->user_role as $role) {
            $this->user_role_list[] = [
                'id'              =>  $role->id_max,
                'role'            =>  $role->role,
                'organization_id' => ($role->organization_id > '') ? $role->organization_id : '',
                'organization'    => ($role->organization_id > '') ? Organization::where( 'id', $role->organization_id )->get('name')[0]['name'] : '',
                'federation_id'   => ($role->federation_id > '')   ? $role->federation_id : '',
                'federation'      => ($role->federation_id > '')   ? Federation::where('id', $role->federation_id)->get('name_en')[0]['name_en'] : '',
                'contest_id'      => ($role->contest_id > '')      ? $role->contest_id : '', 
                'contest'         => ($role->contest_id > '')      ? Contest::get_name_en( $role->contest_id) : '', 
                'start'           =>  UserRole::where('id', $role->id_max)->get('role_opening')[0]['role_opening']->format('Y-m-d'),
                'end'             =>  UserRole::where('id', $role->id_max)->get('role_closing')[0]['role_closing']->format('Y-m-d'),
            ];
        }

        // 
        $this->sorted_user_role_list = collect($this->user_role_list)->sortBy('federation')->sortBy('organization')->sortBy('contest')->sortBy('role')->toArray();
        $this->user_role_list = $this->sorted_user_role_list;

    }
    /**
     * 2. on air
     */
    public function render()
    {
        return view('livewire.user.role.listed');
    }
}
