@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Laporan Keuangan</h2>
        <p class="text-slate-500">Ringkasan pendapatan dari transaksi cuci motor.</p>
    </div>
    <div class="flex items-center space-x-3">
        <form action="{{ route('admin.reports') }}" method="GET" class="flex items-center bg-white p-2 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center space-x-2 mr-4">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-500 uppercase font-bold px-1 mb-1">Tipe Laporan</span>
                    <select name="tipe" id="tipeSelect" onchange="toggleMinggu()" class="text-sm border-none bg-slate-50 rounded-lg px-3 py-1.5 outline-none focus:ring-1 focus:ring-blue-500 text-slate-700 font-medium cursor-pointer">
                        <option value="bulanan" {{ $tipe == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="mingguan" {{ $tipe == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-500 uppercase font-bold px-1 mb-1">Pilih Bulan</span>
                    <input type="month" name="bulan" value="{{ $bulan }}" class="text-sm border-none bg-slate-50 rounded-lg px-3 py-1.5 outline-none focus:ring-1 focus:ring-blue-500 text-slate-700 font-medium cursor-pointer">
                </div>
                <div class="flex flex-col" id="mingguContainer" style="{{ $tipe == 'mingguan' ? '' : 'display:none;' }}">
                    <span class="text-[10px] text-slate-500 uppercase font-bold px-1 mb-1">Minggu Ke-</span>
                    <select name="minggu_ke" class="text-sm border-none bg-slate-50 rounded-lg px-3 py-1.5 outline-none focus:ring-1 focus:ring-blue-500 text-slate-700 font-medium cursor-pointer">
                        <option value="1" {{ $mingguKe == '1' ? 'selected' : '' }}>1 (Tgl 1-7)</option>
                        <option value="2" {{ $mingguKe == '2' ? 'selected' : '' }}>2 (Tgl 8-14)</option>
                        <option value="3" {{ $mingguKe == '3' ? 'selected' : '' }}>3 (Tgl 15-21)</option>
                        <option value="4" {{ $mingguKe == '4' ? 'selected' : '' }}>4 (Tgl 22-Akhir)</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-900 transition">Filter</button>
        </form>

        <script>
            function toggleMinggu() {
                var tipe = document.getElementById('tipeSelect').value;
                document.getElementById('mingguContainer').style.display = (tipe === 'mingguan') ? 'flex' : 'none';
            }
        </script>
        
        <form action="{{ route('admin.reports.pdf') }}" method="GET">
            <input type="hidden" name="tipe" value="{{ $tipe }}">
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="minggu_ke" value="{{ $mingguKe }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-blue-700 transition flex items-center shadow-sm">
                <i class="fas fa-file-pdf mr-2"></i> Generate PDF
            </button>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 font-medium">Subtotal Pendapatan</h3>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
        <p class="text-sm text-slate-400 mt-2">Total pembayaran kotor</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 font-medium">Pajak (10%)</h3>
            <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-slate-800">Rp {{ number_format($tax, 0, ',', '.') }}</div>
        <p class="text-sm text-slate-400 mt-2">Estimasi potongan pajak</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-200 bg-gradient-to-br from-blue-50 to-white relative overflow-hidden">

        <div class="flex items-center justify-between mb-4 relative z-10">
            <h3 class="text-blue-800 font-bold">Total Revenue</h3>
            <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-coins"></i>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-blue-700 relative z-10">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <p class="text-sm text-blue-500 mt-2 font-medium relative z-10">Pendapatan bersih (Subtotal + Pajak)</p>
    </div>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Rincian Transaksi</h3>
        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $transactions->count() }} Transaksi</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-100">Tanggal</th>
                    <th class="p-4 font-semibold border-b border-slate-100">No. Struk</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Pelanggan</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Layanan</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Metode</th>
                    <th class="p-4 font-semibold border-b border-slate-100 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-slate-500">{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y') }}</td>
                    <td class="p-4 font-medium text-slate-700">{{ $trx->nomor_struk }}</td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-800">{{ $trx->booking->pelanggan->nama ?? 'Unknown' }}</div>
                    </td>
                    <td class="p-4 text-slate-600">{{ $trx->booking->paket->nama_paket ?? '-' }}</td>
                    <td class="p-4">
                        <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium">{{ $trx->metode_bayar }}</span>
                    </td>
                    <td class="p-4 text-right font-bold text-slate-800">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">
                        <p>Tidak ada data transaksi pada rentang tanggal tersebut.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
