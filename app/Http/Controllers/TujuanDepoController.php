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
        $noaccList = \DB::table('m_deposito')->select('noacc', 'fnama', 'nocif')->get();
        return view('tujuandepo.create', compact('noaccList'));
    }

    public function store(Request $request)
    {
        $rules = [
            'noacc_depo' => 'required',
            'type_tran' => 'required|in:Cash,Tabungan,Transfer',
        ];
        // Field lain hanya wajib jika bukan Cash
        if ($request->type_tran !== 'Cash') {
            $rules['norek_tujuan'] = 'required';
            $rules['an_tujuan'] = 'required';
            $rules['nama_bank'] = 'required';
        }
        $request->validate($rules);

        TujuanDepo::create($request->except('_token'));
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
            'type_tran' => 'required|in:Cash,Tabungan,Transfer',
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

    public function getTabunganByNocif(Request $request)
    {
        $nocif = $request->input('nocif');
        $tabungan = \DB::table('m_tabunganb')
            ->where('nocif', $nocif)
            ->select('noacc', 'fnama')
            ->get();
        return response()->json($tabungan);
    }
}
