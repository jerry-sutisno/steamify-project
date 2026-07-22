@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Book a Wash</h2>
    <p class="text-slate-500">Ikuti langkah berikut untuk memesan layanan cuci motor premium.</p>
</div>

<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
    <form action="{{ route('customer.booking.store') }}" method="POST">
        @csrf
        
        <!-- Step 1: Kendaraan -->
        <div class="mb-10">
            <h3 class="text-lg font-bold text-slate-800 flex items-center mb-4">
                <i class="fas fa-motorcycle text-blue-600 mr-2"></i> Pilih Motor Anda
            </h3>
            
            @if($motors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($motors as $motor)
                    <label class="border-2 border-slate-100 rounded-2xl p-5 cursor-pointer hover:border-blue-300 hover:shadow-md transition-all duration-300 relative block has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50 has-[:checked]:shadow-blue-900/5 group">
                        <input type="radio" name="id_motor" value="{{ $motor->id_motor }}" class="hidden" required>
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-slate-100 group-has-[:checked]:bg-blue-600 text-slate-500 group-has-[:checked]:text-white rounded-full flex items-center justify-center text-xl transition-colors duration-300 shadow-sm">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div class="w-6 h-6 rounded-full border-2 border-slate-300 group-has-[:checked]:border-blue-600 group-has-[:checked]:bg-blue-600 flex items-center justify-center transition-colors duration-300">
                                <i class="fas fa-check text-white text-xs opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <h4 class="font-extrabold text-xl text-slate-800 tracking-tight">{{ $motor->plat_nomor }}</h4>
                        <p class="text-sm text-slate-500 mt-1 font-medium">{{ $motor->merk_motor }} {{ $motor->tipe_motor }}</p>
                        <div class="mt-4">
                            <span class="inline-block bg-slate-100 group-has-[:checked]:bg-white px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 border border-slate-200 group-has-[:checked]:border-blue-200 shadow-sm">
                                Warna: {{ $motor->warna_motor ?? 'Standar' }}
                            </span>
                        </div>
                    </label>
                    @endforeach
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-8 rounded-2xl text-center shadow-sm">
                    <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4 class="font-bold text-xl mb-2">Belum Ada Kendaraan</h4>
                    <p class="text-slate-600 mb-6 max-w-md mx-auto">Anda belum menambahkan data kendaraan. Anda harus mendaftarkan setidaknya satu motor sebelum bisa melakukan booking cuci.</p>
                    <a href="{{ route('customer.vehicles') }}" class="inline-block bg-amber-500 text-white font-bold px-8 py-3 rounded-xl hover:bg-amber-600 hover:-translate-y-1 transition-all shadow-lg shadow-amber-500/30">
                        <i class="fas fa-plus mr-2"></i> Tambah Kendaraan Sekarang
                    </a>
                </div>
            @endif
        </div>

        <!-- Step 2: Paket -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-800 flex items-center mb-4">
                <i class="fas fa-car-wash text-blue-600 mr-2"></i> Pilih Paket
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($pakets as $paket)
                <label class="border border-slate-200 rounded-2xl p-6 cursor-pointer hover:border-blue-500 relative block has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                    <input type="radio" name="id_paket" value="{{ $paket->id_paket }}" class="hidden" required>
                    <h4 class="font-bold text-lg">{{ $paket->nama_paket }}</h4>
                    <p class="text-sm text-slate-500 mb-2">Waktu: {{ $paket->estimasi_waktu }} Menit</p>
                    <p class="text-xs text-slate-600 mb-4 h-12 overflow-hidden">{{ $paket->deskripsi ?? 'Paket layanan cuci motor.' }}</p>
                    <h2 class="text-2xl font-bold mb-4 text-blue-700">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h2>
                    <div class="w-full py-2 text-center rounded-lg border border-slate-300 text-slate-600 font-medium check-indicator">Pilih</div>
                </label>
                @endforeach
            </div>
            <style>
                input:checked ~ .check-indicator {
                    background-color: #2563eb;
                    color: white;
                    border-color: #2563eb;
                    content: "Terpilih";
                }
            </style>
        </div>

        <!-- Step 3: Jadwal -->
        <div class="mb-8 border-t border-slate-100 pt-8">
            <h3 class="text-lg font-bold text-slate-800 flex items-center mb-4">
                <i class="far fa-calendar-alt text-blue-600 mr-2"></i> Jadwal Booking
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="border border-slate-200 rounded-xl p-4">
                    <input type="date" id="tanggal_booking" name="tanggal_booking" required class="w-full p-2 border-none outline-none font-semibold text-slate-700 bg-transparent" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                </div>
                <div class="border border-slate-200 rounded-xl p-6">
                    <p class="text-sm font-semibold mb-4">Pilih Waktu Tersedia</p>
                    <div class="grid grid-cols-3 gap-3" id="jadwal-container">
                        @foreach($jadwals as $jadwal)
                            <label class="jadwal-label border border-green-200 bg-green-50 text-green-700 text-center py-2 rounded-lg cursor-pointer text-sm font-semibold hover:bg-green-100 has-[:checked]:bg-green-600 has-[:checked]:text-white transition" data-id="{{ $jadwal->id_jadwal }}">
                                <input type="radio" name="id_jadwal" value="{{ $jadwal->id_jadwal }}" class="hidden jadwal-radio" required> 
                                <span>{{ \Carbon\Carbon::parse($jadwal->jam_slot)->format('H:i') }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateInput = document.getElementById('tanggal_booking');
                
                function fetchAvailability() {
                    const selectedDate = dateInput.value;
                    if(!selectedDate) return;

                    // Reset semua pilihan jam agar tidak terbawa dari tanggal sebelumnya
                    document.querySelectorAll('.jadwal-radio').forEach(radio => radio.checked = false);

                    fetch(`{{ route('customer.booking.check') }}?tanggal=${selectedDate}`)
                        .then(response => response.json())
                        .then(bookedIds => {
                            const labels = document.querySelectorAll('.jadwal-label');
                            labels.forEach(label => {
                                const id = parseInt(label.getAttribute('data-id'));
                                const radio = label.querySelector('.jadwal-radio');
                                const span = label.querySelector('span');
                                
                                // Reset classes
                                label.className = 'jadwal-label border text-center py-2 rounded-lg text-sm font-semibold transition ';
                                
                                if (bookedIds.includes(id)) {
                                    // Penuh / Terbooking
                                    label.className += 'border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed';
                                    radio.disabled = true;
                                    // Hilangkan tulisan (Penuh) jika sebelumnya ada, lalu tambahkan ulang agar tidak double
                                    let timeText = span.innerText.replace(' (Penuh)', '');
                                    span.innerText = timeText + ' (Penuh)';
                                } else {
                                    // Tersedia
                                    label.className += 'border-green-200 bg-green-50 text-green-700 cursor-pointer hover:bg-green-100 has-[:checked]:bg-green-600 has-[:checked]:text-white';
                                    radio.disabled = false;
                                    // Hilangkan tulisan (Penuh)
                                    let timeText = span.innerText.replace(' (Penuh)', '');
                                    span.innerText = timeText;
                                }
                            });
                        });
                }

                // Check saat tanggal diganti
                dateInput.addEventListener('change', fetchAvailability);
                
                // Check saat halaman pertama kali dimuat
                fetchAvailability();
            });
        </script>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition text-lg shadow-lg">Lanjutkan Pembayaran</button>
    </form>
</div>
@endsection