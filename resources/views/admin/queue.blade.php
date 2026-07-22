@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Queue Management</h2>
        <p class="text-slate-500">Real-time status of wash orders.</p>
    </div>
</div>

<div class="flex gap-6 overflow-x-auto pb-4">
    <!-- Kolom: Menunggu -->
    <div class="min-w-[320px] w-1/3 bg-slate-50 rounded-2xl p-4 border border-slate-200">
        <div class="flex justify-between items-center mb-4 px-1">
            <h3 class="font-bold text-slate-700 flex items-center"><div class="w-3 h-3 bg-slate-400 rounded-full mr-2"></div> Menunggu</h3>
            <span class="bg-slate-200 text-slate-600 px-2 py-0.5 rounded text-xs font-bold">{{ $menunggu->count() }}</span>
        </div>
        
        <div class="space-y-4">
            @foreach($menunggu as $item)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 transition">
                <div class="flex justify-between items-center mb-2 text-xs text-slate-400 font-medium">
                    <span class="flex items-center text-slate-500">
                        <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M') }} 
                        <i class="far fa-clock ml-2 mr-1"></i> {{ \Carbon\Carbon::parse($item->jadwal->jam_slot ?? $item->created_at)->format('H:i') }}
                    </span>
                    <span>#ORD-{{ str_pad($item->id_booking, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h4 class="font-bold text-slate-800 text-lg mb-1">{{ $item->pelanggan->nama ?? 'Unknown' }}</h4>
                <div class="flex items-center text-sm text-slate-500 mb-4">
                    <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mr-2 text-slate-700 font-medium">{{ $item->motor->plat_nomor ?? '-' }}</span> • {{ $item->motor->merk_motor ?? '' }} {{ $item->motor->tipe_motor ?? '' }}
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                    <span class="text-blue-600 text-sm font-bold flex items-center"><i class="fas fa-star text-xs mr-1"></i> {{ $item->paket->nama_paket ?? '-' }}</span>
                    <a href="{{ route('admin.queue.update', ['id' => $item->id_booking, 'status' => 'Diproses']) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Proses <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Kolom: Diproses -->
    <div class="min-w-[320px] w-1/3 bg-blue-50/50 rounded-2xl p-4 border border-blue-100">
        <div class="flex justify-between items-center mb-4 px-1">
            <h3 class="font-bold text-blue-800 flex items-center"><div class="w-3 h-3 bg-blue-600 rounded-full mr-2"></div> Diproses</h3>
            <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded text-xs font-bold">{{ $diproses->count() }}</span>
        </div>
        
        <div class="space-y-4">
            @foreach($diproses as $item)
            <div class="bg-white p-4 rounded-xl shadow border-l-4 border-blue-600">
                <div class="flex justify-between items-center mb-1 text-xs font-medium">
                    <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded flex items-center"><i class="fas fa-tint mr-1 text-[10px]"></i> Washing</span>
                    <span class="text-slate-400">#ORD-{{ str_pad($item->id_booking, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="text-[11px] text-slate-500 mb-2 font-medium flex items-center">
                    <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M') }} 
                    <i class="far fa-clock ml-2 mr-1"></i> {{ \Carbon\Carbon::parse($item->jadwal->jam_slot ?? $item->created_at)->format('H:i') }}
                </div>
                <h4 class="font-bold text-slate-800 text-lg mb-1">{{ $item->pelanggan->nama ?? 'Unknown' }}</h4>
                <div class="flex items-center text-sm text-slate-500 mb-4">
                    <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mr-2 text-slate-700 font-medium">{{ $item->motor->plat_nomor ?? '-' }}</span> • {{ $item->motor->merk_motor ?? '' }} {{ $item->motor->tipe_motor ?? '' }}
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                    <span class="text-slate-600 text-sm font-bold flex items-center"><i class="fas fa-bolt text-xs mr-1"></i> {{ $item->paket->nama_paket ?? '-' }}</span>
                    <a href="{{ route('admin.queue.update', ['id' => $item->id_booking, 'status' => 'Selesai']) }}" class="text-green-600 hover:text-green-800 font-medium text-sm">Selesai <i class="fas fa-check"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Kolom: Selesai -->
    <div class="min-w-[320px] w-1/3 bg-green-50/50 rounded-2xl p-4 border border-green-100">
        <div class="flex justify-between items-center mb-4 px-1">
            <h3 class="font-bold text-green-800 flex items-center"><div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div> Selesai</h3>
            <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded text-xs font-bold">{{ $selesai->count() }}</span>
        </div>
        
        <div class="space-y-4">
            @foreach($selesai as $item)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-1 text-xs font-medium">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded flex items-center"><i class="fas fa-check mr-1 text-[10px]"></i> Ready</span>
                    <span class="text-slate-400">#ORD-{{ str_pad($item->id_booking, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="text-[11px] text-slate-500 mb-2 font-medium flex items-center">
                    <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M') }} 
                    <i class="far fa-clock ml-2 mr-1"></i> {{ \Carbon\Carbon::parse($item->jadwal->jam_slot ?? $item->created_at)->format('H:i') }}
                </div>
                <h4 class="font-bold text-slate-800 text-lg mb-1">{{ $item->pelanggan->nama ?? 'Unknown' }}</h4>
                <div class="flex items-center text-sm text-slate-500 mb-4">
                    <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mr-2 text-slate-700 font-medium">{{ $item->motor->plat_nomor ?? '-' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection