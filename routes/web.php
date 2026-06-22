<?php

/**
 * reviewed web.php
 *
 * ! No ⚡️ in Volt prefix
 *
 * Route::method() and Volt::route() are listed
 * in groups
 *
 * TODO dont' sort route by uri,
 * use the 5+2
 * 1. index
 * 2. create + store
 * 3. show
 * 4. edit + update
 * 5. delete
 *
 */


use App\Livewire\User;
use App\Models\Federation as ModelsFederation;
use Livewire\Volt\Volt;
//
use Illuminate\Support\Facades\Route;

// 1. welcome and credits
Route::view('/', 'welcome')
    ->name('welcome.aboard');
Route::view('/credits', 'credits')
    ->name('credits.notice');
// login - jeststream
// register - jetstream
// docs - funziona con login

/**
 * User dashboard
 */
Volt::route('/user/dashboard', 'user.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

/**
 * UserContact
 */
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
// TODO
Volt::route('/organization/user/add/{organization}', 'organization.user.add')
    ->middleware(['auth', 'verified'])
    ->name('organization.user.add');
// TODO
Volt::route('/organization/contest/listed/{organization}', 'organization.contest.listed')
    ->middleware(['auth', 'verified'])
    ->name('organization.contest.listed');
Volt::route('/organization/design/contest/make/{organization}', 'organization.design.contest.make')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.make');
Volt::route('/organization/design/contest/modify1/{contest}', 'organization.design.contest.modify1')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.contest.modify1');

/**
 * Federation
 */
Volt::route('/federation/listed', 'federation.listed')
    ->middleware(['auth', 'verified'])
    ->name('federation.listed');
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
 */
Volt::route('/federation-section/listed/{federation}', 'federation-section.listed')
    ->middleware(['auth', 'verified'])
    ->name('federation-section.listed');

/**
 * Contest
 */
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
