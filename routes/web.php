<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\CaseFeature\AddCaseLivewire;
use App\Livewire\CaseFeature\EditCaseLivewire;
use App\Livewire\CaseLivewire;
use App\Livewire\GalleryLivewire;
use App\Livewire\InquiryLivewire;
use App\Livewire\MatterLivewire;
use App\Livewire\OptionsLivewire;
use App\Livewire\TimesheetLivewire;
use App\Livewire\UserLivewire;

Route::get('/', function () {
    return redirect(route('welcome', ['lang' => 'en']));
});



Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/timesheet', TimesheetLivewire::class)->name('timesheet');
    Route::get('/options', OptionsLivewire::class)->name('options');
    Route::get('/matters', MatterLivewire::class)->name('matters');
    Route::prefix('case')->group(function () {
        Route::get('/', CaseLivewire::class)->name('case');
        Route::get('/add', AddCaseLivewire::class)->name('add_case');
        Route::get('/edit/{id}', EditCaseLivewire::class)->name('edit_case');
    });
    Route::get('/inquiry', InquiryLivewire::class)->name('inquiry');
    Route::get('/photos', GalleryLivewire::class)->name('gallery');
    Route::get('/user', UserLivewire::class)->name('user');
});


Route::prefix("/{lang?}")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/attorneys', [HomeController::class, 'attorneys'])->name('attorneys');
    Route::get('/list-services', [HomeController::class, 'services'])->name('services');
    Route::get('/gallery', [HomeController::class, 'gallery'])->name('galleries');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/inquire', [HomeController::class, 'inquire'])->name('inquire');
    Route::get('/list-services/{service}', [HomeController::class, 'service'])->name('service');
});
