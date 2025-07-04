<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboradController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depositos = Deposito::all()->where('kodecab','=',auth()->user()->kodecab);
        $dphi = DB::table('m_deposito')
            ->join('transaksi', 'm_deposito.noacc', '=', 'transaksi.dokumen')
            ->where('m_deposito.kodecab', '=', auth()->user()->kodecab)
            ->where('transaksi.ket', 'LIKE', 'Bng DEP Acru# an.%')
            ->count('m_deposito.noacc');

        // Kelompokkan berdasarkan tanggal bunga (format d-m-Y)
        $groupedDepositos = $depositos->groupBy(function($item) {
            // Ambil hari dari tgleff, buat tanggal bunga di bulan & tahun sekarang
            $day = \Carbon\Carbon::createFromFormat('Ymd', $item->tgleff)->day;
            return \Carbon\Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
        });

        return view('dashboard', [
            'depositos' => $depositos,
            'dphi' => $dphi,
            'groupedDepositos' => $groupedDepositos
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
}
