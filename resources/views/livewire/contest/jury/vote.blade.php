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
    <div style="width:96%;height:96%;display:block;margin:0 auto;background-color:#f0f0f0;">
        <a href="{{route('contest-jury-board', ['sid' => $this->contest_section_id ])}}">
            [ {{ __("Back to Board")}} ]
        </a>
        <!-- vote form -->
        @if ($vote_rule === 'num:1..10')
        <table>
            <tr>
                <td><span>{{__(" best ")}}</span></td>
                <td>
                <form action="$refresh" method="post">
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
        <table>
            <tr>
                <td><span>{{__(" best ")}}</span></td>
                <td>
                <form action="$refresh" method="post">
                    @csrf
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('30')">30</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('29')">29</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('28')">28</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('27')">27</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('26')">26</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('25')">25</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('24')">24</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('23')">23</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('22')">22</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('21')">21</label>
                    <br />
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('20')">20</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('19')">19</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('18')">18</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('17')">17</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('16')">16</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('15')">15</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('14')">14</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('13')">13</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('12')">12</label>
                    <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('11')">11</label>
                    <br />
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
        @if ($vote_rule === 'star:1..5')
        <table>
            <tr>
                <td><span>{{__(" best ")}}</span></td>
                <td>
                    <form action="$refresh" method="post">
                        @csrf
                        <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('⭐️⭐️⭐️⭐️⭐️')">⭐️⭐️⭐️⭐️⭐️</label>
                        <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('⭐️⭐️⭐️⭐️')">⭐️⭐️⭐️⭐️</label>
                        <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('⭐️⭐️⭐️')">⭐️⭐️⭐️</label>
                        <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('⭐️⭐️')">⭐️⭐️</label>
                        <label style="width:4rem;display:inline-block;"><input type="checkbox" class="form-control" wire:click="assign_vote('⭐️')">⭐️</label>
                    </form>
                </td>
                <td><span>{{__(" worst ")}}</span> </td>
            </tr>
        </table>
        @endif
        <!-- image -->
        <div>
            contest_id: {{ $unvoted_work_first->contest_id }} 
            section_id: {{ $unvoted_work_first->section_id }}
            work_id: {{ $unvoted_work_first->work_id }}
            juror_id: {{ $juror_user_id }}
        </div>
        <div style="max-width:90%;max-height:90%;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
            <img src="{{ asset('storage/contests') .'/'. $unvoted_work_first->contest_id .'/'. $unvoted_work_first->section_id .'/'. $unvoted_work_first->work_id .'.'. $unvoted_work_first->extension }}"
            style="max-width:100%;max-height:100%;object-fit:contain;border-radius:.5rem;"
            />
        </div>

    </div>
    @else
        <a href="{{ route('contest-jury-board',  ['sid' => $this->section_id ]) }}">
            <h2 class="fyk text-2xl">{{ __("All done, back to your Jury Board") }} </h2>
        </a>
    @endif
</div>
