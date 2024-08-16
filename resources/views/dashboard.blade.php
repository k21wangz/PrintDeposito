@extends('layouts.admin')
@section('title','Dashboard')
@section('container')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Transaksi Deposito Hari ini</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="card-body"><h1>{{ $dphi }}</h1></div>
                        <div class="d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ url('deposito') }}">View Details </a>
                        <i class="fas fa-angle-right"> </i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Warning Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Success Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Danger Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Deposito
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
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
                    <tfoot>
                    <tr>
                        <th>No Rekening</th>
                        <th>Nama</th>
                        <th>Nominal</th>
                        <th>Tanggal Bunga</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @php
                            use Carbon\Carbon;
                        @endphp
                    @foreach($depositos as $depo)
                        @php
                            // Data awal
                            $originalDate = $depo->tgleff;

                            // Mengambil hari dari data awal
                            $day = Carbon::createFromFormat('Ymd', $originalDate)->day;

                            // Membuat tanggal baru dengan bulan dan tahun saat ini
                            $newDate = Carbon::create(now()->year, now()->month, $day)->format('d-m-Y');
                        @endphp
                    <tr>
                        <td>{{ $depo->noacc }}</td>
                        <td>{{ $depo->nocif }}</td>
                        <td>{{ $depo->fnama }}</td>
                        <td> Rp {{ number_format($depo->nominal) }}</td>
                        <td>{{ $depo->jkwaktu }} Bulan</td>
                        <td>{{ $depo->rate }}</td>
                        <td>{{ Carbon::createFromFormat('Ymd', $depo->tgleff)->format('d-m-Y') }}</td>
                        <td>{{ $newDate }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
