<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use App\Models\Tanggal;
use App\Models\DepositoTanpaPajak;
use Carbon\Carbon;

class DepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tanggal = [date('d/m/Y')];
        $deposito = \DB::table('m_deposito as d')
            ->join('transaksi as t', 'd.noacc', '=', 't.dokumen')
            ->leftJoin('tujuan_depos as td', 'd.noacc', '=', 'td.noacc_depo')
            ->leftJoin('it_deposito_tanpa_pajak as tp', 'd.noacc', '=', 'tp.noacc')
            ->select(
                'd.nobilyet',
                'd.noacc',
                'd.fnama',
                'd.nominal',
                'd.bnghitung',
                'td.type_tran',
                'td.norek_tujuan',
                'td.an_tujuan',
                'td.nama_bank',
                'd.tgleff',
                'd.jkwaktu',
                'd.rate',
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->groupBy('d.nobilyet', 'd.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran', 'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank', 'd.tgleff', 'd.jkwaktu', 'd.rate')
            ->get();

        // Kelompokkan berdasarkan tanggal bunga (format d-m-Y)
        $groupedDeposito = $deposito->groupBy(function($item) {
            $day = \Carbon\Carbon::createFromFormat('Ymd', $item->tgleff)->day;
            return \Carbon\Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
        });

        return view('deposito.index', compact('tanggal', 'deposito', 'groupedDeposito'));
    }

    public function report(Request $request)
    {
        $tanggalBunga = $request->get('tanggal_bunga');
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
                'd.tgleff',
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran',
                'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank', 'tp.noacc', 'd.tgleff')
            ->where('d.kodecab', '=', auth()->user()->kodecab);

        // Filter jika ada parameter tanggal_bunga
        if ($tanggalBunga) {
            // tanggal_bunga format d-m-Y, tgleff format Ymd
            $deposito = $deposito->get()->filter(function($item) use ($tanggalBunga) {
                $day = \Carbon\Carbon::createFromFormat('Ymd', $item->tgleff)->day;
                $groupedDate = \Carbon\Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
                return $groupedDate === $tanggalBunga;
            });
        } else {
            $deposito = $deposito->get();
        }

        $tanggal = collect([['tgl' => str_replace('-', '', $tanggalBunga)]]); // Untuk header periode

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
        // Get the deposito data with complex query
        $depositoQuery = \DB::table('m_deposito as d')
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
                'd.jkwaktu',
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Bng_DEP_Acru"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Tax DEP%' THEN t.nominal ELSE 0 END) AS Tax_DEP"),
                \DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->where('d.nobilyet', $nobilyet)
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran',
                'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank', 'tp.noacc', 'd.tgleff', 'd.jkwaktu');
            
        $deposito = $depositoQuery->first();
        
        if (!$deposito) {
            abort(404, 'Deposito not found');
        }

        $nominal = $deposito->nominal;
        $isTaxFree = \App\Models\DepositoTanpaPajak::where('noacc', $deposito->noacc)->exists();
        $pajak = $isTaxFree ? 0 : (float)($deposito->Tax_DEP ?? 0);
        $tambahan = $deposito->bnghitung ?? 0; // Using bnghitung as tambahan
        $kewajibanSegera = $deposito->Tax_DEP ?? 0; // Using Tax_DEP as kewajiban segera
        $jatuhTempo = $deposito->jkwaktu ?? 0; // Using jkwaktu (jangka waktu) field from database
        $bungaBersih = (float)($deposito->bnghitung ?? 0) - $pajak;

        // Calculate terbilang based on bungahitung + pajak
        $terbilang = ucfirst(terbilang($bungaBersih + ($deposito->Tax_DEP ?? 0)));

        // Get date from tanggal table and format it from DDMMYYYY to d/m/Y
        $tanggalData = DB::table('tanggal')->first();
        $tanggal = $tanggalData ? Carbon::createFromFormat('dmY', $tanggalData->tgl)->format('d/m/Y') : date('d/m/Y');

        return view('report.tiket2', compact('nominal', 'tambahan', 'kewajibanSegera', 'jatuhTempo', 'deposito', 'terbilang', 'tanggal','bungaBersih', 'isTaxFree','tanggal'));
    }
}
