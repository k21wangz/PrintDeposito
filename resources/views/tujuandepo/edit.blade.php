@extends('layouts.admin')
@section('title', 'Edit Tujuan Deposito')
@section('container')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-warning">
            <h4 class="mb-0 text-dark"><i class="fas fa-edit me-2"></i>Edit Tujuan Deposito</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tujuandepo.update', $tujuanDepo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="noacc_depo" class="form-label">No Rekening Deposito</label>
                            <input type="text" class="form-control @error('noacc_depo') is-invalid @enderror" 
                                id="noacc_depo" name="noacc_depo" value="{{ old('noacc_depo', $tujuanDepo->noacc_depo) }}" required>
                            @error('noacc_depo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_tran" class="form-label">Jenis Transaksi</label>
                            <select class="form-select @error('type_tran') is-invalid @enderror" 
                                id="type_tran" name="type_tran" required>
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="TAB" {{ old('type_tran', $tujuanDepo->type_tran) == 'TAB' ? 'selected' : '' }}>Tabungan</option>
                                <option value="TRF" {{ old('type_tran', $tujuanDepo->type_tran) == 'TRF' ? 'selected' : '' }}>Transfer</option>
                                <option value="CASH" {{ old('type_tran', $tujuanDepo->type_tran) == 'CASH' ? 'selected' : '' }}>Cash</option>
                            </select>
                            @error('type_tran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="norek_tujuan" class="form-label">No Rekening Tujuan</label>
                            <input type="text" class="form-control @error('norek_tujuan') is-invalid @enderror" 
                                id="norek_tujuan" name="norek_tujuan" value="{{ old('norek_tujuan', $tujuanDepo->norek_tujuan) }}" required>
                            @error('norek_tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="an_tujuan" class="form-label">Atas Nama</label>
                            <input type="text" class="form-control @error('an_tujuan') is-invalid @enderror" 
                                id="an_tujuan" name="an_tujuan" value="{{ old('an_tujuan', $tujuanDepo->an_tujuan) }}" required>
                            @error('an_tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_bank" class="form-label">Nama Bank</label>
                            <input type="text" class="form-control @error('nama_bank') is-invalid @enderror" 
                                id="nama_bank" name="nama_bank" value="{{ old('nama_bank', $tujuanDepo->nama_bank) }}" required>
                            @error('nama_bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('tujuandepo.show', $tujuanDepo->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 500;
}
.invalid-feedback {
    font-size: 0.875em;
}
</style>
@endsection 