<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\CaseFeature\AddCaseLivewire;
use App\Livewire\CaseLivewire;
use App\Livewire\GalleryLivewire;
use App\Livewire\InquiryLivewire;
use App\Livewire\MatterLivewire;
use App\Livewire\OptionsLivewire;
use App\Livewire\TimesheetLivewire;
use App\Livewire\UserLivewire;

Route::get('/',function(){
    return redirect(route('welcome',['lang'=>'en']));
});

Route::get('/{lang?}',[HomeController::class,'index'])->name('welcome');
Route::get('/{lang?}/about',[HomeController::class,'about'])->name('about');
Route::get('/{lang?}/attorneys',[HomeController::class,'attorneys'])->name('attorneys');
Route::get('/{lang?}/list-services',[HomeController::class,'services'])->name('services');
Route::get('/{lang?}/gallery',[HomeController::class,'gallery'])->name('galleries');
Route::get('/{lang?}/contact',[HomeController::class,'contact'])->name('contact');
Route::get('/{lang?}/inquire',[HomeController::class,'inquire'])->name('inquire');
Route::get('/{lang?}/services/{service}',[HomeController::class,'service'])->name('service');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/timesheet', TimesheetLivewire::class)->name('timesheet');
    Route::get('/options', OptionsLivewire::class)->name('options');
    Route::get('/matters', MatterLivewire::class)->name('matters');
    Route::prefix('case')->group(function(){
        Route::get('/', CaseLivewire::class)->name('case');
        Route::get('/add', AddCaseLivewire::class)->name('add_case');
    });
    Route::get('/inquiry', InquiryLivewire::class)->name('inquiry');
    Route::get('/photos', GalleryLivewire::class)->name('gallery');
    Route::get('/user', UserLivewire::class)->name('user');
});
