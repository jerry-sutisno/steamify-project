<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Steamify</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1e40af; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #64748b; font-size: 14px; }
        .period { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        th { background-color: #f1f5f9; color: #475569; text-align: left; padding: 10px; border: 1px solid #e2e8f0; }
        td { padding: 10px; border: 1px solid #e2e8f0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary-box { width: 300px; float: right; border: 1px solid #e2e8f0; border-radius: 5px; padding: 15px; background-color: #f8fafc; }
        .summary-row { margin-bottom: 10px; font-size: 14px; }
        .summary-label { display: inline-block; width: 120px; color: #64748b; }
        .summary-value { display: inline-block; width: 140px; text-align: right; font-weight: bold; }
        .total-row { border-top: 1px solid #cbd5e1; padding-top: 10px; margin-top: 10px; color: #1e40af; font-size: 16px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header">
        <h1>STEAMIFY</h1>
        <p>Laporan Pendapatan Layanan Cuci Motor</p>
    </div>
    
    <div class="period">
        Laporan Keuangan {{ ucfirst($tipe) }}<br>
        <span style="font-size: 12px; color: #64748b; font-weight: normal;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Struk</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Metode</th>
                <th class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d/m/Y') }}</td>
                <td>{{ $trx->nomor_struk }}</td>
                <td>{{ $trx->booking->pelanggan->nama ?? 'Unknown' }}</td>
                <td>{{ $trx->booking->paket->nama_paket ?? '-' }}</td>
                <td>{{ $trx->metode_bayar }}</td>
                <td class="text-right">{{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box clearfix">
        <div class="summary-row">
            <span class="summary-label">Subtotal :</span>
            <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Pajak (10%) :</span>
            <span class="summary-value">Rp {{ number_format($tax, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row total-row">
            <span class="summary-label">Total Revenue :</span>
            <span class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
</body>
</html>
