<?php

/**
 * web.php
 * livewire 4 Volt SFC with few exceptions
 *
 * Here are listed url with blade with middleware with name assigned at route
 * so when coded route('credits.notice') platform expose /credits
 * as relative url.
 *
 * Routes cannot be sorted. The seven action repeated schema is
 * 1. index
 * 2. create + store
 * 3. show
 * 4. edit + update
 * 5. delete
 *
 * Previous version is on ./web_stash.bak
 */

use App\Models\Federation as ModelsFederation;
use App\Models\FederationSection as ModelsFederationSection;
use App\Models\FederationMore as ModelsFederationMore;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// 1. Guest welcome and credits
Route::view('/', 'welcome')
    ->middleware(['throttle:welcome-page']) // rate limit
    ->name('welcome.aboard');
Route::view('/credits', 'credits')
    ->middleware(['throttle:welcome-page'])
    ->name('credits.notice');
// docs - thru login access

/**
 * User
 */
// login - jeststream job
// register - jetstream job
Volt::route('/user/dashboard', 'user.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

/**
 * UserContact
 */
// UserContact Add build with user registration
Volt::route('/user/contact/show', 'user.contact.show')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.show');
// userContact id
Volt::route('/user/contact/modify1/{user_contact}', 'user.contact.modify1')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.modify1');
// userContact postal address
Volt::route('/user/contact/modify2/{user_contact}', 'user.contact.modify2')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.modify2');
// userContact cellular
Volt::route('/user/contact/modify3/{user_contact}', 'user.contact.modify3')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.modify3');
// userContact social
Volt::route('/user/contact/modify4/{user_contact}', 'user.contact.modify4')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.modify4');
// userContact federation_more
Volt::route('/user/contact/modify5/{user_contact}', 'user.contact.modify5')
    ->middleware(['auth', 'verified'])
    ->name('user.contact.modify5');
// userContact remove no - remove is a job after n month of inactivity
//   and require also removing user works after backup
// TODO admin.user.listed userContact paginated list - for admin

/**
 * UserWork
 */
// aka user.gallery.add
Volt::route('/user/work/add', 'user.work.add')
    ->middleware(['auth', 'verified'])
    ->name('user.work.add');
Volt::route('/user/work/listed1', 'user.work.listed1')
    ->middleware(['auth', 'verified'])
    ->name('user.work.listed1');
Volt::route('/user/work/listed2', 'user.work.listed2')
    ->middleware(['auth', 'verified'])
    ->name('user.work.listed2');
Volt::route('/user/work/modify/{user_work}', 'user.work.modify')
    ->middleware(['auth', 'verified'])
    ->name('user.work.modify');
Volt::route('/user/work/remove/{user_work}', 'user.work.remove')
    ->middleware(['auth', 'verified'])
    ->name('user.work.remove');

/**
 * UserWorkMore
 */
// TODO user.workmore.add
// TODO user.workmore.listed no
// TODO user.workmore.modify
// TODO user.workmore.remove

/**
 * Organization
 */
Volt::route('/organization/listed', 'organization.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.listed');
Volt::route('/organization/add', 'organization.add')
    ->middleware(['auth', 'verified'])
    ->name('organization.add');
Volt::route('/organization/dashboard/{organization}', 'organization.dashboard')
    ->middleware(['auth', 'verified', 'can:view,organization'])
    ->name('organization.dashboard');
Volt::route('/organization/modify/{organization}', 'organization.modify')
    ->middleware(['auth', 'verified', 'can:update,organization'])
    ->name('organization.modify');
Volt::route('/organization/remove/{organization}', 'organization.remove')
    ->middleware(['auth', 'verified', 'can:delete,organization'])
    ->name('organization.remove');
// TODO
Volt::route('/organization/user/listed/{organization}', 'organization.user.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.user.listed');
Volt::route('/organization/user/add/{organization}', 'organization.user.add')
    ->middleware(['auth', 'verified'])
    ->name('organization.user.add');
// TODO
Volt::route('/organization/contest/listed/{organization}', 'organization.contest.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.contest.listed');

// Contest design
Volt::route('/organization/design/contest/make/{organization}', 'organization.design.contest.make')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.make');
Volt::route('/organization/design/contest/modify-name/{contest}', 'organization.design.contest.modify-name')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.modify-name');
Volt::route('/organization/design/contest/modify-calendar/{contest}', 'organization.design.contest.modify-calendar')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.modify-calendar');
Volt::route('/organization/design/contest/modify-url/{contest}', 'organization.design.contest.modify-url')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.modify-url');

// ContestSection design
Volt::route('/organization/design/contest-section/listed/{contest}', 'organization.design.contest-section.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-section.listed');
Volt::route('/organization/design/contest-section/add/{contest}', 'organization.design.contest-section.add')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-section.add');
Volt::route(
    '/organization/design/contest-section/modify/{contest_section}',
    'organization.design.contest-section.modify'
)
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-section.modify');
Volt::route(
    '/organization/design/contest-section/remove/{contest_section}',
    'organization.design.contest-section.remove'
)
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-section.remove');

// ContestJury design
Volt::route('/organization/design/contest-jury/listed/{contest}', 'organization.design.contest-jury.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-jury.listed');
Volt::route('/organization/design/contest-jury/add1/{contest_section}', 'organization.design.contest-jury.add1')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-jury.add1');
Volt::route('/organization/design/contest-jury/add2/{contest_section}', 'organization.design.contest-jury.add2')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-jury.add2');
Volt::route('/organization/design/contest-jury/add3/{contest_section}', 'organization.design.contest-jury.add3')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-jury.add3');
// no organization.design.contest-jury.modify
Volt::route('/organization/design/contest-jury/remove/{contest_jury}', 'organization.design.contest-jury.remove')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-jury.remove');

// ContestAwards design
Volt::route('/organization/design/contest-award/listed/{contest}', 'organization.design.contest-award.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-award.listed');
// Note: when contest_section is missing, prize is for contest
Volt::route('/organization/design/contest-award/add/{contest}/{contest_section?}', 'organization.design.contest-award.add')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-award.add');
Volt::route('/organization/design/contest-award/modify/{contest_award}', 'organization.design.contest-award.modify')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-award.modify');
Volt::route('/organization/design/contest-award/remove/{contest_award}', 'organization.design.contest-award.remove')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest-award.remove');
Volt::route('/organization/design/contest/detail/{contest}', 'organization.design.contest.detail')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.detail');


/**
 * Federation
 */
// for all registered user
Volt::route('/federation/listed', 'federation.listed')
    ->middleware(['auth', 'verified'])
    ->name('federation.listed');
// for admin group
Volt::route('/federation/add', 'federation.add')
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederation::class])
    ->name('federation.add');
Volt::route('/federation/modify/{federation}', 'federation.modify')
    ->middleware(['auth', 'verified', 'can:update,federation'])
    ->name('federation.modify');
Volt::route('/federation/remove/{federation}', 'federation.remove')
    ->middleware(['auth', 'verified', 'can:delete,federation'])
    ->name('federation.remove');

/**
 * Federation Section n themes
 * for admin
 */
// for all registered user
Volt::route('/federation-section/listed/{federation}', 'federation-section.listed')
    ->middleware(['auth', 'verified'])
    ->name('federation-section.listed');
// for admin group
Volt::route('/federation-section/add/{federation}', 'federation-section.add')
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederationSection::class])
    ->name('federation-section.add');
Volt::route('/federation-section/modify/{federation_section}', 'federation-section.modify')
    ->middleware(['auth', 'verified', 'can:update,' . ModelsFederationSection::class])
    ->name('federation-section.modify');
Volt::route('/federation-section/remove/{federation_section}', 'federation-section.remove')
    ->middleware(['auth', 'verified', 'can:delete,' . ModelsFederationSection::class])
    ->name('federation-section.delete');

/**
 * Federation More fields
 */
// for all registered user
Volt::route('/federation-more/listed/{federation}', 'federation-more.listed')
    ->middleware(['auth', 'verified'])
    ->name('federation-more.listed');
// for admin group
Volt::route('/federation-more/add/{federation}', 'federation-more.add')
    ->middleware(['auth', 'verified', 'can:create,' . ModelsFederationMore::class])
    ->name('federation-more.add');
Volt::route('/federation-more/modify/{federation_more}', 'federation-more.modify')
    ->middleware(['auth', 'verified', 'can:update,federation_more'])
    ->name('federation-more.modify');
Volt::route('/federation-more/remove/{federation_more}', 'federation-more.remove')
    ->middleware(['auth', 'verified', 'can:delete,federation_more'])
    ->name('federation-more.remove');

/**
 * User Contest
 */
// to build contest - see /organization/design upper
// user on contests
Volt::route('/user/contest/listed', 'user.contest.listed')
    ->middleware(['auth', 'verified'])
    ->name('user.contest.listed');
Volt::route('/user/contest/participate/{contest}', 'user.contest.participate')
    ->middleware(['auth', 'verified'])
    ->name('user.contest.participate');

/**
 * end of list
 */
