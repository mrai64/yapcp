<?php
/**
 * Juror (contest Section ) Single Vote
 * CLASS: app/Livewire/Contest/Jury/Vote.php
 * VIEW:  resources/views/livewire/contest/jury/vote.blade.php
 *
 */
namespace App\Livewire\Contest\Jury;

?>

<div style="justify-content:center;">
    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif
    @if ( isset($unvoted_work_first->id) )
    <!-- vote img -->
    <div style="width:80%;height:80%;display:block;margin:0 auto;background-color:#f0f0f0;">
        <a href="route('contest-jury-board', ['sid' => $this->contest_section_id ])">
            [ {{ __("Back to Board")}} ]
        </a>
        <!-- vote form -->
        @if ($vote_rule === 'num:1..10')
                <table>
                    <tr>
                        <td><span>{{__(" best ")}}</span></td>
                        <td>
<form action="{{ route('contest-jury-vote', ['sid' => $this->contest_section_id ]) }}" method="post">
    @csrf
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('10')">10</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('9')">9</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('8')">8</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('7')">7</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('6')">6</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('5')">5</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('4')">4</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('3')">3</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('2')">2</label>
    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('1')">1</label>
</form>
                        </td>
                        <td><span>{{__(" worst ")}}</span> </td>
                    </tr>
                </table>
        @endif
        @if ($vote_rule === 'num:1..30')
            <form wire:click="assign_vote">
                @csrf
                <table>
                    <tr>
                        <td><span>{{__(" best ")}}</span></td>
                        <td>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="30">30</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="29">29</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="28">28</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="27">27</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="26">26</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="25">25</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="24">24</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="23">23</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="22">22</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="21">21</label>
                <br />
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="20">20</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="19">19</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="18">18</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="17">17</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="16">16</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="15">15</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="14">14</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="13">13</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="12">12</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="11">11</label>
                <br />
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="10">10</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="9">9</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="8">8</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="7">7</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="6">6</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="5">5</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="4">4</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="3">3</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="2">2</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="1">1</label>
                        </td>
                        <td><span>{{__(" worst ")}}</span> </td>
                    </tr>
                </table>
            </form>
        @endif
        @if ($vote_rule === 'star:1..5')
            <form wire:click="assign_vote">
                @csrf
                <table>
                    <tr>
                        <td><span>{{__(" best ")}}</span></td>
                        <td>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="⭐️⭐️⭐️⭐️⭐️">⭐️⭐️⭐️⭐️⭐️</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="⭐️⭐️⭐️⭐️">⭐️⭐️⭐️⭐️</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="⭐️⭐️⭐️">⭐️⭐️⭐️</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="⭐️⭐️">⭐️⭐️</label>
                <label style="width:4rem;display:inline-block;"><input type="checkbox" name="vote[]" value="⭐️">⭐️</label>                        </td>
                        <td><span>{{__(" worst ")}}</span> </td>
                    </tr>
                </table>
            </form>
        @endif

        <div style="max-width:90%;max-height:90%;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
            <img src="{{ asset('storage/contests') .'/'. $unvoted_work_first->contest_id .'/'. $unvoted_work_first->section_id .'/'. $unvoted_work_first->work_id .'.'. $unvoted_work_first->extension }}"
            style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;"
            />
        </div>
    </div>
    @else
        <a href="{{ route('contest-jury-board',  ['sid' => $this->section_id ]) }}">
            <h2 class="fyk text-2xl">{{ __("All done, back to your Jury Board") }} </h2>
        </a>
    @endif
</div>
