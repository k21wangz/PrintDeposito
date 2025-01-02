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
        <tr>
            <td style="text-align: right; width: 100%;" colspan="2">
                {{ $tanggal }}
            </td>
        </tr>
    </table>
    <p>CS</p>
</div>
@endsection