<?php

namespace App\Http\Controllers;

use App\Models\TujuanDepo;
use Illuminate\Http\Request;

class TujuanDepoController extends Controller
{
    public function index()
    {
        $tujuanDepos = TujuanDepo::all();
        return view('tujuandepo.index', compact('tujuanDepos'));
    }

    public function create()
    {
        return view('tujuandepo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'noacc_depo' => 'required',
            'type_tran' => 'required|in:TAB,TRF,CASH',
            'norek_tujuan' => 'required',
            'an_tujuan' => 'required',
            'nama_bank' => 'required'
        ]);

        TujuanDepo::create($request->all());
        return redirect()->route('tujuandepo.index')
            ->with('success', 'Data tujuan deposito berhasil ditambahkan');
    }

    public function show($id)
    {
        $tujuanDepo = TujuanDepo::findOrFail($id);
        return view('tujuandepo.show', compact('tujuanDepo'));
    }

    public function edit($id)
    {
        $tujuanDepo = TujuanDepo::findOrFail($id);
        return view('tujuandepo.edit', compact('tujuanDepo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'noacc_depo' => 'required',
            'type_tran' => 'required|in:TAB,TRF,CASH',
            'norek_tujuan' => 'required',
            'an_tujuan' => 'required',
            'nama_bank' => 'required'
        ]);

        $tujuanDepo = TujuanDepo::findOrFail($id);
        $tujuanDepo->update($request->all());

        return redirect()->route('tujuandepo.index')
            ->with('success', 'Data tujuan deposito berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tujuanDepo = TujuanDepo::findOrFail($id);
        $tujuanDepo->delete();

        return redirect()->route('tujuandepo.index')
            ->with('success', 'Data tujuan deposito berhasil dihapus');
    }
}
