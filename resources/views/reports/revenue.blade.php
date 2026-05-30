<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1a5cff; }
        .header p { margin: 5px 0 0; color: #666; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f8fafc; color: #475569; font-weight: bold; text-align: left; padding: 10px; border: 1px solid #e2e8f0; text-transform: uppercase; font-size: 10px; }
        td { padding: 10px; border: 1px solid #e2e8f0; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .total-row { background-color: #f1f5f9; font-size: 14px; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 15px; margin-bottom: 20px; }
        .summary-grid { display: table; width: 100%; }
        .summary-item { display: table-cell; text-align: center; padding: 10px; width: 25%; }
        .summary-label { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px; }
        .summary-value { font-size: 18px; font-weight: bold; color: #0f172a; }
        .summary-value.primary { color: #1a5cff; }
        .summary-value.green { color: #16a34a; }
        .footer { margin-top: 50px; text-align: right; }
        .footer p { margin-bottom: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ELEKTRONIK MODERN</h1>
        <p>Laporan Pendapatan Bulanan (Owner)</p>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <div class="info">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    {{-- Ringkasan Pendapatan --}}
    <div class="summary-box">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Total Pesanan</div>
                <div class="summary-value">{{ $pesanans->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Subtotal</div>
                <div class="summary-value">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Diskon</div>
                <div class="summary-value" style="color: #dc2626;">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Ongkir</div>
                <div class="summary-value">Rp {{ number_format($totalOngkir, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="summary-box" style="text-align: center; border-color: #1a5cff; border-width: 2px;">
        <div class="summary-label">TOTAL PENDAPATAN BERSIH</div>
        <div class="summary-value primary" style="font-size: 24px; margin-top: 5px;">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </div>
    </div>

    {{-- Tabel Ringkasan per Pesanan --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pesan</th>
                <th>No. Resi</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Ongkir</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $pesanan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pesanan->tanggal_pesan->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $pesanan->no_resi }}</td>
                    <td class="text-right">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right" style="color: #dc2626;">- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($pesanan->ongkos_kirim, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data pendapatan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right font-bold">TOTAL PENDAPATAN</td>
                <td class="text-right font-bold" style="color: #1a5cff;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br>
        <strong>Owner Elektronik Modern</strong>
    </div>
</body>
</html>
