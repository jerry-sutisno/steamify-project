@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.schedules') }}" class="mr-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Edit Jadwal</h1>
        <p class="text-slate-500 mt-1">Perbarui slot jam operasi atau status ketersediaan jadwal ini.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-2xl">
    <form action="{{ route('admin.schedules.update', $schedule->id_jadwal) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Jam Slot</label>
                <input type="time" name="jam" value="{{ \Carbon\Carbon::parse($schedule->jam_slot)->format('H:i') }}" required class="w-full px-4 py-2 rounded-lg border @error('jam') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none">
                @error('jam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Status Ketersediaan</label>
                <select name="status_ketersediaan" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
                    <option value="Tersedia" {{ $schedule->status_ketersediaan == 'Tersedia' ? 'selected' : '' }}>Tersedia (Aktif)</option>
                    <option value="Penuh" {{ $schedule->status_ketersediaan == 'Penuh' ? 'selected' : '' }}>Penuh (Terkunci)</option>
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
