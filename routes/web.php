<?php

use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\JenisApprovalController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\KaryawanController;
use App\Http\Controllers\web\PejabatApprovalController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;

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

// Halaman Login
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

// Halaman Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('check.user.login');
// Halaman Jenis Approval
Route::resource('jenis-approval', JenisApprovalController::class);
// Halaman Karyawan
Route::resource('karyawan', KaryawanController::class);
// Halaman Pengguna
Route::resource('user', UserController::class);
// Halaman Pejabat Approval
Route::resource('pejabat-approval', PejabatApprovalController::class);
