<?php

namespace App\Http\Controllers;

use App\Models\DepositoTanpaPajak;
use Illuminate\Http\Request;

class DepositoTanpaPajakController extends Controller
{
    public function index()
    {
        $rekening = DepositoTanpaPajak::all();
        return view('deposito.tanpa-pajak.index', compact('rekening'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'noacc' => 'required|unique:it_deposito_tanpa_pajak,noacc'
        ]);

        DepositoTanpaPajak::create([
            'noacc' => $request->noacc,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->user()->username
        ]);

        return redirect()->back()->with('success', 'Rekening berhasil ditambahkan ke daftar bebas pajak');
    }

    public function destroy($id)
    {
        DepositoTanpaPajak::destroy($id);
        return redirect()->back()->with('success', 'Rekening berhasil dihapus dari daftar bebas pajak');
    }
} 