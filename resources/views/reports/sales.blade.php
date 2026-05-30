<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan - {{ $namaBulan }} {{ $tahun }}</title>
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
        .font-bold { font-weight: bold; }
        .total-row { background-color: #f1f5f9; font-size: 14px; }
        .footer { margin-top: 50px; text-align: right; }
        .footer p { margin-bottom: 50px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .bg-success { background-color: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ELEKTRONIK MODERN</h1>
        <p>Laporan Penjualan Bulanan</p>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <div class="info">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        <p>Total Pesanan Selesai: <strong>{{ $pesanans->count() }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pesan</th>
                <th>No. Resi</th>
                <th>Customer</th>
                <th>Produk</th>
                <th class="text-right">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $pesanan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pesanan->tanggal_pesan->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $pesanan->no_resi }}</td>
                    <td>{{ $pesanan->user->nama }}</td>
                    <td>
                        @foreach($pesanan->detailPesanans as $detail)
                            {{ $detail->produk->nama_produk }} ({{ $detail->qty }})<br>
                        @endforeach
                    </td>
                    <td class="text-right font-bold">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data penjualan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right font-bold">TOTAL PENDAPATAN</td>
                <td class="text-right font-bold" style="color: #1a5cff;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br>
        <strong>Admin Elektronik Modern</strong>
    </div>
</body>
</html>
