<?php 

/**
 * Contest dashboard for organization
 * 
 * @see /app/Livewire/Contest/Dashboard.php
 * 
 */
?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ $contest->country->flag_code }}
            | {{$contest->name_en}}
        </h2>
        <h3 class="fyk text-xl font-medium text-gray-900">
            {{ __('Contest Dashboard, for organization') }}
            : {{ $contest->organization->name_en }}
        </h3>
        <hr />
        <br />
        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('organization.dashboard', [ 'id' => $contest->organization_id ]) }}"
                rel="noopener noreferrer">
            [ {{ __('Back to organization dashboard') }} ]
            </a>
        </p>
    </header>

    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif
    <!-- status -->
    @if (session('status'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('status') }}
    </div>
    @endif

    <!-- errors list -->
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">❌ {{ $error }} 👈</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('public-participant-list', ['cid' => $contest->id ]) }}"
                rel="noopener noreferrer">
                [ {{ __('Update Participant list') }} ]
            </a>
        </h3>
        <p class="small">
            {{ __("The participant list contains a go/no go flag based on the fee payment status.") }}
            {{ __("Only members of the organization are authorized to perform this procedure,") }}
            {{ __("which provides that, upon the deadline for participation,") }}
            {{ __("anyone who has not been confirmed as having paid the registration fee") }}
            {{ __("will be excluded silently from the competition.") }}
        </p>
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Pre Jury window") }}
        </h3>
        <p class="small">
            {{ __("During the period between the deadline for entering the competition and") }}
            {{ __("the start of the jury’s deliberations, the organizers may and must verify") }}
            {{ __("that entry fees have been paid and that the works submitted to the competition") }}
            {{ __("and to be presented to the jury are in order.") }}
        </p>
        <hr />
        <h3 class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('organization.contest.list', ['cid' => $contest->id ]) }}"
                rel="noopener noreferrer">
                [ {{ __('Works Validation - Section List') }} ]
            </a>
        </h3>
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Section list") }}
        </h3>
        @foreach( $contestSectionsSet as $contestSection)
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('organization-contest-section-list', ['sid' => $contestSection->id]) }}">
                [ {{ __("Section Works Preview for") }} ]
            </a>
            {{ $contestSection->code }} | {{ $contestSection->name_en }}
        </div>
        @endforeach
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Jury window") }}
        </h3>
        <p class="small">
            {{ __("While the jury is deliberating, the organizing committee may monitor") }}
            {{ __("the total number of votes cast, and eventually at the end of the deliberations,") }}
            {{ __("ask the jury to reconsider a small number of works that") }}
            {{ __("are on the cusp of being accepted or rejected.") }}
        </p>
        <hr />
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Section list") }}
        </h3>
        @foreach( $contestSectionsSet as $contestSection)
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('contest-before-final-jury', ['sid' => $contestSection->id ]) }}">
                [ {{ __("Sum Votes Board + Ask Vote Change") }} ]
            </a>
            {{ $contestSection->code }} | {{ $contestSection->name_en }}
        </div>
        @endforeach
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Jury Final meet - admission") }}
        </h3>
        <hr />
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Section list") }}
        </h3>
        @foreach( $contestSectionsSet as $contestSection)
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('organization-contest-admit', ['sid' => $contestSection->id ]) }}">
                [ {{ __("Admission set, based on Sum Votes") }} ]
            </a>
            {{ $contestSection->code }} | {{ $contestSection->name_en }}
        </div>
        @endforeach
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Jury Final meet - Sections' Awards assignment") }}
        </h3>
        <hr />
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Section list") }}
        </h3>
        @foreach( $contestSectionsSet as $contestSection)
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('organization-award-section-assign', ['sid' => $contestSection->id ]) }}">
                [ {{ __("Awards assignment") }} ]
            </a>
            {{ $contestSection->code }} | {{ $contestSection->name_en }}
        </div>
        @endforeach
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{__("Jury Final meet - Contest Awards") }}
        </h3>
        <hr />
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('organization-award-contest-assign', ['cid' => $contest->id ]) }}">
                [ {{ __("Contest Awards assignment") }} ]
            </a>
        </div>
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{__("Jury Final meet - Contest Minute") }}
        </h3>
        <p class="small">
            {{ __("Once the jury has completed its work—having selected the list of eligible entries,") }}
            {{ __("determined the prizes by category, and decided on the overall competition awards") }}
            {{ __("the jury is required to approve a competition report detailing the jury’s deliberations.") }}
            {{ __("A PDF document is created, which must be circulated among all jury members") }}
            {{ __("for their sequential signatures and will remain on file with the organizing committee.") }}
        </p>
        <hr />
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('organization-award-minute-draft', ['cid' => $contest->id]) }}">
                [ {{ __("Jury Minute - download pdf") }} ]
            </a>
        </div>
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{__("After Jury Organization Works") }}
        </h3>
        <p class="small">
            {{ __("This section details the reports that must be prepared by the competition organizers,") }}
            {{ __("such as the list of participants and the entries along with their results.") }}
            {{ __("These reports may be general in nature or tailored to the specific federations") }}
            {{ __("that have provided their sponsorship.") }}
        </p>
        <hr />
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('contest-report-fiaf1', ['cid' => $contest->id, 'fid' => 'FIAF' ]) }}">
                [ FIAF Participant w/Section XLSL ]
            </a>
        </div>
        <br />
        <div class="fyk text-xl mb-4 w-full">
            <a href="{{ route('contest-report-fiaf2', ['cid' => $contest->id, 'fid' => 'FIAF' ]) }}">
                [ FIAF Work Result and award XLSL ]
            </a>
        </div>
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Send Results to participants") }}
        </h3>
        <p class="small">
            {{ __("This action initiates a process that compiles data on each participant, the works they submitted,") }}
            {{ __("and the outcome (accepted or rejected), as well as any awards received, and sends") }}
            {{ __("this information to each participant along with a summary of details regarding") }}
            {{ __("the award ceremony, serving as an invitation to attend.") }}
        </p>
        <hr />
        <div class="fyk text-xl mb-4 w-full">
            <a href="#">
                [ TODO ]
            </a>
        </div>
    </div>

    <div class="p-4 border rounded-md mb-4 w-full">
        <h3 class="fyk text-xl font-medium mb-4">
            {{ __("Publish web result") }}
        </h3>
        <p class="small">
            {{ __("This action initiates a process that generates static web pages listing the participants,") }}
            {{ __("the submitted works, and the outcome (accepted or rejected), along with any awards received,") }}
            {{ __("and sends them to each participant along with a summary of the information regarding the award ceremony.") }}
        </p>
        <hr />
        <div class="fyk text-xl mb-4 w-full">
            <a href="#">
                [ TODO ]
            </a>
        </div>
    </div>
    <!-- end of contest dashboard -->
</div>
