@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Transaksi</h2>
    <p class="text-slate-500">Pantau dan kelola semua data pembayaran layanan.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div class="relative w-96">
            <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
            <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari ID Booking, Struk, atau Nama..." class="w-full border border-slate-300 rounded-lg py-2 pl-10 pr-4 outline-none focus:border-blue-500 text-sm">
        </div>
        <div class="flex items-center space-x-2">
            <label class="text-sm text-slate-500 font-medium">Filter Tanggal:</label>
            <input type="date" id="dateFilter" class="bg-white border border-slate-300 text-slate-700 px-3 py-2 rounded-lg outline-none focus:border-blue-500 text-sm font-medium">
            <button id="resetDate" class="text-slate-400 hover:text-red-500 transition ml-2" title="Reset Tanggal"><i class="fas fa-times"></i></button>
        </div>
    </div>

    <table class="w-full text-left border-collapse" id="transactionsTable">
        <thead>
            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                <th class="py-4 px-6 font-semibold">ID Booking</th>
                <th class="py-4 px-6 font-semibold">Nomor Struk</th>
                <th class="py-4 px-6 font-semibold">Nama Pelanggan</th>
                <th class="py-4 px-6 font-semibold">Metode Bayar</th>
                <th class="py-4 px-6 font-semibold">Tanggal & Waktu</th>
                <th class="py-4 px-6 font-semibold">Total</th>
                <th class="py-4 px-6 font-semibold text-center">Status Bayar</th>
            </tr>
        </thead>
        <tbody class="text-sm text-slate-700">
            @forelse($transactions as $trx)
            <tr class="border-b border-slate-100 hover:bg-slate-50 trx-row">
                <td class="py-4 px-6 font-bold text-blue-600 id-booking">#BK-{{ str_pad($trx->id_booking, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="py-4 px-6 text-slate-500 no-struk">{{ $trx->nomor_struk }}</td>
                <td class="py-4 px-6 font-semibold text-slate-800 nama-pelanggan">{{ $trx->booking->pelanggan->nama ?? 'Unknown' }}</td>
                <td class="py-4 px-6"><i class="fas fa-money-check text-slate-400 mr-2"></i> {{ $trx->metode_bayar }}</td>
                <td class="py-4 px-6 text-slate-500 raw-date" data-date="{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('Y-m-d') }}">{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y, H:i') }}</td>
                <td class="py-4 px-6 font-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                <td class="py-4 px-6 text-center">
                    @if($trx->status_bayar == 'Lunas')
                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Lunas</span>
                    @else
                    <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $trx->status_bayar }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-slate-500">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="p-4 bg-slate-50 text-xs text-slate-500 flex justify-between items-center">
        <span>Menampilkan <span id="countVisible">{{ $transactions->count() }}</span> transaksi</span>
    </div>
</div>

<script>
    function filterTable() {
        let textFilter = document.getElementById('searchInput').value.toLowerCase();
        let dateFilter = document.getElementById('dateFilter').value;
        let rows = document.querySelectorAll('.trx-row');
        let count = 0;
        
        rows.forEach(row => {
            let idBooking = row.querySelector('.id-booking').textContent.toLowerCase();
            let noStruk = row.querySelector('.no-struk').textContent.toLowerCase();
            let nama = row.querySelector('.nama-pelanggan').textContent.toLowerCase();
            let rawDate = row.querySelector('.raw-date').getAttribute('data-date');
            
            let textMatch = idBooking.includes(textFilter) || noStruk.includes(textFilter) || nama.includes(textFilter);
            let dateMatch = dateFilter === "" || rawDate === dateFilter;
            
            if (textMatch && dateMatch) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        
        document.getElementById('countVisible').textContent = count;
    }

    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('dateFilter').addEventListener('change', filterTable);
    
    document.getElementById('resetDate').addEventListener('click', function() {
        document.getElementById('dateFilter').value = '';
        filterTable();
    });

    // Set default filter ke hari ini saat halaman dimuat
    window.addEventListener('DOMContentLoaded', (event) => {
        let today = new Date();
        // Dapatkan format YYYY-MM-DD sesuai zona waktu lokal
        let localISODate = new Date(today.getTime() - (today.getTimezoneOffset() * 60000)).toISOString().split('T')[0];
        document.getElementById('dateFilter').value = localISODate;
        filterTable(); // Jalankan filter agar langsung menyembunyikan data hari lain
    });
</script>
</div>
@endsection