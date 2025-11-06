<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
use App\Livewire\Contest;
use App\Livewire\Federation;
use App\Livewire\Organization;
use App\Livewire\User;
use App\Livewire\Work;
use App\Models\UserRole;

Route::view('/', 'welcome');
Route::view('/credits', 'credits');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
// route > model NO
// Route::get('/federation', Federation::class);
// route > component YES 

// App\Livewire\Federation
Route::get(   '/federation/add',          Federation\Add::class)->middleware(['auth', 'verified'])->name('add-federation');
Route::get(   '/federation/list',         Federation\Listed::class)->middleware(['auth', 'verified'])->name('federation-list');
Route::get(   '/federation/modify/{fid}', Federation\Modify::class, ['fid'])->middleware(['auth', 'verified'])->name('modify-federation');
Route::get(   '/federation/remove/{fid}', Federation\Remove::class, ['fid'])->middleware(['auth', 'verified'])->name('delete-federation');
Route::delete('/federation/remove/{fid}', Federation\Remove::class, ['fid'])->middleware(['auth', 'verified']);

// App\Livewire\FederationSection
Route::get(   '/federation/section/list/{fid}',  Federation\Section\Listed::class, ['fid'])->middleware(['auth', 'verified'])->name('federation-section-list');
Route::get(   '/federation/section/add/{fid}',   Federation\Section\Add::class,    ['fid'])->middleware(['auth', 'verified'])->name('add-federation-section');
Route::get(   '/federation/section/modify/{fid}/{sid}', Federation\Section\Modify::class, ['fid','sid'])->middleware(['auth', 'verified'])->name('federation-section-modify');
Route::get(   '/federation/section/remove/{sid}', Federation\Section\Remove::class, ['sid'])->middleware(['auth', 'verified'])->name('delete-federation-section');
Route::delete('/federation/section/remove/{sid}', Federation\Section\Remove::class, ['sid'])->middleware(['auth', 'verified']);

// App\Livewire\Organization
Route::get(   '/organization/list',           Organization\Listed::class)->name('organization-list');
Route::get(   '/organization/add/',           Organization\Add::class)->middleware(['auth', 'verified'])->name('add-organization');
Route::get(   '/organization/modify/{id}',    Organization\Modify::class, ['id'])->middleware(['auth', 'verified'])->name('modify-organization');
Route::get(   '/organization/remove/{id}',    Organization\Remove::class, ['id'])->middleware(['auth', 'verified'])->name('delete-organization');
Route::delete('/organization/remove/{id}',    Organization\Remove::class, ['id'])->middleware(['auth', 'verified']);
Route::get(   '/organization/dashboard/{id}', Organization\Dashboard::class, ['id'])->middleware(['auth', 'verified'])->name('organization-dashboard');

// App\Livewire\Organization\Contest
Route::get( '/organization/contest/section_list/{cid}',    Organization\Contest\Listed::class,    ['cid'])->middleware(['auth', 'verified'])->name('organization-contest-list');
Route::get( '/organization/contest/section/{sid}', Organization\Contest\Section::class,   ['sid'])->middleware(['auth', 'verified'])->name('organization-contest-section-list');
Route::get( '/organization/contest/warn/{wid}',    Organization\Contest\WarnEmail::class, ['wid'])->middleware(['auth', 'verified'])->name('organization-contest-warn-email');
Route::get( '/organization/contest/pass/{wid}',    Organization\Contest\PassNext::class,  ['wid'])->middleware(['auth', 'verified'])->name('organization-contest-pass-next');

// App\Livewire\User
Route::get( '/user/contact/modify', User\Contact\Modify::class)->middleware(['auth', 'verified'])->name('user-contact-modify');

// App\Livewire\UserRole
Route::get( '/dashboard/role',     User\Role\Listed::class)->middleware(['auth', 'verified'])->name('user-role-list');
Route::get( '/dashboard/role/federation/add', User\Role\Federation\Add::class)->middleware(['auth', 'verified'])->name('add-user-role-federation');
Route::get( '/dashboard/role/organization/add', User\Role\Organization\Add::class)->middleware(['auth', 'verified'])->name('add-user-role-organization');

// App\Livewire\Work - (aka LiveWire\UserWork) parm user id passed via Auth::id()
Route::get(   '/work/list',         Work\Listed::class         )->middleware(['auth', 'verified'])->name('photo-box-list');
Route::get(   '/work/add',          Work\Add::class            )->middleware(['auth', 'verified'])->name('photo-box-add');
Route::get(   '/work/modify/{wid}', Work\Modify::class, ['wid'])->middleware(['auth', 'verified'])->name('photo-box-modify');
Route::get(   '/work/remove/{wid}', Work\Remove::class, ['wid'])->middleware(['auth', 'verified'])->name('delete-photo-box');
Route::delete('/work/remove/{wid}', Work\Remove::class, ['wid'])->middleware(['auth', 'verified']);

// App\Livewire\Contest
Route::get( '/contest/add/{oid}',       Contest\Add::class,       ['oid'])->middleware(['auth', 'verified'])->name('contest-add');
Route::get( '/contest/modify/{cid}',    Contest\Modify::class,    ['cid'])->middleware(['auth', 'verified'])->name('modify-contest');
Route::get( '/contest/listed',          Contest\Listed::class            )->middleware(['auth', 'verified'])->name('contest-list');

// App\Livewire\Contest\Section
Route::get(    '/contest/section/add/{cid}',    Contest\Section\Add::class, ['cid'] )->middleware(['auth', 'verified'])->name('contest-section-add');
Route::get(    '/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'] )->middleware(['auth', 'verified'])->name('modify-contest-section');
Route::get(    '/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'] )->middleware(['auth', 'verified'])->name('modify-contest-section');
Route::get(    '/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'] )->middleware(['auth', 'verified'])->name('remove-contest-section');
Route::delete( '/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'] )->middleware(['auth', 'verified']);

// App\Livewire\Contest\Jury
Route::get( '/contest/jury/add/{sid}',   Contest\Jury\Add::class,   ['sid'] )->middleware(['auth', 'verified'])->name('contest-jury-add');
Route::get( '/contest/jury/board/{sid}', Contest\Jury\Board::class, ['sid'] )->middleware(['auth', 'verified'])->name('contest-jury-board');
Route::get( '/contest/jury/vote/{sid}',  Contest\Jury\Vote::class,  ['sid'] )->middleware(['auth', 'verified'])->name('contest-jury-vote');
Route::post('/contest/jury/vote/{sid}',  Contest\Jury\Vote::class,  ['sid'] )->middleware(['auth', 'verified']);
Route::get( '/contest/jury/modify-vote/{vid}', Contest\Jury\VoteMod::class,  ['vid'] )->middleware(['auth', 'verified'])->name('contest-jury-vote-mod');
// TODO vote again

// App\Livewire\Contest\Awards
Route::get( '/contest/award/add/{cid}', Contest\Award\Add::class, ['cid'] )->middleware(['auth', 'verified'])->name('contest-award-add');

// App\Livewire\Contest\Subscribe - maybe also contest\work\add
Route::get(    '/contest/subscribe/{cid}',            Contest\Subscribe::class, ['cid'])->middleware(['auth', 'verified'])->name('participate-contest');
Route::get(    '/contest/subscribe/{cid}/work/{wid}', Contest\Subscribe::class, ['cid', 'wid'])->middleware(['auth', 'verified'])->name('add-work-contest');
Route::delete( '/contest/subscribe/remove/{pid}',     Contest\Subscribe\Remove::class, ['pid'])->middleware(['auth', 'verified'])->name('remove-work-contest');

// App\Livewire\Contest\Participants
Route::get( '/contest/participants/listed/{cid}', Contest\Participants\Listed::class, ['cid'])->middleware(['auth', 'verified'])->name('public-participant-list');
Route::get( '/contest/participants/modify/{cid}', Contest\Participants\Modify::class, ['cid'])->middleware(['auth', 'verified'])->name('modify-participant-list');
