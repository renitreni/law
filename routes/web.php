<?php

use App\Http\Controllers\CaseClientController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CaseCourtController;
use App\Http\Controllers\CaseFileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LawCaseController;
use App\Http\Controllers\MatterController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Auth::routes();

// Inertia test route
Route::get('/inertia-test', function () {
    return Inertia::render('Welcome', ['message' => 'Inertia + React works!']);
})->name('inertia.test');

Route::middleware(['auth'])->group(function () {
    Route::resource('law-cases', LawCaseController::class);

    Route::prefix('law-cases/{lawCase}')->group(function () {
        Route::resource('clients', CaseClientController::class)->names('law-cases.clients');
        Route::resource('courts', CaseCourtController::class)->names('law-cases.courts');
        Route::resource('files', CaseFileController::class)->names('law-cases.files');
    });

    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::resource('options', OptionsController::class)->only(['index', 'store', 'destroy'])->names('options')->parameters(['options' => 'client']);
    Route::resource('matters', MatterController::class)->only(['index', 'store', 'destroy'])->names('matters')->parameters(['matters' => 'matter']);
    
    Route::prefix('matters/{matter}')->group(function () {
        Route::post('sub-matters', [MatterController::class, 'storeSubMatter'])->name('matters.storeSubMatter');
        Route::delete('sub-matters/{subMatter}', [MatterController::class, 'destroySubMatter'])->name('matters.destroySubMatter');
    });
    
    Route::prefix('case')->group(function () {
        Route::get('/', [CaseController::class, 'index'])->name('case');
        Route::get('/add', [CaseController::class, 'create'])->name('add_case');
        Route::post('/', [CaseController::class, 'store'])->name('case.store');
        Route::get('/edit/{lawCase}', [CaseController::class, 'edit'])->name('edit_case');
        Route::put('/{lawCase}', [CaseController::class, 'update'])->name('case.update');
        Route::delete('/{lawCase}', [CaseController::class, 'destroy'])->name('case.destroy');
        Route::get('/download/{file}', fn (string $file) => response()->download(Storage::path("public/case/{$file}")))->name('download_file');
    });
    
    Route::get('/inquiry', [InquiryController::class, 'index'])->name('inquiry');
    Route::resource('invoice', InvoiceController::class)->only(['index', 'store'])->names('invoice');
    Route::resource('photos', GalleryController::class)->only(['index', 'store', 'destroy'])->names('gallery');
    Route::get('/user', [UserController::class, 'index'])->name('user');
});
