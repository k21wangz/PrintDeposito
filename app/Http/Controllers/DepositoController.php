<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use App\Models\Tanggal;
use App\Models\DepositoTanpaPajak;

class DepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $tanggal = [
             date('d/m/Y'), // Contoh tanggal
             // Tambahkan tanggal lain jika perlu
         ];

         $deposito = DB::table('m_deposito as d')
             ->join('transaksi as t', 'd.noacc', '=', 't.dokumen')
             ->leftJoin('tujuan_depos as td', 'd.noacc', '=', 'td.noacc_depo')
             ->select(
                 'd.nobilyet', // Pastikan untuk memilih nobilyet
                 'd.noacc',
                 'd.fnama',
                 'd.nominal',
                 'd.bnghitung',
                 'td.type_tran',
                 'td.norek_tujuan',
                 'td.an_tujuan',
                 'td.nama_bank',
                 DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                 DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                 DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
             )
             ->groupBy('d.nobilyet', 'd.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran', 'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank')
             ->where('d.kodecab', '=', auth()->user()->kodecab)
             ->get();
         
         return view('deposito.index', compact('tanggal', 'deposito'));
     }
    public function report(Request $request)
    {
        $pajakStatus = json_decode($request->pajakStatus, true) ?? [];
        
        $deposito = DB::table('m_deposito as d')
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
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran',
                'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank', 'tp.noacc')
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->get()
            ->map(function($item) {
                // Set pajak = 0 jika rekening ada di tabel bebas pajak
                if ($item->is_tax_free) {
                    $item->Tax_DEP = 0;
                }
                return $item;
            });
            
        $tanggal = Tanggal::all();
        
        return view('deposito.report', [
            'deposito' => $deposito,
            'tanggal' => $tanggal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePajak(Request $request)
    {
        $deposito = Deposito::where('noacc', $request->noacc)->first();
        $isPajakActive = $request->is_pajak;
        
        if ($deposito) {
            if (!$isPajakActive) {
                $deposito->Tax_DEP = 0;
                // Hitung ulang nilai-nilai terkait
                $deposito->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Pajak berhasil diupdate'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Deposito tidak ditemukan'
        ]);
    }

    public function printTiket1($nobilyet)
    {
        $deposito = Deposito::where('nobilyet', $nobilyet)->firstOrFail();
        $nominal = $deposito->nominal; // Ganti dengan field yang sesuai
        $jatuhTempo = $deposito->jatuhTempo; // Ganti dengan field yang sesuai
        $kewajibanSegera = $deposito->kewajibanSegera; // Ganti dengan field yang sesuai

        // Menghitung terbilang
        $terbilang = ucfirst(terbilang($nominal + $kewajibanSegera)); // Menggunakan ucfirst untuk huruf kapital

        // Mendapatkan tanggal saat ini
        $tanggal = date('d/m/Y');

        return view('report.tiket', compact('nominal', 'jatuhTempo', 'kewajibanSegera', 'deposito', 'terbilang', 'tanggal'));
    }

    public function printTiket2($nobilyet)
    {
        $deposito = Deposito::where('nobilyet', $nobilyet)->firstOrFail();
        $nominal = $deposito->nominal; // Ganti dengan field yang sesuai
        $tambahan = $deposito->tambahan; // Ganti dengan field yang sesuai
        $kewajibanSegera = $deposito->kewajibanSegera; // Ganti dengan field yang sesuai
        $jatuhTempo = $deposito->jatuhTempo; // Ganti dengan field yang sesuai

        // Menghitung terbilang
        $terbilang = ucfirst(terbilang($nominal + $kewajibanSegera)); // Menggunakan ucfirst untuk huruf kapital

        // Mendapatkan tanggal saat ini
        $tanggal = date('d/m/Y');

        return view('report.tiket2', compact('nominal', 'tambahan', 'kewajibanSegera', 'jatuhTempo', 'deposito', 'terbilang', 'tanggal'));
    }
}
