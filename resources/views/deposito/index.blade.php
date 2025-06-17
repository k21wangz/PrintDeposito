@extends('layouts.admin')
@section('title','Deposito')
@section('container')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Deposito</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Deposito</li>
        </ol>
        @php
            use Carbon\Carbon;
        @endphp
        @foreach($tanggal as $tgl)
            <h4>Periode: {{ $tgl }}</h4>
        @endforeach

        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Deposito Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($deposito) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Bunga Deposito</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($deposito->sum('bnghitung'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="fas fa-2x text-gray-300">Rp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Pajak</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($deposito->sum('Tax_DEP'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="fas fa-2x text-gray-300">Rp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Bunga Bersih</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($deposito->sum('bnghitung') - $deposito->sum('pajak'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Bunga Accru</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($deposito->sum('Bng_DEP_Acru'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="fas fa-2x text-gray-300">Rp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Sisa Accru</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($deposito->sum('Sisa_Bng_Accru'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percent fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Data Deposito Hari Ini
                </div>
                <div>
                    @php
                        $tanggalBunga = isset($groupedDeposito) && count($groupedDeposito) ? $groupedDeposito->keys()->first() : '';
                    @endphp
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @foreach($groupedDeposito as $tanggalBunga => $depositosGroup)
                        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                            <h5 class="mb-0">Tanggal Bunga: {{ $tanggalBunga }}</h5>
                            <a href="{{ url('/report-total-pajak?tanggal_bunga=' . $tanggalBunga) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-print"></i> Print Tanggal Ini ({{ count($depositosGroup) }} data)
                            </a>
                        </div>
                        <div class="print-group-table group-{{ str_replace('-', '', $tanggalBunga) }}">
                            <table class="table table-bordered table-hover mb-4">
                                <thead>
                                <tr class="table-light">
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 10%">No Rekening</th>
                                    <th style="width: 15%">Nama</th>
                                    <th class="text-end" style="width: 10%">Bunga Kotor</th>
                                    <th class="text-end" style="width: 10%">Bunga Accru</th>
                                    <th class="text-end" style="width: 10%">Sisa Accru</th>
                                    <th class="text-end" style="width: 10%">Bunga Deposito</th>
                                    <th class="text-end" style="width: 8%">Pajak</th>
                                    <th style="width: 12%">Ket no rek/tab</th>
                                    <th class="text-center" style="width: 10%">Print Tiket</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($depositosGroup as $depo)
                                    @php
                                        $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                                        $pajak = $isTaxFree ? 0 : $depo->Tax_DEP;
                                        $bungaBersih = $depo->bnghitung - $pajak;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $depo->noacc }}</td>
                                        <td>{{ $depo->fnama }}</td>
                                        <td class="text-end">{{ number_format($depo->bnghitung) }}</td>
                                        <td class="text-end">{{ number_format($depo->Bng_DEP_Acru) }}</td>
                                        <td class="text-end">{{ number_format($depo->Sisa_Bng_Accru) }}</td>
                                        <td class="text-end">{{ number_format($bungaBersih) }}</td>
                                        <td class="text-end">{{ number_format($pajak) }}</td>
                                        <td>{{ $depo->type_tran }} {{ $depo->nama_bank }} {{ $depo->norek_tujuan }} an. {{ $depo->an_tujuan }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                {{-- Tombol Print Tiket 2 hanya aktif jika type_tran Transfer --}}
                                                @if($depo->type_tran === 'Transfer')
                                                    <a href="{{ route('report.tiket2', $depo->nobilyet) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-print"></i> Print Tiket 2
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-success" disabled style="pointer-events: none; opacity: 0.6;">
                                                        <i class="fas fa-print"></i> Print Tiket 2
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Styling untuk tabel */
    .table {
        font-size: 0.875rem;
        margin-bottom: 0;
    }
    
    /* Header tabel */
    .table thead th {
        vertical-align: middle;
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 0.75rem;
        white-space: nowrap;
    }
    
    /* Body tabel */
    .table tbody td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    
    /* Styling untuk angka */
    .text-end {
        text-align: right !important;
        padding-right: 1rem !important;
    }
    
    /* Styling untuk baris total */
    .table-secondary {
        background-color: #f8f9fa !important;
    }
    
    .fw-bold {
        font-weight: 600 !important;
    }
    
    /* Styling untuk tombol */
    .btn-group {
        display: flex;
        gap: 5px;
        justify-content: center;
        flex-wrap: nowrap;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        line-height: 1.4;
        border-radius: 0.2rem;
        white-space: nowrap;
    }
    
    /* Hover effect */
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
    
    /* Responsive table */
    @media (max-width: 992px) {
        .table {
            font-size: 0.8rem;
        }
        
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.8rem;
        }
    }
    
    /* Responsive styling untuk tombol */
    @media (max-width: 1200px) {
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
    }
</style>

<script>
// Print hanya tabel pada grup tertentu
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.print-group-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var groupClass = this.getAttribute('data-group');
            var printContents = document.querySelector('.' + groupClass).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload(); // reload untuk mengembalikan event listener
        });
    });
});
</script>
