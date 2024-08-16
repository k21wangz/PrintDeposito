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
            $no = 1;
        @endphp
        @foreach($tanggal as $tgl)
            <h4>Periode : {{ Carbon::createFromFormat('dmY', $tgl->tgl)->format('d-m-Y') }}</h4>
        @endforeach
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Deposito Hari Ini
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Rekening</th>
                        <th>Nama</th>
                        <th>Bunga Kotor</th>
                        <th>Bunga Accru</th>
                        <th>Sisa Accru</th>
                        <th>Bunga Deposito</th>
                        <th>Pajak</th>
                        <th>Ket no rek/tab</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No Rekening</th>
                        <th>Nama</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($deposito as $depo)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $depo->noacc }}</td>
                            <td>{{ $depo->fnama }}</td>
                            <td>{{ number_format($depo->bnghitung) }}</td>
                            <td>{{ number_format($depo->Bng_DEP_Acru) }}</td>
                            <td>{{ number_format($depo->Sisa_Bng_Accru) }}</td>
                            <td>{{ number_format($depo->bnghitung - $depo->Tax_DEP) }}</td>
                            <td>{{ number_format($depo->Tax_DEP) }}</td>
                            <td>Tujuan</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
