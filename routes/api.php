<?php

use App\Http\Controllers\Api\ApprovalPengajuanController;
use App\Http\Controllers\Api\JenisApprovalController;
use App\Http\Controllers\Api\JenisTransaksiController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PejabatApprovalController;
use App\Http\Controllers\Api\PenerimaanLangsungController;
use App\Http\Controllers\Api\PengajuanController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\RealisasiPengajuanController;
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
    Route::get('/get-nomoraju', [PengajuanController::class, 'getNomor']);
    Route::apiResource('/penerimaan-langsung', PenerimaanLangsungController::class);
    Route::get('/get-nomortpl', [PenerimaanLangsungController::class, 'getNomor']);
    Route::apiResource('/realisasi-pengajuan', RealisasiPengajuanController::class);
    Route::get('/show-verifikasi', [ApprovalPengajuanController::class, 'getPengajuanVerifikasi']);
    Route::get('/show-keuangan', [ApprovalPengajuanController::class, 'getPengajuanKeuangan']);
    Route::get('/show-direksi', [ApprovalPengajuanController::class, 'getPengajuanDireksi']);
});
Route::post('/logout', LogoutController::class)->name('logout');
