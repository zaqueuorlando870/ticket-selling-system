<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Event\Index;
use App\Livewire\Event\Create;
use App\Livewire\Event\Edit;
use App\Livewire\Admin\UsersList;
use App\Livewire\Guest\EventCatalog;
use App\Livewire\Admin\PurchaseList;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', EventCatalog::class)->name('welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/event', Index::class)->name('event.index');
    Route::get('/event/create', Create::class)->name('event.create');
    Route::get('/event/{event}/edit', Edit::class)->name('event.edit');
    Route::get('/admin/users', UsersList::class)->name('admin.users');
    Route::get('/admin/purchases', PurchaseList::class)->name('admin.purchases');
});

require __DIR__.'/auth.php';
