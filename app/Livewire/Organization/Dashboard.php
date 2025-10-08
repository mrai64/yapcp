<?php
/**
 * Organization/Dashboard
 * - list member of organization
 * - list contest of organization 
 * 
 * 
 */
namespace App\Livewire\Organization;

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use App\Models\UserRole;
use Livewire\Component;

class Dashboard extends Component
{
    public $id;
    public $organization;
    public $user_role_list;
    public $contest_list;
    public $user;

    /**
     * 1. before show
     */
    public function mount(string $id) // as in route/web.php
    {
        $this->organization = Organization::where('id', $id)->get(['id', 'country_id', 'name'])[0];
        $this->user_role_list = UserRole::where('organization_id', $id)->orderBy('role')->orderBy('updated_at')->get(['id', 'user_id','role', 'role_opening', 'role_closing']);
        $this->contest_list = Contest::where('organization_id', $id)->orderBy('updated_at')->get(['id','name_en', 'day_2_closing']);

    }
    /**
     * 2. show must go
     */
    public function render()
    {
        return view('livewire.organization.dashboard');
    }
}
