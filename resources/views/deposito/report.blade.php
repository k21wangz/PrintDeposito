<!DOCTYPE html>
<html>
<head>
    <title>Laporan Deposito</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 2.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .periode {
            margin-bottom: 10px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }
        table, th, td {
            border: 0.5px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .recap-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .recap-table {
            width: 85%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .recap-table th, .recap-table td {
            padding: 4px 8px;
            border: 0.5px solid black;
            font-size: 10px;
        }
        .recap-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total-section {
            margin-top: 15px;
            font-weight: bold;
        }
        .total-item {
            margin-bottom: 5px;
        }
        @media print {
            @page {
                margin: 2cm 2.5cm;
            }
            .no-print {
                display: none;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
            head, title {
                display: none;
            }
        }
        .total-row {
            background-color: #f8f9fc;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #000;
            padding: 6px 4px;
        }

        .recap-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .simple-recap {
            width: 300px;
            margin-top: 30px;
            font-size: 11px;
            page-break-inside: avoid;
        }
        
        .simple-recap tr td {
            padding: 3px 4px;
            border: none;
        }
        
        .simple-recap tr.total td {
            border-top: 1px solid black;
            padding-top: 5px;
            font-weight: bold;
        }
        
        .simple-recap td:last-child {
            text-align: right;
        }
        
        .simple-recap .spacer td {
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <script>
        window.onload = function() {
            document.title = "";
            // Ambil status pajak dari URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const withTax = urlParams.get('withTax') === 'true';
            
            // Update nilai jika tanpa pajak
            if (!withTax) {
                document.querySelectorAll('.tax-value').forEach(el => {
                    el.textContent = '0';
                });
                
                // Update bunga bersih
                document.querySelectorAll('.row-data').forEach(row => {
                    const bungaKotor = parseFloat(row.querySelector('.bunga-kotor').getAttribute('data-value'));
                    row.querySelector('.bunga-bersih').textContent = formatNumber(bungaKotor);
                });
                
                // Update total recap
                updateRecapTotals();
            }
            
            window.print();
        }
        
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
        
        function updateRecapTotals() {
            const totalBungaKotor = document.querySelector('.total-bunga-kotor').getAttribute('data-value');
            document.querySelector('.total-pajak').textContent = '0';
            document.querySelector('.total-bunga-bersih').textContent = formatNumber(parseFloat(totalBungaKotor));
        }
    </script>

    <div class="header">
        <h2>LAPORAN DEPOSITO</h2>
        @php
            use Carbon\Carbon;
        @endphp
        @foreach($tanggal as $tgl)
            <div class="periode">Periode: {{ Carbon::createFromFormat('dmY', $tgl->tgl)->format('d-m-Y') }}</div>
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
                    // Cek status bebas pajak
                    $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                    // Hitung pajak berdasarkan status
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
            <!-- Baris Total -->
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right total-bunga-kotor" data-value="{{ $totalBunga }}">
                    {{ number_format($totalBunga, 0, ',', '.') }}
                </td>
                <td class="text-right">{{ number_format($totalAccru, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalSisaAccru, 0, ',', '.') }}</td>
                <td class="text-right total-bunga-bersih">{{ number_format($totalBungaBersih, 0, ',', '.') }}</td>
                <td class="text-right total-pajak">{{ number_format($totalPajak, 0, ',', '.') }}</td>
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
            
            foreach($deposito as $depo) {
                // Cek status bebas pajak untuk setiap rekening
                $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                $pajak = $isTaxFree ? 0 : $depo->Tax_DEP;
                $bungaBersih = $depo->bnghitung - $pajak;
                
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

            // Total pajak dengan mempertimbangkan status bebas pajak
            $totalPajak = $deposito->sum(function($depo) {
                $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                return $isTaxFree ? 0 : $depo->Tax_DEP;
            });
            
            // Menghitung total keseluruhan
            $totalKeseluruhan = array_sum($rekap) + $totalPajak;
        @endphp

        <!-- Tampilkan semua kategori meskipun nilainya 0 -->
        <tr>
            <td>Tabungan</td>
            <td>{{ number_format($rekap['Tabungan'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Transfer</td>
            <td>{{ number_format($rekap['Transfer'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Cash</td>
            <td>{{ number_format($rekap['Cash'], 0, ',', '.') }}</td>
        </tr>
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

    <button class="no-print" onclick="window.print()">Cetak Laporan</button>
</body>
</html>