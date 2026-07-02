<?php

/**
 * Organization Contest Design / Contest general detail
 */

use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest         $contest;
    public Organization    $organization;

    public function mount(Contest $contest)
    {
        $this->contest =      $contest;
        $this->organization = $contest->organization;
    }
}; ?>

<div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __('Participation info') }}
    </h3>
    <hr class="mb-4" />
    <pre class="fyk text-xl">{{ $contest->fee_info }}</pre>
</div>
