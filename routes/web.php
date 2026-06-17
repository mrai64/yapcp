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
Volt::route('/user/organization/listed', 'user.organization.listed')
    ->middleware(['auth', 'verified'])
    ->name('user.organization.listed');
Volt::route('/user/organization/add', 'user.organization.add')
    ->middleware(['auth', 'verified'])
    ->name('user.organization.add');


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
