@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Riwayat Transaksi</h2>
    <p class="text-slate-500">Daftar semua transaksi dan layanan cuci motor Anda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    @if($transactions->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                    <th class="px-6 py-4 font-medium">No. Struk</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium">Layanan</th>
                    <th class="px-6 py-4 font-medium">Total Biaya</th>
                    <th class="px-6 py-4 font-medium">Status Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($transactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $trx->nomor_struk }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $trx->booking->paket->nama_paket ?? '-' }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($trx->status_bayar == 'Lunas')
                            <div class="flex flex-col gap-2">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold text-center">{{ $trx->status_bayar }}</span>
                                <a href="{{ route('customer.receipt', $trx->id_transaksi) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:text-blue-800 text-center">
                                    <i class="fas fa-print mr-1"></i> Cetak Struk
                                </a>
                            </div>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">{{ $trx->status_bayar }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-12 text-center text-slate-400">
        <i class="fas fa-receipt text-6xl mb-4 opacity-50"></i>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Transaksi</h3>
        <p>Anda belum pernah melakukan pemesanan cuci motor.</p>
        <a href="{{ route('customer.booking') }}" class="inline-block mt-4 bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition">Pesan Sekarang</a>
    </div>
    @endif
</div>
@endsection
