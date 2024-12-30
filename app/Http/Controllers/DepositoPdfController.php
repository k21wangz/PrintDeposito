<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposito;
use PDF;
use Carbon\Carbon;

class DepositoPdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        $tanggal = DB::table('transaksi')
            ->select('tgl')
            ->where('kodecab', auth()->user()->kodecab)
            ->groupBy('tgl')
            ->get();

        $deposito = DB::table('m_deposito as d')
            ->join('transaksi as t', 'd.noacc', '=', 't.dokumen')
            ->leftJoin('tujuan_depos as td', 'd.noacc', '=', 'td.noacc_depo')
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
                DB::raw("MAX(CASE WHEN t.ket LIKE '%Sisa Bng DEP Acru%' THEN t.nominal ELSE 0 END) AS Sisa_Bng_Accru")
            )
            ->groupBy('d.noacc', 'd.fnama', 'd.nominal', 'd.bnghitung', 'td.type_tran',
                'td.norek_tujuan', 'td.an_tujuan', 'td.nama_bank')
            ->where('d.kodecab', '=', auth()->user()->kodecab)
            ->get();

        $data = [
            'tanggal' => $tanggal,
            'deposito' => $deposito,
            'title' => 'Laporan Deposito'
        ];

        $pdf = PDF::loadView('deposito.report-pdf', $data);
        
        // Set paper size to A4
        $pdf->setPaper('A4', 'portrait');
        
        // Optional: Set PDF properties
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);

        // Generate filename with current date
        $filename = 'Laporan_Deposito_' . Carbon::now()->format('d-m-Y') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }
} 