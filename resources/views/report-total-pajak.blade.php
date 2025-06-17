@php
    use Carbon\Carbon;
@endphp
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="no-print">Laporan Deposito</title><style>
        body { font-family: Arial, sans-serif; font-size: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 0.6rem; }
        th, td { border: 1px solid #ccc; padding: 0.2rem 0.3rem; text-align: left; vertical-align: middle; }
        th { background: #f8f9fa; font-weight: 600; white-space: nowrap; }
        .total-row { font-weight: bold; background: #f8f9fa; }
        .text-end { text-align: right !important; padding-right: 0.3rem !important; }
        .table-secondary { background-color: #f8f9fa !important; }
        .fw-bold { font-weight: 600 !important; }
        .simple-recap { width: 160px; margin-top: 10px; page-break-inside: avoid; font-size: 0.6rem; }
        .simple-recap tr td { padding: 1px 2px; border: none; }
        .simple-recap tr.total-row td { border-top: 1px solid black; font-weight: bold; }
        .simple-recap td:last-child { text-align: right; }        @media print {
            body { font-size: 7px; }
            table, .simple-recap { font-size: 0.5rem; }
            th, td { padding: 0.15rem 0.2rem; }
            a { text-decoration: none !important; color: black !important; }
            title { display: none; }
            h2 { display: none; }
            .date-info { display: none; }
        }
        @media (max-width: 992px) {
            table { font-size: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4">
        <h2>Laporan Deposito</h2>        <div class="date-info" style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 10px;">
            @if(isset($tanggal) && count($tanggal))
                @foreach($tanggal as $tgl)
                    <span style="font-size: 1.1em; font-weight: bold;">Periode: {{ \Carbon\Carbon::createFromFormat('dmY', is_array($tgl) ? $tgl['tgl'] : $tgl->tgl)->format('d-m-Y') }}</span>
                @endforeach
            @endif
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Rekening</th>
                    <th>Nama</th>
                    <th>Bunga Kotor</th>
                    <th>Bunga Accru</th>
                    <th>Sisa Accru</th>
                    <th>Pajak</th>
                    <th>Bunga Deposito</th>
                    <th>Ket no rek/tab</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBunga = 0;
                    $totalAccru = 0;
                    $totalSisaAccru = 0;
                    $totalBungaDepo = 0;
                    $totalPajak = 0;
                @endphp
                @foreach($data['deposito'] as $i => $depo)
                    @php
                        $isTaxFree = \App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                        $pajak = $isTaxFree ? 0 : (float)($depo->Tax_DEP ?? 0);
                        $bungaBersih = (float)($depo->bnghitung ?? 0) - $pajak;
                        $totalBunga += (float)($depo->bnghitung ?? 0);
                        $totalAccru += (float)($depo->Bng_DEP_Acru ?? 0);
                        $totalSisaAccru += (float)($depo->Sisa_Bng_Accru ?? 0);
                        $totalBungaDepo += $bungaBersih;
                        $totalPajak += $pajak;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $depo->noacc }}</td>
                        <td>{{ $depo->fnama }}</td>
                        <td>{{ number_format($depo->bnghitung) }}</td>
                        <td>{{ number_format($depo->Bng_DEP_Acru) }}</td>
                        <td>{{ number_format($depo->Sisa_Bng_Accru) }}</td>
                        <td>{{ number_format($pajak) }}</td>
                        <td>{{ number_format($bungaBersih) }}</td>
                        <td>{{ $depo->type_tran }} {{ $depo->nama_bank }} {{ $depo->norek_tujuan }} an. {{ $depo->an_tujuan }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-end">TOTAL</td>
                    <td>{{ number_format($totalBunga) }}</td>
                    <td>{{ number_format($totalAccru) }}</td>
                    <td>{{ number_format($totalSisaAccru) }}</td>
                    <td>{{ number_format($totalPajak) }}</td>
                    <td>{{ number_format($totalBungaDepo) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="simple-recap">
            @php
                $rekap = [
                    'Tabungan' => 0,
                    'Transfer' => 0,
                    'Cash' => 0
                ];
                foreach($data['deposito'] as $depo) {
                    $isTaxFree = \App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                    $pajak = $isTaxFree ? 0 : (float)($depo->Tax_DEP ?? 0);
                    $bungaBersih = (float)($depo->bnghitung ?? 0) - $pajak;
                    switch($depo->type_tran) {
                        case 'Tabungan':
                            $rekap['Tabungan'] += $bungaBersih;
                            break;
                        case 'Transfer':
                            $rekap['Transfer'] += $bungaBersih;
                            break;
                        case 'Cash':
                            $rekap['Cash'] += $bungaBersih;
                            break;
                    }
                }
            @endphp
            <tr><td>Tabungan</td><td>{{ number_format($rekap['Tabungan']) }}</td></tr>
            <tr><td>Transfer</td><td>{{ number_format($rekap['Transfer']) }}</td></tr>
            <tr><td>Cash</td><td>{{ number_format($rekap['Cash']) }}</td></tr>
            <tr><td>Pajak</td><td>{{ number_format($totalPajak) }}</td></tr>
            <tr class="total-row"><td>Total</td><td>{{ number_format($rekap['Tabungan'] + $rekap['Transfer'] + $rekap['Cash'] + $totalPajak) }}</td></tr>
        </table>
    </div>
</body>
</html>