<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TopupController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RiwayatTransaksiController;

Route::get('/', function() {
    return view('home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::middleware([MemberMiddleware::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('/topup', [TopupController::class, 'index'])->name('topup.index');
        Route::post('/topup', [TopupController::class, 'store'])->name('topup.store');

        Route::prefix('pembayaran')->middleware('auth')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('pembayaran.index');

            Route::get('/pulsa', [PembayaranController::class, 'beliPulsa'])->name('pembayaran.pulsa');
            Route::post('/pulsa', [PembayaranController::class, 'prosesPulsa'])->name('pembayaran.pulsa.proses');

            Route::get('/token-listrik', [PembayaranController::class, 'beliToken'])->name('pembayaran.token');
            Route::post('/token-listrik', [PembayaranController::class, 'prosesToken'])->name('pembayaran.token.proses');

            Route::get('/qr', [PembayaranController::class, 'bayarQr'])->name('pembayaran.qr');
            Route::post('/qr', [PembayaranController::class, 'prosesQr'])->name('pembayaran.qr.proses');

            Route::get('/investasi/dollar', [PembayaranController::class, 'investasiDollar'])->name('pembayaran.investasi.dollar');
            Route::get('/investasi/dollar-rate', [PembayaranController::class, 'getDollarRate']);
            Route::post('/investasi/dollar', [PembayaranController::class, 'investasiDollarInvest'])->name('pembayaran.investasi.dollar.invest');
        });

        Route::get('/transfer', [TransferController::class, 'index'])->name('transfer.index');
        Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');

        Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('riwayat-transaksi.index');

        Route::get('/profil', [UserController::class, 'profil'])->name('profil.index');

    });

    Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard.index');


        Route::get('/topup', [TopupController::class, 'adminIndex'])->name('admin.topup.index');
        Route::post('/topup/{id}/verifikasi', [TopupController::class, 'verifikasi'])->name('admin.topup.verifikasi');
        Route::post('/topup/{id}/tolak', [TopupController::class, 'tolak'])->name('admin.topup.tolak');

        Route::get('/pembayaran', [PembayaranController::class, 'adminIndex'])->name('admin.pembayaran.index');

        Route::get('/transfer', [TransferController::class, 'adminIndex'])->name('admin.transfer.index');

        Route::get('/users', [UserController::class, 'adminIndex'])->name('admin.users.index');
    });


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
