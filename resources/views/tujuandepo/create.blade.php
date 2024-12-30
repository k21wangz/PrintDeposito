<!-- resources/views/transaction_purpose/create.blade.php -->
@extends('layouts.admin')
@section('title','Buat Tujuan Deposito')
@section('container')
    <h1>Create New Transaction Purpose</h1>
    <form method="POST" action="{{ route('tujuandepo.store') }}" class="needs-validation" novalidate>
        @csrf
        <!-- noacc depo -->
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Tujuan Deposito Baru</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="noacc_depo" class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i>Pilih Nasabah
                                </label>
                                <select name="noacc_depo" class="form-select" required>
                                    <option value="">-- Pilih Nasabah --</option>
                                    @foreach ($noaccList as $noacc)
                                        <option value="{{ $noacc->noacc }}" @selected(old('noacc_depo') == $noacc->noacc)>
                                            {{ $noacc->noacc }} - {{ $noacc->fnama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type_tran" class="form-label fw-bold">
                                    <i class="fas fa-money-bill me-1"></i>Jenis Transaksi
                                </label>
                                <select name="type_tran" id="type_tran" class="form-select" required>
                                    <option value="">-- Pilih Jenis Transaksi --</option>
                                    <option value="Cash" @selected(old('type_tran') == 'Cash')>Cash</option>
                                    <option value="Tabungan" @selected(old('type_tran') == 'Tabungan')>Tabungan</option>
                                    <option value="Transfer" @selected(old('type_tran') == 'Transfer')>Transfer</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="norek_tujuan" class="form-label fw-bold">
                                    <i class="fas fa-credit-card me-1"></i>Nomor Rekening Tujuan
                                </label>
                                <input type="text" name="norek_tujuan" id="norek_tujuan" 
                                    class="form-control @error('norek_tujuan') is-invalid @enderror"
                                    value="{{ old('norek_tujuan') }}" placeholder="Masukkan nomor rekening">
                                @error('norek_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="an_tujuan" class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i>Atas Nama
                                </label>
                                <input type="text" name="an_tujuan" id="an_tujuan"
                                    class="form-control @error('an_tujuan') is-invalid @enderror"
                                    value="{{ old('an_tujuan') }}" placeholder="Masukkan nama pemilik rekening">
                                @error('an_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_bank" class="form-label fw-bold">
                                    <i class="fas fa-university me-1"></i>Nama Bank
                                </label>
                                <input type="text" name="nama_bank" id="nama_bank"
                                    class="form-control @error('nama_bank') is-invalid @enderror"
                                    value="{{ old('nama_bank') }}" placeholder="Masukkan nama bank">
                                @error('nama_bank')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Data
                        </button>
                        <a href="{{ route('tujuandepo.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
