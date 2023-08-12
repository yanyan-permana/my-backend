<?php

use App\Http\Controllers\Api\ApprovalPengajuanController;
use App\Http\Controllers\Api\BuktiTransaksiController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HistoryPengajuanController;
use App\Http\Controllers\Api\JenisApprovalController;
use App\Http\Controllers\Api\JenisTransaksiController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\LaporanPenerimaanController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PejabatApprovalController;
use App\Http\Controllers\Api\PenerimaanLangsungController;
use App\Http\Controllers\Api\PengajuanController;
use App\Http\Controllers\Api\PertanggungJawabanController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RealisasiPengajuanController;
use App\Http\Controllers\Api\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    Route::apiResource('/karyawan', KaryawanController::class);
    Route::get('/total-karyawan', [KaryawanController::class, 'getTotalKaryawan']);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/jenis-approval', JenisApprovalController::class);
    Route::apiResource('/jenis-transaksi', JenisTransaksiController::class);
    Route::apiResource('/pejabat-approval', PejabatApprovalController::class);
    Route::apiResource('/pengajuan', PengajuanController::class);
    Route::get('/pengajuan-byuser/{id}', [PengajuanController::class, 'getByUseId']);
    Route::get('/get-nomoraju', [PengajuanController::class, 'getNomor']);
    Route::apiResource('/penerimaan-langsung', PenerimaanLangsungController::class);
    Route::get('/get-nomortpl', [PenerimaanLangsungController::class, 'getNomor']);
    Route::apiResource('/realisasi-pengajuan', RealisasiPengajuanController::class);
    Route::get('/get-nomorrpl', [RealisasiPengajuanController::class, 'getNomor']);
    Route::apiResource('/pertanggung-jawaban', PertanggungJawabanController::class);
    Route::apiResource('/bukti-transaksi', BuktiTransaksiController::class);
    Route::get('/get-nomortgjwb', [PertanggungJawabanController::class, 'getNomor']);
    Route::get('/show-verifikasi', [ApprovalPengajuanController::class, 'getPengajuanVerifikasi']);
    Route::get('/show-keuangan', [ApprovalPengajuanController::class, 'getPengajuanKeuangan']);
    Route::get('/show-direksi', [ApprovalPengajuanController::class, 'getPengajuanDireksi']);
    Route::get('/show-app-pengajuan/{ajuid}', [ApprovalPengajuanController::class, 'getPengajuanById']);
    Route::post('/app-verifikasi/{ajuid}', [ApprovalPengajuanController::class, 'approveVerifikasi']);
    Route::post('/app-keuangan/{ajuid}', [ApprovalPengajuanController::class, 'approveKeuangan']);
    Route::post('/app-direksi/{ajuid}', [ApprovalPengajuanController::class, 'approveDireksi']);
    Route::get('/load-pengajuan', [RealisasiPengajuanController::class, 'loadPengajuan']);
    Route::get('/load-realisasi', [PertanggungJawabanController::class, 'loadRealisasi']);
    Route::apiResource('/history-pengajuan', HistoryPengajuanController::class);
    Route::get('/history-pengajuan-byuser/{id}', [HistoryPengajuanController::class, 'getByUser']);
    Route::get('/pengajuan-terakhir/{id}', [HistoryPengajuanController::class, 'getPengajuanTrakhir']);
    Route::get('/laporan-penerimaan', [LaporanPenerimaanController::class, 'index']);
    Route::get('/laporan-penerimaan/{id}', [LaporanPenerimaanController::class, 'getRincianPenerimaan']);
    Route::get('/rincian-laporan-penerimaan', [LaporanPenerimaanController::class, 'getRincianPenerimaanByDate']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/karyawan/{id}', [DashboardController::class, 'getByKaryawanId']);
    Route::get('/dashboard/karyawan', [DashboardController::class, 'getAllByKaryawan']);
});
Route::post('/logout', LogoutController::class)->name('logout');


Route::post('/lupa-password', [ResetPasswordController::class, 'index']);
Route::post('/cek-top', [ResetPasswordController::class, 'checkOtp']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);