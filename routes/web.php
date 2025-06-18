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
Route::post('/tujuandepo/get-tabungan-by-nocif', [App\Http\Controllers\TujuanDepoController::class, 'getTabunganByNocif'])->name('tujuandepo.getTabunganByNocif');

Route::get('/report-total-pajak', function() {
    $tanggalBunga = request('tanggal_bunga');
    $tanggal = $tanggalBunga ? [['tgl' => str_replace('-', '', $tanggalBunga)]] : [];
    $deposito = collect();
    if ($tanggalBunga) {
        $deposito = \DB::table('m_deposito as d')
            ->join('transaksi as t', 'd.noacc', '=', 't.dokumen')
            ->leftJoin('tujuan_depos as td', 'd.noacc', '=', 'td.noacc_depo')
            ->leftJoin('it_deposito_tanpa_pajak as tp', 'd.noacc', '=', 'tp.noacc')
            ->select(
                'd.noacc',
                'd.fnama',
                'd.nominal',
                'd.bnghitung',
                'td.type_tran',
                'td.norek_tujuan',
                'td.an_tujuan',
                'td.nama_bank',
                'tp.noacc as is_tax_free',
                'd.tgleff',
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran',
                'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank', 'tp.noacc', 'd.tgleff')
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->get();
        // Filter tanggal
        $deposito = $deposito->filter(function($item) use ($tanggalBunga) {
            $day = \Carbon\Carbon::createFromFormat('Ymd', $item->tgleff)->day;
            $groupedDate = \Carbon\Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
            return $groupedDate === $tanggalBunga;
        });
    }
    $data = [
        'deposito' => $deposito,
        'tanggal' => $tanggal
    ];
    return view('report-total-pajak', compact('data', 'tanggal'));
});

Route::get('/deposito-lalu', [DepositoController::class, 'history'])->name('deposito.history');

require __DIR__.'/auth.php';

