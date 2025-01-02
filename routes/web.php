<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\DepositoTanpaPajakController;
use App\Http\Controllers\DepositoPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboradController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('tujuandepo', \App\Http\Controllers\TujuanDepoController::class)->middleware(['auth', 'verified']);
Route::resource('deposito', \App\Http\Controllers\DepositoController::class)->middleware(['auth', 'verified']);
Route::get('/report', [DepositoController::class, 'report'])->name('deposito.report');
Route::post('/update-pajak', [DepositoController::class, 'updatePajak'])->name('update.pajak');
Route::resource('deposito-tanpa-pajak', DepositoTanpaPajakController::class);
Route::get('/deposito-pdf', [DepositoPdfController::class, 'generatePDF'])->name('deposito.pdf');
Route::get('/report2/{id}', [DepositoController::class, 'printTiket1'])->name('report.tiket1');
Route::get('/report3/{id}', [DepositoController::class, 'printTiket2'])->name('report.tiket2');
require __DIR__.'/auth.php';

