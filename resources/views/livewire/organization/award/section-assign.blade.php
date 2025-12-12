<?php
/**
 * 
 */

?>
<div>
    <div class="header h2 fyk text-2xl">
        {{ __("Contest Award Assignment Page for section") }}
    </div>
    <livewire:organization.award.section-nav :cid="$contest_id" lazy />

    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    <!-- Section Awards list -->
    <h2 class="fyk text-2xl">
        <a name="awardList"></a>
        {{ __("Section Awards list")}}
    </h2>
    <div class="my-4">
    <table class="data-table-container w-auto ">
        <thead>
            <tr class="">
                <th scope="col" valign="bottom" class="border md-rounded m-2 data-table-code">Award</td>
                <th scope="col" valign="bottom" class="border md-rounded m-2 data-table-awarded">Awarded</td>
            </tr>
        </thead>
        <tbody>
            @foreach($sectionAwards as $award)
            <tr class="">
                <td class="border md-rounded m-2">
                    {{ $award->award_code }}<br />
                    {{ $award->award_name }}
                </td>
                <td class="border md-rounded m-2">
                    @if($award->winner_work_id)
                    <livewire:organization.award.section-assigned-dia :wid="($contest_id.'/'.$section_id.'/300px_'.$award->winner_work_id.'.jpg')" lazy />
                    @else 
                    {{ __("Unassigned, at now") }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <div class="small">
                        {{ __("Warn: click on = Revoke")}}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
    </div>

    <!-- Admitted works w/buttons - paginated -->
    <h2 class="fyk text-2xl my-4">
        <a name="admittedList"></a>
        {{ __("Admitted Works")}}
    </h2>
    <hr class="my-4" />
    <div class="my-4 paginationDiv">
        {{ $admittedWorksSet->links() }}
    </div>
    <hr class="my-4" />
    <div class="my-4">
        @foreach($admittedWorksSet as $k => $aw)
        <livewire:organization.award.section-assign-dia :wid="($aw->contest_id.'/'.$aw->section_id.'/300px_'.$aw->work_id.'.'.$aw->extension)" lazy />
        @endforeach
    </div>
    <br style="clear:both;" />
    <div class="paginationDiv">
        {{ $admittedWorksSet->links() }}
    </div>

</div>
