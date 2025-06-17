@extends('layouts.admin')
@section('title','Daftar Rekening Bebas Pajak')
@section('container')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Rekening Bebas Pajak</h4>
            <a href="{{ route('deposito-tanpa-pajak.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <input type="text" id="searchNoacc" class="form-control" placeholder="Cari nomor rekening atau nama nasabah...">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tanpaPajakTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">No Rekening</th>
                            <th style="width:30%">Nama Nasabah</th>
                            <th style="width:30%">Keterangan</th>
                            <th style="width:15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekening as $i => $row)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $row->noacc }}</td>
                                <td>{{ $nasabahMap[$row->noacc] ?? '-' }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>
                                    <form action="{{ route('deposito-tanpa-pajak.destroy', $row->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
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
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchNoacc').on('keyup', function() {
        var value = $(this).val().toLowerCase().trim();
        if (value === '') {
            $('#tanpaPajakTable tbody tr').show();
            return;
        }
        $('#tanpaPajakTable tbody tr').each(function() {
            var rowText = $(this).find('td').map(function(){
                return $(this).text().toLowerCase();
            }).get().join(' ');
            if (rowText.indexOf(value) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
