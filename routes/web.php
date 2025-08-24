<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Federation;
use App\Livewire\ShowFederationList;
use App\Livewire\AddFederation;
use App\Livewire\DeleteFederation;
use App\Livewire\ModifyFederation;

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
Route::get(   '/federation/list',        ShowFederationList::class)->name('federation-list');
Route::get(   '/federation/add',         AddFederation::class)->name('add-federation');
Route::get(   '/federation/modify/{id}', ModifyFederation::class, ['id'])->name('modify-federation');
Route::delete('/federation/remove/{id}', DeleteFederation::class, ['id']);
Route::get(   '/federation/remove/{id}', DeleteFederation::class, ['id'])->name('delete-federation');