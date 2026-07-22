@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Kelola User Pelanggan</h1>
    <p class="text-slate-500 mt-1">Pantau seluruh pengguna yang telah terdaftar di aplikasi Steamify.</p>
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
                <th class="px-6 py-4 font-medium">Nama Pelanggan</th>
                <th class="px-6 py-4 font-medium">Kontak</th>
                <th class="px-6 py-4 font-medium text-center">Jumlah Motor</th>
                <th class="px-6 py-4 font-medium text-center">Total Transaksi</th>
                <th class="px-6 py-4 font-medium text-right">Tanggal Bergabung</th>
                <th class="px-6 py-4 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                            {{ substr($user->nama, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $user->nama }}</p>
                            <p class="text-xs text-slate-500">ID: CUST-{{ str_pad($user->id_pelanggan, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-slate-700"><i class="fas fa-envelope text-slate-400 w-5"></i> {{ $user->email }}</p>
                    <p class="text-sm text-slate-700 mt-1"><i class="fas fa-phone-alt text-slate-400 w-5"></i> {{ $user->no_hp }}</p>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-block bg-slate-100 text-slate-700 font-semibold px-3 py-1 rounded-full text-xs">
                        {{ $user->motors_count }} Motor
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-block bg-blue-50 text-blue-700 font-semibold px-3 py-1 rounded-full text-xs border border-blue-100">
                        {{ $user->bookings_count }} Transaksi
                    </span>
                </td>
                <td class="px-6 py-4 text-right text-sm text-slate-500">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.users.edit', $user->id_pelanggan) }}" class="text-blue-500 hover:text-blue-700 font-medium" title="Edit User">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id_pelanggan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data terkait mungkin akan hilang.');" class="inline-block">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" title="Hapus User"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-users text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada user yang terdaftar.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
