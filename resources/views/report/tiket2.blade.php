@extends('layouts.print')

@section('content')
<div class="print-container">
    <table style="width: 80%; border-collapse: collapse; margin: 0 auto;">
        <tr>
            <td colspan="2" style="border: none; text-align: right; padding-bottom: 20px;">
                <span class="medium-text">{{ $tanggal }}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; border: none;">
                <br>
                <br>
                <br>
                <br>
                <br>
                <strong class="medium-text">Utang Budep jatuh Tempo /212.200</strong>
            </td>
            <td style="width: 50%; border: none; text-align: right;">
                <br>
                <br>
                <br>
                <br>
                <br>
                <span class="smaller-text">ABA-Tab BANK MANDIRI 1.100/115.311 Rp {{ number_format($bungaBersih, 0, ',', '.') }}</span>
                <br>
                <span class="smaller-text">Htng Pjk Pph Psl 4 Deposito 1.270/211.182 Rp {{ number_format($kewajibanSegera, 0, ',', '.') }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">
                 <br>
                 <br>
                <span class="medium-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Budep an {{ $deposito->fnama }} Rp {{ number_format($nominal, 0, ',', '.') }} ({{ $deposito->noacc }})
            </td>
            <td colspan="2" style="border: none;">
                <br>
                <br>
                <br>
                <span > {{ number_format($deposito->bnghitung, 0, ',', '.') }}</span>
        </tr>
        <tr>
            <br>
            <br>
            <td colspan="2" style="border: none;">
                <br>
                <br class="medium-text">
                <span class="medium-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $terbilang }} rupiah
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CS
            </td>
        </tr>
    </table>
</div>
@endsection

<style>
.print-container {
    padding: 20px;
    margin: 0 auto;
    max-width: 800px;
}
@media print {
    @page {
        margin: 0;
        size: auto;
    }
    .print-container {
        padding: 0;
    }
}
.smaller-text {
    font-size: 50%;
}
.medium-text {
    font-size: 70%;
}
</style>