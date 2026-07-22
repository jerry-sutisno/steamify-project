@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.users') }}" class="mr-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Edit User (Pelanggan)</h1>
        <p class="text-slate-500 mt-1">Perbarui data profil atau atur ulang kata sandi pelanggan.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-3xl">
    <form action="{{ route('admin.users.update', $user->id_pelanggan) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full px-4 py-2 rounded-lg border @error('nama') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 rounded-lg border @error('email') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Nomor HP</label>
                <input type="number" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required class="w-full px-4 py-2 rounded-lg border @error('no_hp') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none">
                @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
                <p class="text-xs text-slate-500 mt-1">Isi hanya jika Anda ingin mengatur ulang password user ini.</p>
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
