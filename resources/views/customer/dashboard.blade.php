@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm">
    <div class="flex">
        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
        <div class="ml-3">
            <p class="text-sm text-emerald-800">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if($activeBooking && $activeBooking->status_booking == 'Selesai')
<div class="bg-green-50 border border-green-200 text-green-800 p-5 mb-6 rounded-2xl shadow-sm flex items-center justify-between">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-bell text-2xl text-green-600 animate-bounce"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg text-green-800">Pencucian Selesai!</h3>
            <p class="text-sm text-green-700">Kendaraan <strong>{{ $activeBooking->motor->merk_motor }} ({{ $activeBooking->motor->plat_nomor }})</strong> Anda telah selesai dicuci dan sudah wangi. Silakan ambil di Steamify!</p>
        </div>
    </div>
    @if($activeBooking->transaksi && $activeBooking->transaksi->sisa_bayar > 0)
        <div class="text-right bg-orange-100 px-4 py-2 rounded-lg border border-orange-200 ml-4">
            <p class="text-xs text-orange-600 font-bold uppercase mb-1">Sisa Tagihan DP</p>
            <p class="font-bold text-orange-700">Rp {{ number_format($activeBooking->transaksi->sisa_bayar, 0, ',', '.') }}</p>
        </div>
    @endif
</div>

@if(!$activeBooking->rating)
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6 text-center">
    <h3 class="font-bold text-slate-800 mb-2">Bagaimana Pelayanan Kami?</h3>
    <p class="text-sm text-slate-500 mb-4">Berikan penilaian Anda untuk layanan cuci motor ini.</p>
    
    <form action="{{ route('customer.review.store', $activeBooking->id_booking) }}" method="POST">
        @csrf
        <div class="flex justify-center space-x-2 mb-4 rating-stars">
            @for($i=5; $i>=1; $i--)
                <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="hidden peer" required />
                <label for="star{{$i}}" class="cursor-pointer text-3xl text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition" style="direction: rtl;">
                    <i class="fas fa-star"></i>
                </label>
            @endfor
        </div>
        <!-- Style to make hovering stars work nicely (CSS sibling selector logic) -->
        <style>
            .rating-stars { direction: rtl; display: inline-flex; }
            .rating-stars label:hover ~ label { color: #facc15; }
        </style>
        
        <textarea name="komentar" rows="2" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none mb-3" placeholder="Tulis komentar/masukan Anda (opsional)..."></textarea>
        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition">Kirim Ulasan</button>
    </form>
</div>
@endif

@endif

@if($activeBooking)
<!-- Progress Antrian -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <p class="text-slate-500 text-sm">Nomor Antrian Anda</p>
            <h2 class="text-2xl font-bold text-blue-700">{{ $activeBooking->nomor_antrian ?? 'Belum ada' }}</h2>
        </div>
        <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold flex items-center">
            @if($activeBooking->status_booking == 'Pending')
                Menunggu Pembayaran
            @else
                <div class="w-2 h-2 bg-blue-600 rounded-full mr-2 animate-pulse"></div> {{ $activeBooking->status_booking }}
            @endif
        </span>
    </div>

    <!-- Timeline Progress -->
    <div class="relative w-full mx-auto px-4">
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-slate-200 rounded-full z-0"></div>
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1/3 h-1 {{ $activeBooking->status_booking == 'Diproses' ? 'w-2/3 bg-amber-500' : ($activeBooking->status_booking == 'Selesai' ? 'w-full bg-green-500' : 'bg-blue-600') }} rounded-full z-0"></div>
        
        <div class="relative z-10 flex justify-between text-sm font-medium">
            <!-- Step 1 (Active) -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full {{ in_array($activeBooking->status_booking, ['Dikonfirmasi', 'Diproses', 'Selesai']) ? 'bg-blue-600 text-white' : 'bg-white text-slate-400 border-4 border-slate-200' }} flex items-center justify-center mb-2 shadow-sm">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <span class="{{ in_array($activeBooking->status_booking, ['Dikonfirmasi', 'Diproses', 'Selesai']) ? 'text-blue-600 font-bold' : 'text-slate-400' }}">Menunggu</span>
            </div>
            <!-- Step 2 -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full {{ in_array($activeBooking->status_booking, ['Diproses', 'Selesai']) ? 'bg-amber-500 text-white border-none' : 'bg-white text-slate-400 border-4 border-slate-200' }} flex items-center justify-center mb-2 shadow-sm">
                    <i class="fas fa-car-wash"></i>
                </div>
                <span class="{{ in_array($activeBooking->status_booking, ['Diproses', 'Selesai']) ? 'text-amber-500 font-bold' : 'text-slate-400' }}">Diproses</span>
            </div>
            <!-- Step 3 -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full {{ $activeBooking->status_booking == 'Selesai' ? 'bg-green-500 text-white border-none' : 'bg-white text-slate-400 border-4 border-slate-200' }} flex items-center justify-center mb-2 shadow-sm">
                    <i class="fas fa-check"></i>
                </div>
                <span class="{{ $activeBooking->status_booking == 'Selesai' ? 'text-green-500 font-bold' : 'text-slate-400' }}">Selesai</span>
            </div>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pesanan Aktif -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-800">Pesanan Aktif</h3>
            <a href="{{ route('customer.history') }}" class="text-blue-600 text-sm font-medium hover:underline">Riwayat</a>
        </div>
        
        @if($activeBooking)
        <div class="flex items-center gap-6">
            <div class="w-48 h-32 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center text-slate-300">
                <i class="fas fa-motorcycle text-5xl"></i>
            </div>
            <div class="flex-1 space-y-3">
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-500 text-sm">Motor</span>
                    <span class="font-bold text-slate-800">{{ $activeBooking->motor->merk_motor ?? '-' }} {{ $activeBooking->motor->tipe_motor ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-500 text-sm">Layanan</span>
                    <span class="font-bold text-slate-800">{{ $activeBooking->paket->nama_paket ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 text-sm">Estimasi Biaya</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($activeBooking->paket->harga ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @else
        <div class="flex flex-col items-center justify-center h-full text-slate-400">
            <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
            <p>Belum ada pesanan aktif.</p>
        </div>
        @endif
    </div>

    <!-- Kolom Kanan (Poin & New Order) -->
    <div class="space-y-6">


        <!-- Add New Order -->
        <a href="{{ route('customer.booking') }}" class="block border-2 border-dashed border-blue-300 bg-blue-50/50 rounded-2xl p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
            <div class="w-12 h-12 bg-blue-600 text-white rounded-full mx-auto flex items-center justify-center text-xl mb-3 shadow-sm">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-bold text-blue-800">Pesan Layanan Baru</span>
        </a>
    </div>
</div>
@endsection