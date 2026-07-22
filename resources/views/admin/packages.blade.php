@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Kelola Paket Layanan</h1>
        <p class="text-slate-500 mt-1">Tambah atau hapus paket cucian.</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-bold text-lg mb-4">Tambah Paket Baru</h3>
            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Nama Paket</label>
                    <input type="text" name="nama_paket" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Estimasi Waktu (Menit)</label>
                    <input type="number" name="estimasi_waktu" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Deskripsi Layanan</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none" placeholder="Jelaskan apa saja yang didapat di paket ini..."></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Simpan Paket</button>
            </form>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                        <th class="px-6 py-4 font-medium">Nama Paket</th>
                        <th class="px-6 py-4 font-medium">Harga</th>
                        <th class="px-6 py-4 font-medium">Estimasi Waktu</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($packages as $p)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800 block">{{ $p->nama_paket }}</span>
                            <span class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $p->deskripsi ?? 'Tidak ada deskripsi' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $p->estimasi_waktu }} Menit</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.packages.edit', $p->id_paket) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.packages.destroy', $p->id_paket) }}" method="POST" onsubmit="return confirm('Hapus paket ini?');" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
