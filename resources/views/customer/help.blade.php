@extends('layouts.app')

@section('content')
<div class="mb-8 text-center max-w-2xl mx-auto">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
        <i class="far fa-question-circle text-3xl"></i>
    </div>
    <h2 class="text-3xl font-extrabold text-slate-800">Pusat Bantuan</h2>
    <p class="text-slate-500 mt-2">Temukan jawaban untuk pertanyaan yang paling sering diajukan seputar layanan Steamify.</p>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- FAQ Item 1 -->
        <div class="border-b border-slate-100">
            <button class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq1', this)">
                <span class="font-bold text-slate-800">1. Bagaimana cara memesan layanan cuci motor?</span>
                <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"></i>
            </button>
            <div id="faq1" class="hidden px-6 pb-5 text-sm text-slate-600 leading-relaxed bg-slate-50">
                Sangat mudah! Ikuti langkah berikut:<br>
                1. Masuk ke menu <strong>Booking</strong>.<br>
                2. Jika Anda belum menambahkan kendaraan, silakan tambah dulu di menu <strong>Vehicles</strong>.<br>
                3. Pilih kendaraan Anda, pilih paket cuci yang diinginkan, dan tentukan jadwal (tanggal & jam).<br>
                4. Klik "Lanjut ke Pembayaran" dan Anda akan mendapatkan nomor antrean setelah lunas.
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="border-b border-slate-100">
            <button class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq2', this)">
                <span class="font-bold text-slate-800">2. Metode pembayaran apa saja yang diterima?</span>
                <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"></i>
            </button>
            <div id="faq2" class="hidden px-6 pb-5 text-sm text-slate-600 leading-relaxed bg-slate-50">
                Untuk saat ini, kami menerima pembayaran melalui <strong>QRIS</strong> (mendukung Gopay, OVO, DANA, ShopeePay, M-Banking, dll) serta pembayaran <strong>Tunai (Cash)</strong> jika Anda langsung membayar di kasir Steamify.
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="border-b border-slate-100">
            <button class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq3', this)">
                <span class="font-bold text-slate-800">3. Bagaimana jika saya datang terlambat dari jadwal booking?</span>
                <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"></i>
            </button>
            <div id="faq3" class="hidden px-6 pb-5 text-sm text-slate-600 leading-relaxed bg-slate-50">
                Kami memberikan toleransi keterlambatan maksimal <strong>15 menit</strong> dari jadwal yang Anda pilih. Jika melewati batas waktu tersebut, nomor antrean Anda akan dilewati untuk mendahulukan pelanggan lain, dan Anda harus mengonfirmasi ulang kepada petugas kasir.
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="border-b border-slate-100">
            <button class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq4', this)">
                <span class="font-bold text-slate-800">4. Apakah saya bisa membatalkan pesanan (Refund)?</span>
                <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"></i>
            </button>
            <div id="faq4" class="hidden px-6 pb-5 text-sm text-slate-600 leading-relaxed bg-slate-50">
                Pesanan yang sudah dibayar dan mendapatkan nomor antrean tidak dapat dibatalkan (non-refundable) melalui aplikasi. Namun, Anda dapat mengajukan <strong>Perubahan Jadwal (Reschedule)</strong> dengan menghubungi Customer Service kami maksimal 2 jam sebelum jadwal asli Anda.
            </div>
        </div>

    </div>

    <!-- Contact Support Card -->
    <div class="mt-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-lg p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-center md:text-left flex-1">
            <h3 class="text-2xl font-bold mb-2">Masih Butuh Bantuan?</h3>
            <p class="text-blue-100 text-sm md:text-base">Tim Customer Service Steamify siap membantu Anda setiap hari pukul 08.00 - 20.00.</p>
        </div>
        <a href="https://wa.me/6282120716470" target="_blank" class="bg-white text-blue-700 font-bold px-8 py-4 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-slate-50 transition-all duration-300 flex items-center whitespace-nowrap">
            <i class="fab fa-whatsapp text-2xl mr-3 text-green-500"></i> Hubungi CS
        </a>
    </div>
</div>

<script>
    function toggleFaq(id, btn) {
        const content = document.getElementById(id);
        const icon = btn.querySelector('i');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection
