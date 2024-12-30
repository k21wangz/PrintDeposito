<!-- resources/views/transaction_purpose/index.blade.php -->
@extends('layouts.admin')
@section('title', 'Daftar Tujuan Deposito')
@section('container')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Tujuan Deposito</h4>
            <a href="{{ route('tujuandepo.create') }}" class="btn btn-light">
                <i class="fas fa-plus me-1"></i>Tambah Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="datatablesSimple">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Rekening</th>
                            <th>Jenis Transaksi</th>
                            <th>No Rek Tujuan</th>
                            <th>Atas Nama</th>
                            <th>Bank</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tujuanDepos as $tujuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tujuan->noacc_depo }}</td>
                                <td>
                                    @switch($tujuan->type_tran)
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
                                            {{ $tujuan->type_tran }}
                                    @endswitch
                                </td>
                                <td>{{ $tujuan->norek_tujuan }}</td>
                                <td>{{ $tujuan->an_tujuan }}</td>
                                <td>{{ $tujuan->nama_bank }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tujuandepo.show', $tujuan->id) }}" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tujuandepo.edit', $tujuan->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tujuandepo.destroy', $tujuan->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.9em;
    padding: 0.5em 1em;
}
.btn-group .btn {
    padding: 0.25rem 0.5rem;
    margin: 0 2px;
}
.btn-group .btn i {
    font-size: 0.875rem;
}
.table > :not(caption) > * > * {
    padding: 0.75rem;
}
</style>
@endsection
