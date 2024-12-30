@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Rekening Bebas Pajak</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('deposito-tanpa-pajak.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="noacc" class="form-control" placeholder="Nomor Rekening" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Rekening</th>
                        <th>Keterangan</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekening as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->noacc }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->created_by }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('deposito-tanpa-pajak.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 