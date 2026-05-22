<?php

use App\Livewire\Admin\GeslachtBeheren;
use App\Livewire\Admin\kledingBeheren;
use App\Livewire\Admin\MailsBeheren;
use App\Livewire\Admin\TakenBeheren;
use App\Livewire\Admin\Usersbeheren;
use App\Livewire\HomePage;
use App\Livewire\Ouders\AfwezigheidWedstrijdhulp;
use App\Livewire\Ouders\CarpoolBeheren;
use App\Livewire\Albums;
use App\Livewire\Ouders\OpgevenWedstrijdhulp;
use App\Livewire\Photos;
use App\Livewire\Trainer\AlbumsBeheren;
use App\Livewire\Trainer\BetalingRegistreren;
use App\Livewire\Trainer\OnaangekondigdeAanwezigheidRegistreren;
use App\Livewire\Trainer\PhotosBeheren;
use App\Livewire\Trainer\TrainingBeheren;
use App\Livewire\Trainer\Spelersbeheren;
use App\Livewire\Trainer\WedstrijdBeheren;
use Illuminate\Support\Facades\Route;
use \App\Livewire\Trainer\Trainer;
use \App\Livewire\Ouders\Ouders;
use \App\Livewire\Delegee\Delegee;
use \App\Livewire\Admin\Admin;
use \App\Livewire\Kalender;

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



Route::get('/', HomePage::class)->name('home');

Route::get('kalender', Kalender::class)->name('kalender');
Route::get('albums', Albums::class)->name('albums');
Route::get('photos/{albumId}', Photos::class)->name('photos');

// ouder
Route::middleware(['auth', 'ouder', 'active'])->prefix('ouder')->name('ouder.')->group(function () {
    Route::get('dashboard', Ouders::class)->name('ouders-dashboard');
    Route::get('carpools', CarpoolBeheren::class)->name('carpool-beheren');
    Route::get('opgevenWedstrijdhulp', OpgevenWedstrijdhulp::class)->name('opgevenWedstrijdhulp');
    Route::get('afwezigheidWedstrijdhulp', AfwezigheidWedstrijdhulp::class)->name('afwezigheidWedstrijdhulp');
});

// Delegee
Route::middleware(['auth', 'delegee', 'active'])->prefix('delegee')->name('delegee.')->group(function () {
    Route::get('dashboard', Delegee::class)->name('delegee-dashboard');
});

// trainer
Route::middleware(['auth', 'trainer', 'active'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('dashboard', Trainer::class)->name('trainer-dashboard');
    Route::get('trainingBeheren', TrainingBeheren::class)->name('trainingBeheren');
    Route::get('albumsBeheren', AlbumsBeheren::class)->name('albumsBeheren');
    Route::get('wedstrijdBeheren', WedstrijdBeheren::class)->name('wedstrijdBeheren');
    Route::get('betalingRegistreren', BetalingRegistreren::class)->name('betalingRegistreren');
    Route::get('spelersbeheren', Spelersbeheren::class)->name('spelersbeheren');
    Route::get('photosBeheren/{albumId}', PhotosBeheren::class)->name('photosBeheren');
});

// admin
Route::middleware(['auth', 'admin', 'active'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', Admin::class)->name('admin-dashboard');
    Route::get('geslachtBeheren', GeslachtBeheren::class)->name('geslachtBeheren');
    Route::get('takenbeheren', TakenBeheren::class)->name('takenBeheren');
    Route::get('kledingbeheren', kledingBeheren::class)->name('kledingBeheren');
    Route::get('usersbeheren', Usersbeheren::class)->name('usersbeheren');
    Route::get('mailsbeheren', MailsBeheren::class)->name('mailsbeheren');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'active'
])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->check()) {
            if (auth()->user()->role_id == 1) {
                return redirect()->route('trainer.trainer-dashboard');
            } elseif (auth()->user()->role_id == 2) {
                return redirect()->route('delegee.delegee-dashboard');
            } elseif (auth()->user()->role_id == 4) {
                return redirect()->route('ouder.ouders-dashboard');
            } elseif (auth()->user()->role_id == 5) {
                return redirect()->route('admin.admin-dashboard');
            } else {
                return redirect()->route('home');
            }
        }
        return redirect('/');
    })->name('dashboard');
});
