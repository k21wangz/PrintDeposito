<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 14pt;
        }
        .periode {
            margin-bottom: 10px;
            font-size: 11pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 0.5px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
            font-size: 9pt;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f8f9fc;
            font-weight: bold;
        }
        .simple-recap {
            width: 300px;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .simple-recap tr td {
            padding: 3px 4px;
            border: none;
        }
        .simple-recap tr.total td {
            border-top: 1px solid black;
            font-weight: bold;
        }
        .simple-recap td:last-child {
            text-align: right;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DEPOSITO</h2>
        @foreach($tanggal as $tgl)
            <div class="periode">
                Periode: {{ Carbon\Carbon::createFromFormat('dmY', $tgl->tgl)->format('d-m-Y') }}
            </div>
        @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Rek</th>
                <th>Nama</th>
                <th>Bunga</th>
                <th>Accru</th>
                <th>Sisa Accru</th>
                <th>Bng Depo</th>
                <th>Pajak</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalBunga = 0;
                $totalAccru = 0;
                $totalSisaAccru = 0;
                $totalPajak = 0;
                $totalBungaBersih = 0;
            @endphp
            
            @foreach($deposito as $depo)
                @php
                    $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                    $pajak = $isTaxFree ? 0 : $depo->Tax_DEP;
                    
                    $totalBunga += $depo->bnghitung;
                    $totalAccru += $depo->Bng_DEP_Acru;
                    $totalSisaAccru += $depo->Sisa_Bng_Accru;
                    $totalPajak += $pajak;
                    $bungaBersih = $depo->bnghitung - $pajak;
                    $totalBungaBersih += $bungaBersih;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $depo->noacc }}</td>
                    <td>{{ $depo->fnama }}</td>
                    <td class="text-right">{{ number_format($depo->bnghitung, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($depo->Bng_DEP_Acru, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($depo->Sisa_Bng_Accru, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($bungaBersih, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($pajak, 0, ',', '.') }}</td>
                    <td>{{ $depo->type_tran }} {{ $depo->nama_bank }} {{ $depo->norek_tujuan }}</td>
                </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right">{{ number_format($totalBunga, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalAccru, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalSisaAccru, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalBungaBersih, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalPajak, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Rekap -->
    <table class="simple-recap">
        @php
            $rekap = ['Tabungan' => 0, 'Transfer' => 0, 'Cash' => 0];
            foreach($deposito as $depo) {
                $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                $pajak = $isTaxFree ? 0 : $depo->Tax_DEP;
                $bungaBersih = $depo->bnghitung - $pajak;
                
                switch($depo->type_tran) {
                    case 'Tabungan': $rekap['Tabungan'] += $bungaBersih; break;
                    case 'Transfer': $rekap['Transfer'] += $bungaBersih; break;
                    case 'Cash': $rekap['Cash'] += $bungaBersih; break;
                }
            }
            $totalKeseluruhan = array_sum($rekap) + $totalPajak;
        @endphp

        @foreach($rekap as $jenis => $nilai)
            <tr>
                <td>{{ $jenis }}</td>
                <td>{{ number_format($nilai, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Pajak</td>
            <td>{{ number_format($totalPajak, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Deposito</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Kelebihan kas</td>
            <td>-</td>
        </tr>
        <tr class="total">
            <td></td>
            <td>{{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html> 