<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * / home - splashscreen 
 * /yapcp - What is yapcp ?  
 */
Route::get('/', function () {
    return view('welcome');
});
Route::get('/yapcp', function (){
    return view('yapcp');
});

/**
 * /users/register - user add form 
 * /users/personalcard - user id 
 */
Route::get( '/users/register', [UserController::class, 'AddUserForm'])->name('addUserForm');
Route::post('/users/register', [UserController::class, 'AddUser'])->name('validateUserForm');
Route::get( '/users/home/{id}', [UserController::class, 'UserData'])->name('userHome');

// TODO Route::get( '/users/personalcard/{id}', [UserController::class, 'PersonalCard']);
