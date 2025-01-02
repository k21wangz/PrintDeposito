@extends('layouts.app')

@section('content')
<div class="container">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; border: none;">
                <strong>BB. Deposito {{ $jatuhTempo }} Bulan</strong>
                <br>
                Utang Budep YMHD: Rp {{ number_format($nominal, 0, ',', '.') }}
            </td>
            <td style="width: 50%; border: none; text-align: right;">
                Utang Budep Jatuh Tempo: Rp {{ number_format($kewajibanSegera, 0, ',', '.') }}
                <br>
                Kewajiban Segera: Rp {{ number_format($kewajibanSegera, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">
                Budep an {{ $deposito->fnama }} {{ $deposito->noacc }} Rp {{ number_format($nominal, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">
                Terbilang: {{ terbilang($nominal + $kewajibanSegera) }} rupiah
            </td>
        </tr>
    </table>
    <p>CS</p>
</div>
@endsection

<style>
@media print {
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }
    /* Sembunyikan elemen yang tidak perlu saat mencetak */
    h1, p {
        display: none;
    }
}
</style>