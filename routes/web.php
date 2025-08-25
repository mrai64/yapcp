<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Federation;
use App\Livewire\Organization;

Route::view('/', 'welcome');

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
Route::get(   '/federation/add',         Federation\Add::class)->name('add-federation');
Route::get(   '/federation/list',        Federation\Listed::class)->name('federation-list');
Route::get(   '/federation/modify/{id}', Federation\Modify::class, ['id'])->name('modify-federation');
Route::get(   '/federation/remove/{id}', Federation\Remove::class, ['id'])->name('delete-federation');
Route::delete('/federation/remove/{id}', Federation\Remove::class, ['id']);

Route::get(   '/organization/list',      Organization\Listed::class)->name('organization-list');
