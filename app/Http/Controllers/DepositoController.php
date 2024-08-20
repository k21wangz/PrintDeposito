<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $deposito = DB::table('m_deposito as d')
            ->join('transaksi as t', 'd.noacc', '=', 't.dokumen')
            ->leftJoin('tujuan_depos as td ', 'd.noacc', '=', 'td.noacc_depo')
            ->select(
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
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Bng DEP # an%' THEN t.nominal ELSE 0 END) AS Bng_Dep"),
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Penc Titipan Bunga%' THEN t.nominal ELSE 0 END) AS Penc_Titipan_Bunga")
            )
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung','td.type_tran',
                'td.norek_tujuan',
                'td.an_tujuan',
                'td.nama_bank')
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->orderBy('d.noacc')
            ->get();

        //menampilkan tanggal database
        $tanggal = DB::table('tanggal')->select('tgl')->get();


        return view('deposito.index', compact('tanggal','deposito'));
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
