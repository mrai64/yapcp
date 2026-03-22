<?php

use App\Http\Controllers\Contest\JuryMinuteDraft;
use App\Http\Controllers\Contest\Report\Fiaf1ParticipantsController;
use App\Http\Controllers\Contest\Report\Fiaf2WorksController;
use App\Http\Controllers\FederationController;
use App\Livewire\Contest;
use App\Livewire\Federation;
use App\Livewire\Juror;
use App\Livewire\Organization;
use App\Livewire\User;
use App\Models\Federation as ModelsFederation;
use Illuminate\Support\Facades\Route;

// =====================================
// Public pages - url show directly view
// =====================================

Route::view('/', 'welcome');
Route::view('/credits', 'credits');
// USER Volt guest/auth routes
require __DIR__ . '/auth.php';
// Federation - guest/list
Route::get('/federation', [FederationController::class, 'index'])
    ->name('federation.list');
// TODO Federation Section/list - guest

// TODO other public guest pages
// TODO list of open contest with board of participants
// TODO list of closed contest with board of winners
// TODO contest admitted and awarded thumb

/**
 * User view
 */
Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * UserContact
 */
// user contact/add - user itself and organization (for juror) and admin
// admin
Route::get('/user/contact/listed', User\Contact\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-listed');
// user contact/ modify* - user itself n admin
Route::get('/user/contact/modify', User\Contact\Modify1YouAre::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify');
Route::get('/user/contact/modify1/{uid?}', User\Contact\Modify1YouAre::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify1');
Route::get('/user/contact/modify2/{uid?}', User\Contact\Modify2PostAddress::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify2');
Route::get('/user/contact/modify3/{uid?}', User\Contact\Modify3Phones::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify3');
Route::get('/user/contact/modify4/{uid?}', User\Contact\Modify4Socials::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify4');
// Add federation required fields
// try https://yapcp.test/user/contact/modify5/FIAF/019b519e-129d-73d4-ba13-ba922a8aeb85
Route::get('/user/contact/modify5/{fid}/{uid?}', User\Contact\Modify5Feds::class, ['fid', 'uid'])
    ->middleware(['auth', 'verified'])
    ->name('user-contact-modify5');
// D /user/contact/remove is not needed - contact removed at user deletion

/**
 * Admin - Federation
 */
// federation list - guest no admin
// federation add - admin no livewire
Route::get('/admin/federation/add', [FederationController::class, 'create'])
    ->middleware('can:create,' . ModelsFederation::class)
    ->name('federation.add');
Route::post('/admin/federation/store', [FederationController::class, 'store'])
    ->name('federation.store');
//  federation update - admin  livewire style
Route::get('/admin/federation/modify/{federation}', Federation\Modify::class, ['fid'])
    ->middleware('can:update,federation')
    ->name('federation.modify');
//  federation softdelete - admin
Route::get('/federation/remove/{fid}', Federation\Remove::class, ['fid'])
    ->middleware(['auth', 'verified'])
    ->name('federation.delete');
Route::delete('/federation/remove/{fid}', Federation\Remove::class, ['fid'])
    ->middleware(['auth', 'verified']);

/**
 * Admin - FederationSection
 */
// federation_section list  - guest
Route::get('/federation/section/list/{fid}', Federation\Section\Listed::class, ['fid'])
    ->middleware(['auth', 'verified'])
    ->name('federation-section.list');
// federation_section add   - admin
Route::get('/federation/section/add/{fid}', Federation\Section\Add::class, ['fid'])
    ->middleware(['auth', 'verified'])
    ->name('federation-section.add');
Route::get('/federation/section/modify/{fid}/{sid}', Federation\Section\Modify::class, ['fid', 'sid'])
    ->middleware(['auth', 'verified'])
    ->name('federation-section.modify');
Route::get('/federation/section/remove/{sid}', Federation\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('federation-section.delete');
Route::delete('/federation/section/remove/{sid}', Federation\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified']);

/**
 * Admin - FederationMores
 */

/**
 * User - Organization blueprint
 */
Route::get('/organization/listed', Organization\Listed::class)
    ->name('organization-list');
Route::get('/organization/add/', Organization\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('add-organization');
Route::get('/organization/modify/{id}', Organization\Modify::class, ['id'])
    ->middleware(['auth', 'verified'])
    ->name('modify-organization');
Route::get('/organization/remove/{id}', Organization\Remove::class, ['id'])
    ->middleware(['auth', 'verified'])
    ->name('delete-organization');
Route::delete('/organization/remove/{id}', Organization\Remove::class, ['id'])
    ->middleware(['auth', 'verified']);
// organization dashboard
Route::get('/organization/dashboard/{id}', Organization\Dashboard::class, ['id'])
    ->middleware(['auth', 'verified'])
    ->name('organization-dashboard');

/**
 * UserRole
 */
Route::get('/dashboard/role', User\Role\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('user-role-list');
Route::get('/dashboard/role/federation/add', User\Role\Federation\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('add-user-role-federation');
Route::get('/dashboard/role/organization/add', User\Role\Organization\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('add-user-role-organization');

/**
 * UserWork
 */
Route::get('/user/work/list', User\Work\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('photo-box-list');
Route::get('/user/work/add', User\Work\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('photo-box-add');
Route::get('/user/work/modify/{wid}', User\Work\Modify::class, ['wid'])
    ->middleware(['auth', 'verified'])
    ->name('photo-box-modify');
Route::get('/user/work/remove/{wid}', User\Work\Remove::class, ['wid'])
    ->middleware(['auth', 'verified'])
    ->name('delete-photo-box');
Route::delete('/user/work/remove/{wid}', User\Work\Remove::class, ['wid'])
    ->middleware(['auth', 'verified']);

/**
 * Contest blueprint - Organization define
 * - contest
 * - contest section
 * - contest jury
 * - contest award
 *
 * Contest
 * TODO /contest/listed for guest version
 */
Route::get('/contest/listed', Contest\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('contest-list');
Route::get('/contest/add/{oid}', Contest\Add::class, ['oid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-add');
Route::get('/contest/modify/{cid}', Contest\Modify::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('modify-contest');

/**
 * Contest blueprint - ContestSection
 */
Route::get('/contest/section/add/{cid}', Contest\Section\Add::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-section-add');
Route::get('/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('modify-contest-section');
Route::get('/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('modify-contest-section');
Route::get('/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('remove-contest-section');
Route::delete('/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified']);

/**
 * Contest blueprint - ContestJury
 */
Route::get('/contest/jury/add/{sid}', Contest\Jury\Add::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-jury-add');

/**
 * Contest blueprint - ContestAward
 */
Route::get('/contest/award/add/{cid}', Contest\Award\Add::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-award-add');

/**
 * Contest manage - User contest subscribe
 */
Route::get('/user/contest/subscribe/{cid}', Contest\Subscribe::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('participate-contest');
Route::get('/user/contest/subscribe/{cid}/work/{wid}', Contest\Subscribe::class, ['cid', 'wid'])
    ->middleware(['auth', 'verified'])
    ->name('add-work-contest');
Route::delete('/user/contest/subscribe/remove/{pid}', Contest\Subscribe\Remove::class, ['pid'])
    ->middleware(['auth', 'verified'])
    ->name('remove-work-contest');

/**
 * Contest manage - Organization
 */
// Contest live - Organization contest dashboard
Route::get('/organization/contest/{cid}', Organization\ContestPanel::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-live-dashboard');

// Contest live - Organization review Participant User list _fee payment completed_
Route::get('/organization/contest/participants/listed/{cid}', Contest\Participants\Listed::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('public-participant-list');
Route::get('/organization/contest/participants/modify/{cid}', Contest\Participants\Modify::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('modify-participant-list');

// Contest live - organization works before jury works
Route::get('/organization/contest/pre-jury/section-list/{cid}', Organization\PreJury\SectionListed::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-contest-list');
Route::get('/organization/contest/pre-jury/section-review/{sid}', Organization\PreJury\SectionReview::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-contest-section-list');
Route::get('/organization/contest/pre-jury/warn/{wid}', Organization\PreJury\WarnEmail::class, ['wid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-contest-warn-email');
Route::get('/organization/contest/pre-jury/pass/{wid}', Organization\PreJury\PassNext::class, ['wid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-contest-pass-next');

/**
 * Contest manage - Jury works
 */
// for jurors only
Route::get('/juror/section-board/{sid}', Juror\SectionBoard::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-jury-board');
Route::get('/juror/vote/{sid}', Juror\Vote::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-jury-vote');
Route::post('/juror/vote/{sid}', Juror\Vote::class, ['sid'])
    ->middleware(['auth', 'verified']);
Route::get('/juror/review-vote/{vid}', Juror\ReviewVote::class, ['vid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-jury-vote-mod');

/**
 * Contest manage - Organization before last jury meeting
 */
// Contest live - cumulative vote board for a section
Route::get('/organization/contest/admit/before-final/{sid}', organization\Admit\BeforeFinal::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('contest-before-final-jury');

/**
 * Contest manage
 */
// Contest live - After jury first works set admit list
Route::get('/organization/contest/admit/set-admit/{sid}', Organization\Admit\SetAdmit::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-contest-admit');

// Contest live - during or after last Jury reunion
Route::get('/organization/award-assign/section/{sid}', Organization\Award\SectionAssign::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-award-section-assign');
Route::get('/organization/award-assign/contest/{cid}', Organization\Award\ContestAssign::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-award-contest-assign');

// Contest live - build the draft of the jury minute
Route::get('/organization/award-assign/jury-minute/{cid}', [JuryMinuteDraft::class, 'buildMinute'], ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization-award-minute-draft');

// Contest live - reports - no auth required - public access
Route::get('/organization/reports/works-participant/{cid}', Organization\Reports\WorksParticipant::class, ['cid'])
    ->name('organization-reports-works-participant');

/**
 * Contest manage - "latest" job: report for federations
 */
//
// FIAF report export - author participants
Route::get(
    '/contest/export/FIAF1/{cid}/{fid}',
    [Fiaf1ParticipantsController::class, 'exportFiaf1Participants'],
    ['cid', 'fid']
)
    ->middleware(['auth', 'verified'])
    ->name('contest-report-fiaf1');
//
// FIAF report export - works participants - job
Route::get(
    '/contest/export/FIAF2/{cid}/{fid}',
    [Fiaf2WorksController::class, 'exportFiaf2Works'],
    ['cid', 'fid']
)
    ->middleware(['auth', 'verified'])
    ->name('contest-report-fiaf2');

/**
 * end of list
 */
