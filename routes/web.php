<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Federation;
use App\Livewire\ShowFederationList;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// rounte > model NO
// Route::get('/federation', Federation::class);
// route > component YES 
Route::get('/federation/list', ShowFederationList::class);
