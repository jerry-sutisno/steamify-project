@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.packages') }}" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Paket
    </a>
    <h1 class="text-3xl font-bold text-slate-800">Edit Paket Layanan</h1>
    <p class="text-slate-500 mt-1">Perbarui detail, harga, atau deskripsi paket cuci motor.</p>
</div>

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-slate-200 p-8">
    <form action="{{ route('admin.packages.update', $package->id_paket) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Paket</label>
            <input type="text" name="nama_paket" value="{{ old('nama_paket', $package->nama_paket) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $package->harga) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Estimasi Waktu (Menit)</label>
                <input type="number" name="estimasi_waktu" value="{{ old('estimasi_waktu', $package->estimasi_waktu) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition">
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Layanan</label>
            <textarea name="deskripsi" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition" placeholder="Jelaskan secara detail apa saja yang akan didapatkan pelanggan pada paket ini...">{{ old('deskripsi', $package->deskripsi) }}</textarea>
            <p class="text-xs text-slate-500 mt-2">Gunakan deskripsi yang menarik agar pelanggan memahami keuntungan memilih paket ini.</p>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.packages') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
