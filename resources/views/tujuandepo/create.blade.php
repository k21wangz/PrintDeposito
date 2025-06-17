<!-- resources/views/transaction_purpose/create.blade.php -->
@extends('layouts.admin')
@section('title','Buat Tujuan Deposito')
@section('container')
    <h1>Create New Transaction Purpose</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                                <select name="noacc_depo" id="noacc_depo" class="form-select" required style="width:100%">
                                    <option value="">-- Pilih Nasabah --</option>
                                    @foreach ($noaccList as $noacc)
                                        <option value="{{ $noacc->noacc }}" data-nocif="{{ $noacc->nocif }}">{{ $noacc->noacc }} - {{ $noacc->fnama }}</option>
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
                                <select name="norek_tujuan" id="norek_tujuan" class="form-select" required disabled>
                                    <option value="">-- Pilih Nomor Rekening Tabungan --</option>
                                </select>
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
    <!-- Ganti select dengan select2 agar bisa search -->
    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#noacc_depo').select2({
                placeholder: '-- Pilih Nasabah --',
                allowClear: true,
                width: 'resolve',
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const noaccSelect = document.getElementById('noacc_depo');
            const typeTranSelect = document.getElementById('type_tran');
            const norekTujuanSelect = document.getElementById('norek_tujuan');
            const anTujuanInput = document.getElementById('an_tujuan');

            let tabunganData = [];

            function resetTabunganFields() {
                norekTujuanSelect.innerHTML = '<option value="">-- Pilih Nomor Rekening Tabungan --</option>';
                norekTujuanSelect.disabled = true;
                anTujuanInput.value = '';
            }

            function ensureNorekTujuanIsSelect() {
                let norekTujuan = document.getElementById('norek_tujuan');
                if (norekTujuan.tagName.toLowerCase() !== 'select') {
                    const parent = norekTujuan.parentNode;
                    const select = document.createElement('select');
                    select.name = 'norek_tujuan';
                    select.id = 'norek_tujuan';
                    select.className = 'form-select';
                    select.required = true;
                    select.innerHTML = '<option value="">-- Pilih Nomor Rekening Tabungan --</option>';
                    parent.replaceChild(select, norekTujuan);
                }
            }

            typeTranSelect.addEventListener('change', function() {
                resetTabunganFields();
                if (this.value === 'Tabungan') {
                    ensureNorekTujuanIsSelect();
                    const selectedOption = noaccSelect.options[noaccSelect.selectedIndex];
                    const nocif = selectedOption.getAttribute('data-nocif');
                    if (nocif) {
                        fetchTabungan(nocif);
                    }
                    // Enable semua field
                    document.getElementById('norek_tujuan').required = true;
                    document.getElementById('norek_tujuan').disabled = false;
                    anTujuanInput.required = true;
                    document.getElementById('nama_bank').required = true;
                } else if (this.value === 'Cash') {
                    // Nonaktifkan dan kosongkan field lain
                    norekTujuanSelect.innerHTML = '<option value="">-</option>';
                    norekTujuanSelect.value = '';
                    norekTujuanSelect.disabled = true;
                    norekTujuanSelect.required = false;
                    anTujuanInput.value = '';
                    anTujuanInput.disabled = true;
                    anTujuanInput.required = false;
                    document.getElementById('nama_bank').value = '';
                    document.getElementById('nama_bank').disabled = true;
                    document.getElementById('nama_bank').required = false;
                } else if (this.value === 'Transfer') {
                    // Enable dan kosongkan field, wajib diisi manual
                    norekTujuanSelect.innerHTML = '<option value="">-</option>';
                    norekTujuanSelect.value = '';
                    norekTujuanSelect.disabled = false;
                    norekTujuanSelect.required = true;
                    anTujuanInput.value = '';
                    anTujuanInput.disabled = false;
                    anTujuanInput.required = true;
                    document.getElementById('nama_bank').value = '';
                    document.getElementById('nama_bank').disabled = false;
                    document.getElementById('nama_bank').required = true;
                    // Ganti norekTujuanSelect menjadi input text
                    norekTujuanSelect.outerHTML = '<input type="text" name="norek_tujuan" id="norek_tujuan" class="form-control" placeholder="Masukkan nomor rekening tujuan" required />';
                } else {
                    // Untuk Transfer, enable field
                    norekTujuanSelect.disabled = false;
                    norekTujuanSelect.required = true;
                    anTujuanInput.disabled = false;
                    anTujuanInput.required = true;
                    document.getElementById('nama_bank').disabled = false;
                    document.getElementById('nama_bank').required = true;
                }
            });

            // Aktifkan kembali field jika user ganti dari Cash ke Tabungan/Transfer
            noaccSelect.addEventListener('change', function() {
                if (typeTranSelect.value !== 'Cash') {
                    norekTujuanSelect.disabled = false;
                    anTujuanInput.disabled = false;
                    document.getElementById('nama_bank').disabled = false;
                }
            });

            function fetchTabungan(nocif) {
                fetch("{{ route('tujuandepo.getTabunganByNocif') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    },
                    body: JSON.stringify({ nocif })
                })
                .then(response => response.json())
                .then(data => {
                    tabunganData = data;
                    norekTujuanSelect.innerHTML = '<option value="">-- Pilih Nomor Rekening Tabungan --</option>';
                    data.forEach(item => {
                        norekTujuanSelect.innerHTML += `<option value="${item.noacc}" data-fnama="${item.fnama}">${item.noacc} - ${item.fnama}</option>`;
                    });
                    norekTujuanSelect.disabled = false;
                });
            }

            norekTujuanSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                anTujuanInput.value = selectedOption.getAttribute('data-fnama') || '';
                // Jika jenis transaksi Tabungan, isi nama bank otomatis
                if (typeTranSelect.value === 'Tabungan' && this.value) {
                    document.getElementById('nama_bank').value = 'BPR NBP 27';
                }
            });

            // Pastikan field norekTujuanSelect tidak disabled saat submit agar datanya terkirim
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                if (typeTranSelect.value !== 'Cash') {
                    norekTujuanSelect.disabled = false;
                    anTujuanInput.disabled = false;
                    document.getElementById('nama_bank').disabled = false;
                }
            });

            // Aktifkan select2 pada pilih nasabah
            $('#noacc_depo').select2({
                placeholder: '-- Pilih Nasabah --',
                allowClear: true,
                width: 'resolve',
            });
        });
    </script>
@endsection
