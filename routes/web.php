<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisSppdController;
use App\Http\Controllers\SppdController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\TujuanController;

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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'create'])->name('register.create');


Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    // Dashboard
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chart', [DashboardController::class, 'chart'])->name('chart');
    Route::get('/chartm', [DashboardController::class, 'chartM'])->name('chartm');

    // Surat

    Route::delete('/sppd/delete-by-no-surat', [SppdController::class, 'deleteByNoSurat'])->name('sppd.deleteByNoSurat');
    Route::resource('/sppd', SppdController::class);

    // SPPD
    Route::put('/sppd/{id}', [SppdController::class, 'update'])->name('sppd.updated');
     Route::post('/sppd/create/check-unique', [SppdController::class, 'checkUnique'])->name('check-unique');
    Route::delete('/sppd/edit/{id}', [SppdController::class, 'delete'])->name('edit.delete');
    Route::post('/sppd/{sppd}/check-unique', [SppdController::class, 'checkUnique'])->name('check-unique-edit');
   
    Route::get('/sppd/create/sisa-anggaran/{id}', [SppdController::class, 'getSisaAnggaran'])->name('sisa-anggaran');
    Route::get('/sppd/create/kendaraan', [SppdController::class, 'getKendaraan'])->name('kendaraan');
    Route::get('/sppd/{sppd}/edit/kendaraan', [SppdController::class, 'getKendaraan'])->name('kendaraan-edit');

    Route::get('/sppd/print/{id}', [SppdController::class, 'printPDF'])->name('pdf.sppd');
    Route::get('/sppd/{id}/docx', [SppdController::class, 'exportDocx'])->name('sppd.export-docx');
    Route::get('/export-xls', [SppdController::class, 'exportXls'])->name('sppd.export.xls');
   // Route::get('/rekap', [SppdController::class, 'previewExport'])->name('sppd.preview.export');

    // Laporan
    Route::get('/rekap', [RekapController::class, 'index'])->name('index');
    Route::post('/rekap/filter', [RekapController::class, 'filter'])->name('filter');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/pegawai', PegawaiController::class);
    Route::resource('/kegiatan', KegiatanController::class);
    Route::resource('/jenis', JenisSppdController::class);
    Route::resource('/tujuan', TujuanController::class);
    Route::resource('/dasar', App\Http\Controllers\DasarSppdController::class);
});