@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Overview</h1>
    <p class="text-slate-500 mt-1">Welcome back, {{ session('admin_name', 'Admin') }}! Here's what's happening today.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Pesanan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Pesanan Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalPesanan }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
            <i class="fas fa-shopping-cart text-xl"></i>
        </div>
    </div>

    <!-- Card 2: Pendapatan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Pendapatan Hari Ini</p>
            <h3 class="text-3xl font-bold text-emerald-600">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
            <i class="fas fa-money-bill-wave text-xl"></i>
        </div>
    </div>

    <!-- Card 3: Antrian Aktif -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Antrian Aktif</p>
            <h3 class="text-3xl font-bold text-amber-500">{{ $antrianAktif }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
            <i class="fas fa-clock text-xl"></i>
        </div>
    </div>

    <!-- Card 4: Total Pelanggan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Pelanggan</p>
            <h3 class="text-3xl font-bold text-indigo-500">{{ $totalPelanggan }}</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
            <i class="fas fa-users text-xl"></i>
        </div>
    </div>
</div>

<!-- Recent Orders Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="text-lg font-bold text-slate-800">Pesanan Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-slate-500 text-sm border-b border-slate-200">
                    <th class="px-6 py-4 font-medium">ID Pesanan</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Kendaraan</th>
                    <th class="px-6 py-4 font-medium">Layanan</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pesananTerbaru as $pesanan)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-slate-800">#ORD-{{ str_pad($pesanan->id_booking, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        <div class="font-medium text-slate-800">{{ $pesanan->pelanggan->nama ?? 'Unknown' }}</div>
                        <div class="text-xs text-slate-500">{{ $pesanan->pelanggan->no_hp ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $pesanan->motor->plat_nomor ?? '-' }}<br>
                        <span class="text-xs text-slate-500">{{ $pesanan->motor->merk_motor ?? '-' }} {{ $pesanan->motor->tipe_motor ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $pesanan->paket->nama_paket ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $badgeClass = 'bg-slate-100 text-slate-700';
                            if ($pesanan->status_booking == 'Dikonfirmasi') $badgeClass = 'bg-blue-100 text-blue-700';
                            if ($pesanan->status_booking == 'Diproses') $badgeClass = 'bg-amber-100 text-amber-700';
                            if ($pesanan->status_booking == 'Selesai') $badgeClass = 'bg-green-100 text-green-700';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                            {{ $pesanan->status_booking }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                            <p>Belum ada pesanan terbaru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
