<?php

/**
 * The Route board
 */

use App\Http\Controllers\Contest\JuryMinuteDraft;
use App\Http\Controllers\Contest\Report\Fiaf1ParticipantsController;
use App\Http\Controllers\Contest\Report\Fiaf2WorksController;
use App\Http\Controllers\FederationController;
use App\Livewire\Contest;
use App\Livewire\Federation;
use App\Livewire\Juror;
use App\Livewire\Organization;
use App\Livewire\User;
use App\Models\Contest as ModelsContest;
use App\Models\Federation as ModelsFederation;
use App\Models\FederationSection as ModelsFederationSection;
use App\Models\Organization as ModelOrganization;
use Illuminate\Support\Facades\Route;

/**
 * 1. no model - guest
 */

Route::view('/', 'welcome')
    ->name('welcome.aboard');
Route::view('/credits', 'credits')
    ->name('credits.notice');


// Federation List - laravel no livewire
Route::get('/federation/listed', [FederationController::class, 'index'])
    ->name('federation.list');
// federation_section list  - guest
Route::get('/federation/section/list/{federation}', Federation\Section\Listed::class)
    ->name('federation-section.list');
// Organization List - livewire
Route::get('/organization/listed', Organization\Listed::class)
    ->name('organization.list');
Route::get('/contest/listed', Contest\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('contest.list');
// TODO list of open contest with board of participants
// TODO list of closed contest with board of winners
// TODO contest admitted and awarded thumb

/**
 * 2. User, platform registration - user
 */
require __DIR__ . '/auth.php';
// user dashboard
Route::view('/user/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');
// change email and password 
Route::view('/user/profile', 'profile')
    ->middleware(['auth'])
    ->name('user.profile');

/**
 * 3. UserContact - user and admin
 *
 * TODO admin and organization for juror
 *
 */
Route::get('/user/contact/listed', User\Contact\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact.list');
// user contact/ modify* - user itself n admin
// Route::get('/user/contact/modify', User\Contact\Modify1YouAre::class)
//     ->middleware(['auth', 'verified'])
//     ->name('user-contact-modify');
Route::get('/user/contact/modify1/{uid?}', User\Contact\Modify1YouAre::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact.modify1');
Route::get('/user/contact/modify2/{uid?}', User\Contact\Modify2PostAddress::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact.modify2');
Route::get('/user/contact/modify3/{uid?}', User\Contact\Modify3Phones::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact.modify3');
Route::get('/user/contact/modify4/{uid?}', User\Contact\Modify4Socials::class)
    ->middleware(['auth', 'verified'])
    ->name('user-contact.modify4');
Route::get('/user/contact/modify5/{fid}/{uid?}', User\Contact\Modify5Feds::class, ['fid', 'uid'])
    ->middleware(['auth', 'verified'])
    ->name('user-contact.modify5'); // Add "federation more" required fields
// user contact remove intentionally miss - must be done in maintenance mode

/**
 * Federation - admin only
 */
// federation list - guest no admin
// federation add, no livewire - admin
Route::get('/admin/federation/add', [FederationController::class, 'create'])
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederation::class])
    ->name('federation.add');
Route::post('/admin/federation/store', [FederationController::class, 'store'])
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederation::class])
    ->name('federation.store');
// federation update, livewire - admin
Route::get('/admin/federation/modify/{federation}', Federation\Modify::class, ['fid'])
    ->middleware(['auth', 'verified', 'can:update,' . ModelsFederation::class])
    ->name('federation.modify');
// TODO federation remove only in maintenance mode
Route::get('/admin/federation/remove/{federation}', Federation\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete' . ModelsFederation::class])
    ->name('federation.delete');
Route::delete('/admin/federation/remove/{federation}', Federation\Remove::class)
    ->middleware(['auth', 'livewire', 'can:delete,' . ModelsFederation::class]);

/**
 * FederationSection - admin only
 */
// federation_section list - guest no admin
// federation_section add  - admin
Route::get('/admin/federation/section/add/{federation}', Federation\Section\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederationSection::class])
    ->name('federation-section.add');
Route::get('/admin/federation/section/modify/{federation-section}', Federation\Section\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsFederationSection::class])
    ->name('federation-section.modify');
Route::get('/admin/federation/section/remove/{federation-section}', Federation\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsFederationSection::class])
    ->name('federation-section.delete');
Route::delete('/admin/federation/section/remove/{federation-section}', Federation\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsFederationSection::class]);
// no name()

/**
 * FederationMores - admin only
 *
 * TODO - build routes n views
 */
// /admin/federation-more.add
// /admin/federation-more.modify
// /admin/federation-more.remove

/**
 * User - Organization blueprint
 */
// organization list - guest
// organization add - admin | user member(organization)
Route::get('/user/organization/add/', Organization\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('user.organization.add');
// organization modify - admin | user member(organization)
Route::get('/user/organization/modify/{organization}', Organization\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelOrganization::class])
    ->name('user.organization.modify');
Route::get('/user/organization/remove/{organization}', Organization\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelOrganization::class])
    ->name('user.organization.delete');
Route::delete('/user/organization/remove/{organization}', Organization\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelOrganization::class]);
// no name()
// organization dashboard - admin | user member(organization)
Route::get('/organization/dashboard/{organization}', Organization\Dashboard::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelOrganization::class])
    ->name('organization.dashboard'); // no user.organization.dashboard

/**
 * UserRole
 *
 * user itself and admin
 *
 */
Route::get('/user/dashboard/role', User\Role\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('user-role.list');
Route::get('/user/dashboard/role/federation/add', User\Role\Federation\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('user-role.add.federation');
Route::get('/user/dashboard/role/organization/add', User\Role\Organization\Add::class)
    ->middleware(['auth', 'verified'])
    ->name('user-role.add.organization');

/**
 * UserWork
 *
 * user itself and admin
 *
 */
Route::get('/user/work/list', User\Work\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('user.gallery');
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
 * Organization Contest blueprint - define
 * - contest
 * - contest section
 * - contest jury
 * - contest award
 *
 * organization member and admin
 *
 * Contest
 * TODO /contest/listed for guest version - see up
 */
Route::get('/organization/contest/add/{oid}', Contest\Add::class, ['oid'])
    ->middleware(['auth', 'verified', 'can:create,' . ModelsContest::class])
    ->name('organization.contest.add');
Route::get('/organization/contest/modify/{cid}', Contest\Modify::class, ['cid'])
    ->middleware(['auth', 'verified', 'can:update,' . ModelsContest::class])
    ->name('organization.contest.modify');
// no contest delete, after backup it's soft-deleted then removed after years

/**
 * Organization Contest blueprint
 *
 * ContestSection
 *
 */
Route::get('/organization/contest/section/add/{cid}', Contest\Section\Add::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-section.add');
Route::get('/organization/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-section.modify');
Route::get('/organization/contest/section/modify/{sid}', Contest\Section\Modify::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-section.modify');
Route::get('/organization/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-section.remove');
Route::delete('/organization/contest/section/remove/{sid}', Contest\Section\Remove::class, ['sid'])
    ->middleware(['auth', 'verified']);
// no name

/**
 * Organization Contest blueprint
 *
 * ContestJury
 *
 */
Route::get('/organization/contest/jury/add/{sid}', Contest\Jury\Add::class, ['sid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-jury.add');
// TODO Contest jury modify organization.contest-jury.modify
// TODO Contest jury remove organization.contest-jury.remove

/**
 * Organization Contest blueprint
 *
 * ContestAward
 *
 */
Route::get('/organization/contest/award/add/{cid}', Contest\Award\Add::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-award.add');
// TODO organization.contest-award.modify
// TODO organization.contest-award.remove

/**
 * User - Contest subscribe, add works, remove works
 *
 * user, and contest organization
 */
// user only
Route::get('/user/contest/subscribe/{cid}', Contest\Subscribe::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('user.contest.participate');
// user only
    Route::get('/user/contest/subscribe/{cid}/work/{wid}', Contest\Subscribe::class, ['cid', 'wid'])
    ->middleware(['auth', 'verified'])
    ->name('user.contest.add-work');
// user and contest organization
Route::delete('/user/contest/subscribe/remove/{pid}', Contest\Subscribe\Remove::class, ['pid'])
    ->middleware(['auth', 'verified'])
    ->name('user.contest.remove-work');

/**
 * Contest manage - Organization
 */
// Contest live - Organization contest dashboard
Route::get('/contest/dashboard/{cid}', Organization\ContestPanel::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('contest.dashboard');

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
    ->name('organization-contest.list');
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
