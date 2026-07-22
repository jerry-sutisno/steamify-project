@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Kelola Booking</h1>
    <p class="text-slate-500 mt-1">Pantau, edit jadwal, dan kelola seluruh pesanan masuk dari pelanggan.</p>
</div>

@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg">
    <div class="flex">
        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
        <div class="ml-3">
            <p class="text-sm text-emerald-800">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
    <div class="flex">
        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
        <div class="ml-3">
            <p class="text-sm text-red-800">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                <th class="px-6 py-4 font-medium">No. Antrean</th>
                <th class="px-6 py-4 font-medium">Pelanggan / Motor</th>
                <th class="px-6 py-4 font-medium">Jadwal & Paket</th>
                <th class="px-6 py-4 font-medium text-center">Status</th>
                <th class="px-6 py-4 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($bookings as $booking)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <span class="font-bold text-slate-800">{{ $booking->nomor_antrian ?? 'Belum Dibayar' }}</span>
                    <p class="text-xs text-slate-500 mt-1">ID: BKG-{{ $booking->id_booking }}</p>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center mb-1">
                        <p class="font-bold text-slate-800">{{ $booking->pelanggan->nama }}</p>
                        @if($booking->pelanggan->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->pelanggan->no_hp) }}?text=Halo%20{{ urlencode($booking->pelanggan->nama) }},%20motor%20{{ urlencode($booking->motor->merk_motor) }}%20({{ urlencode($booking->motor->plat_nomor) }})%20Anda%20sudah%20selesai%20dicuci%20dan%20wangi!%20Silakan%20ambil%20di%20Steamify." target="_blank" class="text-green-500 hover:text-green-600 bg-green-50 hover:bg-green-100 rounded-full w-6 h-6 flex items-center justify-center ml-2 transition" title="Kirim Pesan WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                    <p class="text-sm text-slate-500"><i class="fas fa-motorcycle w-4"></i> {{ $booking->motor->plat_nomor }} ({{ $booking->motor->merk_motor }})</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-bold text-blue-600">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->jadwal->jam_slot)->format('H:i') }}</p>
                    <p class="text-sm text-slate-600 mt-1">{{ $booking->paket->nama_paket }}</p>
                    
                    @if($booking->rating)
                    <div class="mt-2 text-yellow-500 text-xs flex items-center" title="{{ $booking->komentar }}">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $booking->rating ? '' : 'text-slate-300' }}"></i>
                        @endfor
                        <span class="text-slate-500 ml-1">({{ $booking->rating }}/5)</span>
                    </div>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($booking->status_booking == 'Pending')
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                    @elseif($booking->status_booking == 'Dikonfirmasi')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                    @elseif($booking->status_booking == 'Diproses')
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Sedang Dicuci</span>
                    @elseif($booking->status_booking == 'Selesai')
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">{{ $booking->status_booking }}</span>
                    @endif
                    
                    @if($booking->transaksi && $booking->transaksi->jenis_pembayaran == 'DP' && $booking->transaksi->sisa_bayar > 0)
                        <div class="mt-2">
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-semibold block">DP (Sisa Rp {{ number_format($booking->transaksi->sisa_bayar, 0, ',', '.') }})</span>
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end space-x-3">
                        @if($booking->transaksi && $booking->transaksi->jenis_pembayaran == 'DP' && $booking->transaksi->sisa_bayar > 0)
                        <form action="{{ route('admin.bookings.lunasi', $booking->id_booking) }}" method="POST" onsubmit="return confirm('Lunasi sisa tagihan Rp {{ number_format($booking->transaksi->sisa_bayar, 0, ',', '.') }}?');" class="inline-block">
                            @csrf
                            <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-bold bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200" title="Lunasi Sisa Pembayaran"><i class="fas fa-check-double mr-1"></i> Lunasi</button>
                        </form>
                        @endif

                        @if($booking->transaksi && $booking->transaksi->status_bayar == 'Lunas')
                        <a href="{{ route('customer.receipt', $booking->transaksi->id_transaksi) }}" target="_blank" class="text-slate-600 hover:text-slate-900 font-medium bg-slate-100 px-3 py-1 rounded-lg border border-slate-200" title="Cetak Struk">
                            <i class="fas fa-print"></i> Struk
                        </a>
                        @endif

                        @if($booking->status_booking != 'Selesai')
                        <a href="{{ route('admin.bookings.edit', $booking->id_booking) }}" class="text-blue-500 hover:text-blue-700 font-medium" title="Edit Booking">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                        
                        <form action="{{ route('admin.bookings.destroy', $booking->id_booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data booking ini?');" class="inline-block">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" title="Hapus Booking"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-calendar-times text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada data booking.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
