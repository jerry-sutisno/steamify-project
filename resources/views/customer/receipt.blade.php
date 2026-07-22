<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $transaksi->booking->id_booking }}</title>
    <!-- Tailwind CSS (CDN for simple print styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { font-family: 'Courier New', Courier, monospace; }
            .no-print { display: none !important; }
        }
        body { font-family: 'Courier New', Courier, monospace; background-color: #f3f4f6; }
        .receipt-container { max-width: 400px; margin: 2rem auto; background: white; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="no-print text-center mt-8 mb-4">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">Cetak Struk</button>
        <a href="javascript:history.back()" class="text-blue-600 underline ml-4">Kembali</a>
    </div>

    <div class="receipt-container">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold font-sans">STEAMIFY</h1>
            <p class="text-sm">Premium Wash Service</p>
            <p class="text-xs mt-1">Jl. Cuci Bersih No. 123, Bandung</p>
            <p class="text-xs">Telp: 0812-3456-7890</p>
            <div class="border-b-2 border-dashed border-gray-400 mt-4 mb-4"></div>
        </div>

        <!-- Meta -->
        <div class="text-sm mb-4">
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between mt-1">
                <span>No. Transaksi</span>
                <span>TRX-{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between mt-1">
                <span>Pelanggan</span>
                <span>{{ $transaksi->booking->pelanggan->nama }}</span>
            </div>
            <div class="flex justify-between mt-1">
                <span>Kendaraan</span>
                <span>{{ $transaksi->booking->motor->merk_motor }} ({{ $transaksi->booking->motor->plat_nomor }})</span>
            </div>
        </div>

        <div class="border-b-2 border-dashed border-gray-400 mb-4"></div>

        <!-- Items -->
        <div class="text-sm mb-4">
            <div class="flex justify-between mb-2">
                <span class="font-bold">Layanan</span>
                <span class="font-bold">Harga</span>
            </div>
            <div class="flex justify-between">
                <span>{{ $transaksi->booking->paket->nama_paket }}</span>
                <span>Rp {{ number_format($transaksi->booking->paket->harga, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mt-1 text-xs">
                <span>(+ Service Fee)</span>
                <span>Rp 2.000</span>
            </div>
        </div>

        <div class="border-b-2 border-dashed border-gray-400 mb-4"></div>

        <!-- Totals -->
        <div class="text-sm mb-6">
            <div class="flex justify-between font-bold text-lg">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mt-2">
                <span>Metode Bayar</span>
                <span>{{ $transaksi->jenis_pembayaran }} ({{ $transaksi->status_bayar }})</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p class="mt-1">Kritik & Saran: CS@steamify.com</p>
            <p class="mt-4 text-gray-400">--- Powered by Steamify ---</p>
        </div>
    </div>

    <script>
        // Otomatis trigger print saat halaman dimuat (jika mau)
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
