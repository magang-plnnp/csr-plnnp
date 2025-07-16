<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipologiController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TipeProsesController;
use App\Http\Controllers\SubProsesController;
use App\Http\Controllers\ProposalProsesChecklistController;

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

Route::get('/', function () {
    return view('dashboard.index');
});


Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/tipologi', function () {
//     return view('manajemen-data.tipologi.index');
// });

// Route::get('/pengguna', function () {
//     return view('manajemen-data.pengguna.index');
// });

Route::resource('pengguna', UserController::class);
Route::resource('tipologi', TipologiController::class);
Route::resource('proposal', ProposalController::class);
Route::resource('tipe-proses', TipeProsesController::class);
Route::resource('sub-proses', SubProsesController::class);
Route::resource('proposal-proses-checklist', ProposalProsesChecklistController::class);
