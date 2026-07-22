@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Kendaraan</h2>
    <p class="text-slate-500">Tambahkan dan atur motor yang akan dicuci.</p>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Form Tambah Motor -->
    <div class="w-full lg:w-1/3 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <i class="fas fa-plus-circle text-blue-600 mr-2"></i> Tambah Motor Baru
        </h3>
        <form action="{{ route('customer.vehicles.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Merek Motor</label>
                <select name="merk_motor" class="w-full border border-slate-300 rounded-lg p-3 outline-none focus:border-blue-500">
                    <option>Pilih Merek</option>
                    <option value="Honda">Honda</option>
                    <option value="Yamaha">Yamaha</option>
                    <option value="Kawasaki">Kawasaki</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tipe</label>
                <input type="text" name="tipe_motor" placeholder="Misal: Vario 150" class="w-full border border-slate-300 rounded-lg p-3 outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Warna</label>
                <input type="text" name="warna_motor" placeholder="Pilih Warna" class="w-full border border-slate-300 rounded-lg p-3 outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Polisi</label>
                <input type="text" name="plat_nomor" placeholder="MISAL: B 1234 ABC" class="w-full border border-slate-300 rounded-lg p-3 outline-none focus:border-blue-500 uppercase">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition flex justify-center items-center">
                <i class="fas fa-save mr-2"></i> Simpan Motor
            </button>
        </form>
    </div>

    <!-- Daftar Kendaraan -->
    <div class="w-full lg:w-2/3">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center">
                <i class="fas fa-motorcycle text-blue-600 mr-2"></i> Daftar Kendaraan
            </h3>
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $motors->count() }} Kendaraan</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($motors as $motor)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-5 text-8xl"><i class="fas fa-motorcycle"></i></div>
                <div class="flex justify-between items-start mb-2">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <form action="{{ route('customer.vehicles.destroy', $motor->id_motor) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?');">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-500 mt-1" title="Hapus Kendaraan"><i class="far fa-trash-alt"></i></button>
                    </form>
                </div>
                <h4 class="text-xl font-bold text-slate-800 mt-2">{{ $motor->plat_nomor }}</h4>
                <p class="text-slate-500 text-sm mb-3">{{ $motor->merk_motor }} {{ $motor->tipe_motor }}</p>
                <div class="flex space-x-2">
                    <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded">{{ $motor->warna_motor ?? 'N/A' }}</span>
                </div>
            </div>
            @endforeach
            
            <!-- Card Tambah Kendaraan Lain -->
            <div onclick="document.querySelector('form').scrollIntoView({behavior: 'smooth'})" class="bg-transparent border-2 border-dashed border-slate-300 rounded-2xl flex flex-col items-center justify-center p-6 text-slate-400 hover:border-blue-500 hover:text-blue-500 cursor-pointer transition min-h-[160px]">
                <i class="fas fa-plus-circle text-3xl mb-2"></i>
                <span class="font-medium">Tambah Kendaraan Lain</span>
            </div>
        </div>
    </div>
</div>
@endsection