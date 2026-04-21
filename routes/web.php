<?php

/**
 * The Route board
 *
 * TODO dont' sort route by uri,
 * use the 5+2
 * 1. index
 * 2. create + store
 * 3. show
 * 4. edit + update
 * 5. delete
 *
 * That route board cover:
 * - [splashscreen n credits]
 * - User
 * - UserContact
 * - UserRole
 * - UserWork
 * - UserMore
 * - Federation
 * - FederationSection
 * - FederationMore (TODO)
 * - Organization
 * - Contest
 * - ContestPatronage (TODO)
 * - ContestSection
 * - ContestJury
 * - ContestAward
 * - ContestWork [contest live: user contest subscribe]
 * - [contest live: contest dashboard]
 * - UserWorkValidation [contest live: pre-jury verifications ]
 * - ContestWaitings [contest live: pre-jury verifications ]
 * - ContestVote
 * - [contest live: assign admissions]
 * - [contest live: assign awards]
 * - [contest closing: jury minute]
 * - [contest closing: federations reports]
 * - [contest closing: participants board] (CHECK|TODO)
 * - [contest closing: awarded works board] (CHECK|TODO)
 *
 * Note: middleware can be grouped? yes, but i prefer that way
 *
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
use App\Models\ContestJury as ModelsContestJury;
use App\Models\ContestSection as ModelsContestSection;
use App\Models\ContestWork as ModelsContestWork;
use App\Models\Federation as ModelsFederation;
use App\Models\FederationSection as ModelsFederationSection;
use App\Models\UserContact as ModelsUserContact;
use App\Models\UserRole as ModelsUserRole;
use App\Models\UserWork as ModelsUserWork;
use App\Models\Organization as ModelsOrganization;
use Illuminate\Support\Facades\Route;

/**
 * 1. no model - guest
 */

Route::view('/', 'welcome')
    ->name('welcome.aboard');
Route::view('/credits', 'credits')
    ->name('credits.notice');

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
// TODO user-contact list must be a user directory for admin use
// user-contact list - admin only
Route::get('/admin/user/contact/listed', User\Contact\Listed::class)
    ->middleware(['auth', 'verified', 'can:viewAny,' . ModelsUserContact::class])
    ->name('user-contact.listed');
// user-contact add - no,
// user-contact show - user | admin
Route::get('/user/contact/show/{userContact?}', User\Contact\Show::class)
->middleware(['auth', 'verified', 'can:view,' . ModelsUserContact::class])
->name('user-contact.show');
// user contact/ modify* - user herself/himself n admin
Route::get('/user/contact/modify1/{userContact?}', User\Contact\Modify1YouAre::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserContact::class])
    ->name('user-contact.modify1');
Route::get('/user/contact/modify2/{userContact?}', User\Contact\Modify2PostAddress::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserContact::class])
    ->name('user-contact.modify2');
Route::get('/user/contact/modify3/{userContact?}', User\Contact\Modify3Phones::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserContact::class])
    ->name('user-contact.modify3');
Route::get('/user/contact/modify4/{userContact?}', User\Contact\Modify4Socials::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserContact::class])
    ->name('user-contact.modify4');
Route::get('/user/contact/modify5/{federation}/{userContact?}', User\Contact\Modify5Feds::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserContact::class])
    ->name('user-contact.modify5'); // Add "federation more" required fields
// user-contact remove - no

/**
 * 4. UserRole
 *
 * user herself/himself and admin
 *
 */
Route::get('/user/dashboard/role', User\Role\Listed::class)
    ->middleware(['auth', 'verified', 'can:view,' . ModelsUserRole::class])
    ->name('user-role.list');
Route::get('/user/dashboard/role/federation/add', User\Role\Federation\Add::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserRole::class])
    ->name('user-role.add.federation');
Route::get('/user/dashboard/role/organization/add', User\Role\Organization\Add::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserRole::class])
    ->name('user-role.add.organization');
// TODO /user/dashboard/federation/list
// TODO /federation/member/list
// TODO /user/dashboard/organization/list
// TODO /organization/member/list

/**
 * 5. UserWork
 *
 * user herself/himself and admin
 *
 */
Route::get('/user/work/list', User\Work\Listed::class)
    ->middleware(['auth', 'verified', 'can:view,' . ModelsUserWork::class])
    ->name('user.gallery');
Route::get('/user/work/add', User\Work\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsUserWork::class])
    ->name('photo-box-add');
Route::get('/user/work/modify/{wid}', User\Work\Modify::class, ['wid'])
    ->middleware(['auth', 'verified', 'can:update,' . ModelsUserWork::class])
    ->name('photo-box-modify');
Route::get('/user/work/remove/{wid}', User\Work\Remove::class, ['wid'])
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsUserWork::class])
    ->name('delete-photo-box');
Route::delete('/user/work/remove/{wid}', User\Work\Remove::class, ['wid'])
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsUserWork::class]);


/**
 * Federation - admin only
 */
// Federation List - laravel no livewire
Route::get('/federation/listed', [FederationController::class, 'index'])
    ->name('federation.list');
// federation add, no livewire - admin
Route::get('/admin/federation/add', [FederationController::class, 'create'])
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederation::class])
    ->name('federation.add');
Route::post('/admin/federation/store', [FederationController::class, 'store'])
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederation::class])
    ->name('federation.store');
// TODO federation show
// federation edit update, livewire - admin
Route::get('/admin/federation/modify/{federation}', Federation\Modify::class, ['fid'])
    ->middleware(['auth', 'verified', 'can:update,federation'])
    ->name('federation.modify');
// TODO federation remove only in maintenance mode
Route::get('/admin/federation/remove/{federation}', Federation\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,federation'])
    ->name('federation.delete');
Route::delete('/admin/federation/remove/{federation}', Federation\Remove::class)
    ->middleware(['auth', 'livewire', 'can:delete,federation']);

/**
 * FederationSection - admin only
 */
// federation-section list - guest no admin
Route::get('/federation/section/list/{federation}', Federation\Section\Listed::class)
    ->name('federation-section.list');
// federation-section add  - admin
Route::get('/admin/federation/section/add/{federation}', Federation\Section\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederationSection::class])
    ->name('federation-section.add');
// federation-section show - no
// federation-section edit
Route::get('/admin/federation/section/modify/{federation-section}', Federation\Section\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,federation-section'])
    ->name('federation-section.modify');
// federation-section remove
Route::get('/admin/federation/section/remove/{federation-section}', Federation\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,federation-section'])
    ->name('federation-section.delete');
Route::delete('/admin/federation/section/remove/{federation-section}', Federation\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,federation-section']);

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
Route::get('/organization/listed', Organization\Listed::class)
    ->name('organization.list');
// organization add - admin | user member(organization)
Route::get('/user/organization/add', Organization\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsOrganization::class])
    ->name('user.organization.add');
// organization dashboard - admin | user member(organization)
Route::get('/organization/dashboard/{organization}', Organization\Dashboard::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsOrganization::class])
    ->name('organization.dashboard'); // no user.organization.dashboard
// organization edit modify - admin | user member(organization)
Route::get('/user/organization/modify/{organization}', Organization\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsOrganization::class])
    ->name('user.organization.modify');
// organization remove - admin
Route::get('/user/organization/remove/{organization}', Organization\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsOrganization::class])
    ->name('user.organization.delete');
Route::delete('/user/organization/remove/{organization}', Organization\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsOrganization::class]);
// no name()

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

Route::get('/contest/listed', Contest\Listed::class)
    ->middleware(['auth', 'verified'])
    ->name('contest.list');
Route::get('/organization/contest/add/{organization}', Contest\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsContest::class])
    ->name('organization.contest.add');
Route::get('/organization/contest/modify/{contest}', Contest\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsContest::class])
    ->name('organization.contest.modify');
// no contest delete, after backup it's soft-deleted then removed after years

/**
 * Organization Contest blueprint
 *
 * ContestSection
 *
 */
Route::get('/organization/contest/section/add/{contest}', Contest\Section\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsContestSection::class])
    ->name('organization.contest-section.add');
Route::get('/organization/contest/section/modify/{section}', Contest\Section\Modify::class)
    ->middleware(['auth', 'verified', 'can:update,' . ModelsContestSection::class])
    ->name('organization.contest-section.modify');
Route::get('/organization/contest/section/remove/{section}', Contest\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsContestSection::class])
    ->name('organization.contest-section.remove');
Route::delete('/organization/contest/section/remove/{section}', Contest\Section\Remove::class)
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsContestSection::class]);
// no name

/**
 * Organization Contest blueprint
 *
 * ContestJury
 *
 * organization members and admin
 *
 */
Route::get('/organization/contest/jury/add/{section}', Contest\Jury\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsContestJury::class])
    ->name('organization.contest-jury.add');
// TODO Contest jury modify organization.contest-jury.modify
// TODO Contest jury remove organization.contest-jury.remove

/**
 * Organization Contest blueprint
 *
 * ContestAward
 *
 * organization members
 *
 */
Route::get('/organization/contest/award/add/{contest}', Contest\Award\Add::class, ['cid'])
    ->middleware(['auth', 'verified'])
    ->name('organization.contest-award.add');
// TODO organization.contest-award.modify
// TODO organization.contest-award.remove

/**
 * User - Contest subscribe, add works, remove works
 *
 * user, and contest organization
 */
// **review mark** //
Route::get('/user/contest/subscribe/{contest}', Contest\Subscribe\Subscribe::class)
    ->middleware(['auth', 'verified', 'can:view,' . ModelsContestWork::class])
    ->name('user.contest.participate');
// user only
Route::get('/user/contest/add-work/{contest}/{user-work}', Contest\Subscribe\Add::class)
    ->middleware(['auth', 'verified', 'can:create,' . ModelsContestWork::class])
    ->name('user.contest.add-work');
// user and contest organization
Route::delete('/user/contest/remove/{contest-work}', Contest\Subscribe\Remove::class, ['pid'])
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsContestWork::class])
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
Route::get('/organization/contest/admit/before-final/{sid}', Organization\Admit\BeforeFinal::class, ['sid'])
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

// TODO list of open contest with board of participants
// TODO list of closed contest with board of winners
// TODO contest admitted and awarded thumb

/**
 * Contest manage - "latest" job: report for federations
 *
 * TODO contest id and federation id must be replaced by a contest instance
 * TODO   and a federation instance, but federation id must be removed
 *
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
