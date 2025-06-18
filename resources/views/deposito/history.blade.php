@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Deposito Yang Lalu</h2>
    <form method="GET" action="{{ url('/deposito-lalu') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label for="tgltrn" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tgltrn" name="tgltrn" value="{{ request('tgltrn', $defaultDate) }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Bilyet</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Tujuan</th>
                    <th>Type Transaksi</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->nobilyet }}</td>
                    <td>{{ $row->fnama }}</td>
                    <td class="text-end">{{ number_format($row->nominal, 0, ',', '.') }}</td>
                    <td>{{ $row->an_tujuan }}<br>{{ $row->norek_tujuan }}<br>{{ $row->nama_bank }}</td>
                    <td>{{ $row->type_tran }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tgltrn)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
