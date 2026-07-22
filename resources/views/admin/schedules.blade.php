@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Kelola Jadwal Slot</h1>
        <p class="text-slate-500 mt-1">Atur jam buka dan ketersediaan slot cucian.</p>
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
            <h3 class="font-bold text-lg mb-4">Tambah Slot Jadwal</h3>
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Jam (Contoh: 10:00)</label>
                    <input type="time" name="jam" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Tambah Jadwal</button>
            </form>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                        <th class="px-6 py-4 font-medium">Jam</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($schedules as $s)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ \Carbon\Carbon::parse($s->jam_slot)->format('H:i') }}</td>
                        <td class="px-6 py-4">
                            @if($s->status_ketersediaan == 'Tersedia')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Penuh</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.schedules.edit', $s->id_jadwal) }}" class="text-blue-500 hover:text-blue-700" title="Edit Jadwal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $s->id_jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus Jadwal"><i class="fas fa-trash"></i> Hapus</button>
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
