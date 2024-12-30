@extends('layouts.admin')
@section('title', 'Detail Tujuan Deposito')
@section('container')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Tujuan Deposito</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">No Rekening Deposito</th>
                        <td>{{ $tujuanDepo->noacc_depo }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Transaksi</th>
                        <td>
                            @switch($tujuanDepo->type_tran)
                                @case('TAB')
                                    <span class="badge bg-info">Tabungan</span>
                                    @break
                                @case('TRF')
                                    <span class="badge bg-primary">Transfer</span>
                                    @break
                                @case('CASH')
                                    <span class="badge bg-success">Cash</span>
                                    @break
                                @default
                                    {{ $tujuanDepo->type_tran }}
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>No Rekening Tujuan</th>
                        <td>{{ $tujuanDepo->norek_tujuan }}</td>
                    </tr>
                    <tr>
                        <th>Atas Nama</th>
                        <td>{{ $tujuanDepo->an_tujuan }}</td>
                    </tr>
                    <tr>
                        <th>Bank</th>
                        <td>{{ $tujuanDepo->nama_bank }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $tujuanDepo->created_at ? $tujuanDepo->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $tujuanDepo->updated_at ? $tujuanDepo->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('tujuandepo.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
                <a href="{{ route('tujuandepo.edit', $tujuanDepo->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 1em;
    }
</style>
@endsection 