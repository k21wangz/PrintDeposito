@extends('layouts.admin')
@section('title','Tambah Rekening Bebas Pajak')
@section('container')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Rekening Bebas Pajak</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('deposito-tanpa-pajak.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="noacc" class="form-label fw-bold">
                        <i class="fas fa-user me-1"></i>Pilih Nomor Rekening
                    </label>
                    <select name="noacc" id="noacc" class="form-select" required style="width:100%">
                        <option value="">-- Pilih Nomor Rekening --</option>
                        @foreach(\DB::table('m_deposito')->select('noacc', 'fnama')->get() as $depo)
                            <option value="{{ $depo->noacc }}">{{ $depo->noacc }} - {{ $depo->fnama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-bold">
                        <i class="fas fa-info-circle me-1"></i>Keterangan (Opsional)
                    </label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Keterangan tambahan">
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Data
                    </button>
                    <a href="{{ route('deposito-tanpa-pajak.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- jQuery & Select2 CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#noacc').select2({
        placeholder: '-- Pilih Nomor Rekening --',
        allowClear: true,
        width: 'resolve',
    });
});
</script>
@endsection
