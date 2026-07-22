@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.bookings') }}" class="mr-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Edit Booking</h1>
        <p class="text-slate-500 mt-1">Ubah jadwal, jam, paket, atau status pesanan milik {{ $booking->pelanggan->nama }}.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-3xl">
    <!-- Info Pesanan -->
    <div class="bg-slate-50 rounded-lg p-4 mb-6 border border-slate-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-slate-500">Nomor Antrean</p>
            <p class="font-bold text-lg text-slate-800">{{ $booking->nomor_antrian ?? 'Belum ada (Pending)' }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-slate-500">Kendaraan</p>
            <p class="font-bold text-slate-800">{{ $booking->motor->plat_nomor }} - {{ $booking->motor->merk_motor }}</p>
        </div>
    </div>

    <form action="{{ route('admin.bookings.update', $booking->id_booking) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Tanggal Booking</label>
                <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking', $booking->tanggal_booking) }}" required class="w-full px-4 py-2 rounded-lg border @error('tanggal_booking') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none">
                @error('tanggal_booking')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Jam Slot (Jadwal)</label>
                <select name="id_jadwal" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
                    @foreach($jadwals as $jadwal)
                        <option value="{{ $jadwal->id_jadwal }}" {{ $booking->id_jadwal == $jadwal->id_jadwal ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($jadwal->jam_slot)->format('H:i') }}
                        </option>
                    @endforeach
                </select>
                @error('id_jadwal')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Paket Layanan</label>
                <select name="id_paket" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
                    @foreach($pakets as $paket)
                        <option value="{{ $paket->id_paket }}" {{ $booking->id_paket == $paket->id_paket ? 'selected' : '' }}>
                            {{ $paket->nama_paket }} (Rp {{ number_format($paket->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Status Booking</label>
                <select name="status_booking" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
                    <option value="Pending" {{ $booking->status_booking == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Dikonfirmasi" {{ $booking->status_booking == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi (Menunggu)</option>
                    <option value="Diproses" {{ $booking->status_booking == 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Dicuci)</option>
                    <option value="Selesai" {{ $booking->status_booking == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ $booking->status_booking == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow-sm">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
