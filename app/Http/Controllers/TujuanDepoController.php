<?php

namespace App\Http\Controllers;

use App\Models\TujuanDepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TujuanDepoController extends Controller
{
    public function create()
    {
        $noaccList = DB::table('m_deposito')->select('noacc', 'fnama')->where('kodecab', '=', auth()->user()->kodecab)->get();
        return view('tujuandepo.create', compact('noaccList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_tran' => 'required|in:cash,tabungan,transfer',
            'norek_tujuan' => 'nullable|string',
            'an_tujuan' => 'nullable|string',
            'nama_bank' => 'nullable|string',
            'noacc_depo' => 'required|unique:tujuan_depos,noacc_depo',
        ]);

        $tujuandepo = TujuanDepo::create([
            'type_tran' => $request->type_tran,
            'norek_tujuan' => $request->norek_tujuan,
            'an_tujuan' => $request->an_tujuan,
            'nama_bank' => $request->nama_bank,
            'noacc_depo' => $request->noacc_depo,
        ]);

        return redirect()->route('tujuandepo.index')->with('success', 'Transaction purpose created successfully.');
    }

    // Read
    public function index()
    {
        $transactionPurposes = TujuanDepo::all();
        return view('tujuandepo.index', compact('transactionPurposes'));
    }

    public function show($id)
    {
        $transactionPurpose = TujuanDepo::find($id);
        return view('tujuandepo.show', compact('transactionPurpose'));
    }

    // Update
    public function edit($id)
    {
        $transactionPurpose = TujuanDepo::find($id);
        return view('tujuandepo.edit', compact('transactionPurpose'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'purpose_type' => 'required|in:cash,tabungan,transfer',
            'account_number' => 'nullable|string',
            'account_holder_name' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'noacc_depo' => "required|unique:tujuan_depos,noacc_depo,$id",
        ]);

        $transactionPurpose = TujuanDepo::find($id);
        $transactionPurpose->update($request->all());

        return redirect()->route('tujuandepo.index')->with('success', 'Transaction purpose updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        $transactionPurpose = TujuanDepo::find($id);
        $transactionPurpose->delete();

        return redirect()->route('tujuandepo.index')->with('success', 'Transaction purpose deleted successfully.');
    }
}
