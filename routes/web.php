<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\OptionsLivewire;
use App\Http\Livewire\TimesheetLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', HomeController::class)->only(['index']);

Auth::routes();

Route::middleware(['auth'])->group(function(){
    Route::get('/timesheet', TimesheetLivewire::class)->name('timesheet');
    Route::get('/options', OptionsLivewire::class)->name('options');
});
