<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * / home - splashscreen 
 * /yapcp - What is yapcp ?  
 */
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/yapcp', function (){
    return view('yapcp');
});

/**
 * /users/register - user add form 
 * /users/home - user id 
 */
Route::get( '/users/register', [UserController::class, 'AddUserForm'])->name('addUserForm');
Route::post('/users/register', [UserController::class, 'AddUser'])->name('validateUserForm');
Route::get( '/users/home/{id}',[UserController::class, 'UserData'])->name('userHome');
// name loginForm
Route::get( '/login',  [UserController::class, 'LoginFormView'])->name('loginForm');
Route::post('/login',  [UserController::class, 'LoginValidateForm'])->name('login');
Route::post('/logout', [UserController::class, 'LogoutValidateForm'])->name('logout');
/**
 * user email verification
 * /email/verify 
 * /email/verify/{id}/{hash}
 * /email/verification-notification 
 * /profile
 */
Route::get( '/email/verify', function () {
    return view('auth.verify-email');    
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/users/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);