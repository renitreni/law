<?php

use App\Livewire\CaseFeature\AddCaseLivewire;
use App\Livewire\CaseFeature\EditCaseLivewire;
use App\Livewire\CaseLivewire;
use App\Livewire\GalleryLivewire;
use App\Livewire\InquiryLivewire;
use App\Livewire\InvoiceLivewire;
use App\Livewire\MatterLivewire;
use App\Livewire\OptionsLivewire;
use App\Livewire\TimesheetLivewire;
use App\Livewire\UserLivewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/timesheet', TimesheetLivewire::class)->name('timesheet');
    Route::get('/options', OptionsLivewire::class)->name('options');
    Route::get('/matters', MatterLivewire::class)->name('matters');
    Route::prefix('case')->group(function () {
        Route::get('/', CaseLivewire::class)->name('case');
        Route::get('/add', AddCaseLivewire::class)->name('add_case');
        Route::get('/edit/{id}', EditCaseLivewire::class)->name('edit_case');
        Route::get('/download/{file}', fn (string $file) => response()->download(Storage::path("public/case/{$file}")))->name('download_file');
    });
    Route::get('/inquiry', InquiryLivewire::class)->name('inquiry');
    Route::get('/invoice', InvoiceLivewire::class)->name('invoice');
    Route::get('/photos', GalleryLivewire::class)->name('gallery');
    Route::get('/user', UserLivewire::class)->name('user');
});
