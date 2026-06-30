<?php

/**
 * Organization contest list, design, running, closed
 * 
 */
use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;


new class extends Component {

    public Organization $organization;
    public UserContact $userContact;

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->userContact = Auth::user()->contact;
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __(':name Contest List' , ['name' => $organization->name] ) }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Back to Org Dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3>TODO Elenco dei concorsi tripartito</h3>
                <ol>
                    <li> in progetto</li>
                    <li> in corso</li>
                    <li> in terminati</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
