<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deposito Hari ini</title>
</head>
<body>
    <div class="container-fluid px-4">
        @php
            use Carbon\Carbon;
        @endphp
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Deposito
                @foreach($data['tanggal'] as $tgl)
                    Periode : {{ Carbon::createFromFormat('dmY', $tgl->tgl)->format('d-m-Y') }}
                @endforeach
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
                        <th>Dengan Pajak</th>
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
                        $pajakArr = [];
                    @endphp
                    @foreach($data['deposito'] as $depo)
                        @php
                            $isTaxFree = App\Models\DepositoTanpaPajak::where('noacc', $depo->noacc)->exists();
                            $pajak = $isTaxFree ? 0 : (float)($depo->Tax_DEP ?? 0);
                            $totalBunga += (float)($depo->bnghitung ?? 0);
                            $totalAccru += (float)($depo->Bng_DEP_Acru ?? 0);
                            $totalSisaAccru += (float)($depo->Sisa_Bng_Accru ?? 0);
                            $totalBungaDepo += (float)($depo->bnghitung - $pajak);
                            $pajakArr[] = $pajak;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $depo->noacc }}</td>
                            <td>{{ $depo->fnama }}</td>
                            <td class="bunga-kotor">{{ $depo->bnghitung }}</td>
                            <td>{{ number_format($depo->Bng_DEP_Acru) }}</td>
                            <td>{{ number_format($depo->Sisa_Bng_Accru) }}</td>
                            <td class="bunga-deposito">{{ $depo->bnghitung - $pajak }}</td>
                            <td class="pajak" data-original-value="{{ $pajak }}">{{ $pajak }}</td>
                            <td>
                                <input type="checkbox" class="checkbox-dengan-pajak" {{ $pajak ? 'checked' : '' }}>
                            </td>
                            <td>{{ $depo->type_tran }} {{ $depo->nama_bank }} {{ $depo->norek_tujuan }} an. {{ $depo->an_tujuan }} </td>
                        </tr>
                    @endforeach
                    @php
                        $totalPajak = array_sum($pajakArr);
                    @endphp
                    <tr style="font-weight:bold; background:#f8f9fa;">
                        <td colspan="3" class="text-end">TOTAL</td>
                        <td>{{ number_format($totalBunga) }}</td>
                        <td>{{ number_format($totalAccru) }}</td>
                        <td>{{ number_format($totalSisaAccru) }}</td>
                        <td>{{ number_format($totalBungaDepo) }}</td>
                        <td>{{ number_format($totalPajak) }}</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr style="font-weight:bold; background:#f8f9fa;">
                        <td colspan="7" class="text-end">TOTAL PAJAK</td>
                        <td>{{ number_format($totalPajak) }}</td>
                        <td colspan="2"></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.checkbox-dengan-pajak').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                let row = this.closest('tr');
                let bungaKotor = parseInt(row.querySelector('.bunga-kotor').innerText);
                let pajakField = row.querySelector('.pajak');

                if (this.checked) {
                    // Jika "Ya" dicentang, hitung pajak
                    let pajak = parseInt(pajakField.getAttribute('data-original-value'));
                    row.querySelector('.bunga-deposito').innerText = (bungaKotor - pajak);
                } else {
                    // Jika "Tidak" dicentang, pajak menjadi 0
                    pajakField.innerText = '0';
                    row.querySelector('.bunga-deposito').innerText = bungaKotor;
                }
            });
        });
    </script>
</body>
</html>
