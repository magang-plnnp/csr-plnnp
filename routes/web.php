<?php

use App\Exports\ProposalExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TipologiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelayakanController;
use App\Http\Controllers\SubProsesController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\TipeProsesController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\BusinessSupportController;
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

Route::get('/tes', function () {
    return view('tes');
});
Route::get('/profile', function () {
    return view('profile.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/kabupaten', [WilayahController::class, 'getKabupaten']);
    Route::get('/kecamatan/{kabupatenId}', [WilayahController::class, 'getKecamatan']);
    Route::get('/kelurahan/{kecamatanId}', [WilayahController::class, 'getKelurahan']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('pengguna', UserController::class);
    Route::resource('tipologi', TipologiController::class);
    Route::resource('berita-acara', BeritaAcaraController::class);
    Route::post('/berita-acara/{id}/upload', [BeritaAcaraController::class, 'uploadFile'])->name('berita-acara.upload');
    Route::get('/berita-acara/{id}/bantuan', [BeritaAcaraController::class, 'getBantuan']);

    Route::resource('kelayakan', KelayakanController::class);
    Route::resource('proposal', ProposalController::class);
    Route::resource('tipe-proses', TipeProsesController::class);
    Route::resource('sub-proses', SubProsesController::class);
    Route::resource('proposal-proses-checklist', ProposalProsesChecklistController::class);
    Route::post('/sub-proses/reorder', [SubProsesController::class, 'reorder']);
    Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::post('/checklist/update', [ProposalProsesChecklistController::class, 'update'])->name('checklist.update');
    Route::post('/monitoring/keterangan/update', [MonitoringController::class, 'updateKeterangan'])->name('monitoring.keterangan');
    // Route::get('/export-proposals', function () {
    //     return Excel::download(new ProposalExport, 'data_proposal.xlsx');
    // });
    Route::get('/export-proposals', [ProposalController::class, 'export']);

    Route::get('/business-support', [BusinessSupportController::class, 'index'])->name('business-support.index');
Route::post('/business-support', [BusinessSupportController::class, 'update'])->name('business-support.update');

});
