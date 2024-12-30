@extends('layouts.admin')
@section('title','Dashboard')
@section('container')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>

    <!-- Cards Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Transaksi Deposito</h6>
                            <div class="fs-4 fw-bold">{{ $dphi }}</div>
                            <small>Hari ini</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('deposito') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Deposito</h6>
                            <div class="fs-4 fw-bold">{{ $depositos->count() }}</div>
                            <small>Rekening Aktif</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Bebas Pajak</h6>
                            <div class="fs-4 fw-bold">
                                {{ App\Models\DepositoTanpaPajak::count() }}
                            </div>
                            <small>Total Rekening</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('deposito-tanpa-pajak.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Tujuan Deposito</h6>
                            <div class="fs-4 fw-bold">
                                {{ App\Models\TujuanDepo::count() }}
                            </div>
                            <small>Total Terdaftar</small>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('tujuandepo') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card mb-4 shadow">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Data Deposito
                </div>
                <div>
                    <a href="{{ route('deposito.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-list me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No Rekening</th>
                            <th>CIF</th>
                            <th>Nama</th>
                            <th>Nominal</th>
                            <th>Jangka Waktu</th>
                            <th>Rate</th>
                            <th>Tanggal Buka</th>
                            <th>Tanggal Bunga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use Carbon\Carbon;
                        @endphp
                        @foreach($depositos as $depo)
                            @php
                                $originalDate = $depo->tgleff;
                                $day = Carbon::createFromFormat('Ymd', $originalDate)->day;
                                $newDate = Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
                            @endphp
                            <tr>
                                <td>{{ $depo->noacc }}</td>
                                <td>{{ $depo->nocif }}</td>
                                <td>{{ $depo->fnama }}</td>
                                <td class="text-end">Rp {{ number_format($depo->nominal, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $depo->jkwaktu }} Bulan</td>
                                <td class="text-center">{{ $depo->rate }}%</td>
                                <td class="text-center">{{ Carbon::createFromFormat('Ymd', $depo->tgleff)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $newDate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Hover Effects */
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
}

/* Icon Styling */
.card .fs-1 {
    transition: transform 0.2s ease-in-out;
}
.card:hover .fs-1 {
    transform: scale(1.1);
}

/* Table Styling */
.table {
    font-size: 0.9rem;
}
.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

/* Card Header */
.card-header {
    font-weight: 600;
}

/* Breadcrumb */
.breadcrumb {
    background: transparent;
    margin: 0;
    padding: 0;
}

/* Responsive Text */
@media (max-width: 768px) {
    .fs-4 {
        font-size: 1.2rem !important;
    }
    .fs-1 {
        font-size: 2rem !important;
    }
}
</style>
@endsection
