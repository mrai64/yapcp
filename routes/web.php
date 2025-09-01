<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Federation;
use App\Livewire\Organization;
use Illuminate\Support\Facades\Auth;

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

Route::get(   '/federation/section/list/{fid}',  Federation\Section\Listed::class, ['fid'])->name('federation-section-list');
Route::get(   '/federation/section/add/{fid}',   Federation\Section\Add::class,    ['fid'])->name('add-federation-section');
Route::get(   '/federation/section/modify/{id}', Federation\Section\Modify::class, ['id'])->name('federation-section-modify');
Route::get(   '/federation/section/remove/{id}', Federation\Section\Remove::class, ['id'])->name('delete-federation-section');
Route::delete('/federation/section/remove/{id}', Federation\Section\Remove::class, ['id']);

Route::get(   '/organization/list',        Organization\Listed::class)->name('organization-list');
Route::get(   '/organization/add',         Organization\Add::class)->name('add-organization');
Route::get(   '/organization/modify/{id}', Organization\Modify::class, ['id'])->name('modify-organization');
Route::get(   '/organization/remove/{id}', Organization\Remove::class, ['id'])->name('delete-organization');
Route::delete('/organization/remove/{id}', Organization\Remove::class, ['id']);
