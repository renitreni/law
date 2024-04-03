<?php

use App\Http\Controllers\HomeController;
use App\Livewire\CaseLivewire;
use App\Livewire\GalleryLivewire;
use App\Livewire\InquiryLivewire;
use App\Livewire\MatterLivewire;
use App\Livewire\OptionsLivewire;
use App\Livewire\TimesheetLivewire;
use App\Livewire\UserLivewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/about', 'about');
Route::view('/attorneys', 'attorneys');
Route::view('/list-services', 'services');
Route::view('/gallery', 'gallery');
Route::view('/contact', 'contact');
Route::view('/inquire', 'inquire');
Route::get('/services/{service}', [HomeController::class, 'service'])->name('service');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/timesheet', TimesheetLivewire::class)->name('timesheet');
    Route::get('/options', OptionsLivewire::class)->name('options');
    Route::get('/matters', MatterLivewire::class)->name('matters');
    Route::get('/case', CaseLivewire::class)->name('case');
    Route::get('/inquiry', InquiryLivewire::class)->name('inquiry');
    Route::get('/photos', GalleryLivewire::class)->name('gallery');
    Route::get('/user', UserLivewire::class)->name('user');
});
