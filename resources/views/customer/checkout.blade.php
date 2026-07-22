@extends('layouts.app')

@section('content')
<div class="flex items-center mb-6 text-slate-800 cursor-pointer hover:text-blue-600 w-fit" onclick="history.back()">
    <i class="fas fa-arrow-left mr-3 text-xl"></i>
    <h2 class="text-2xl font-bold">Checkout</h2>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Order Summary -->
    <div class="w-full lg:w-1/3 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Order Summary</h3>
        
        <div class="flex items-center p-3 bg-slate-50 rounded-lg mb-6">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl mr-4">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Honda Vario 150</h4>
                <p class="text-xs text-slate-500">License Plate: B 1234 ABC</p>
            </div>
        </div>

        <div class="space-y-4 border-b border-slate-200 pb-4 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-slate-800 text-sm">Premium Package</p>
                    <p class="text-xs text-slate-500">Deep Shine Wash</p>
                </div>
                <p class="font-semibold text-slate-800 text-sm">Rp 45.000</p>
            </div>
            <div class="flex justify-between items-center">
                <p class="text-slate-500 text-sm">Service Fee</p>
                <p class="font-semibold text-slate-800 text-sm">Rp 2.000</p>
            </div>
        </div>

        <div class="flex justify-between items-center mb-2">
            <p class="text-sm font-semibold text-slate-500">Total Tagihan</p>
            <p class="text-sm font-semibold text-slate-800">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-slate-100">
            <p class="text-lg font-bold text-slate-800">DP Dibayar Sekarang (50%)</p>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($total / 2, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Payment Method -->
    <div class="w-full lg:w-2/3 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-h-[400px]">
        <form action="{{ route('customer.checkout.pay', $booking->id_booking) }}" method="POST" class="flex flex-col h-full justify-between">
            @csrf
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4">Ketentuan Pembayaran</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <input type="hidden" name="jenis_pembayaran" value="DP">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i> Untuk mengonfirmasi booking, Anda diwajibkan membayar <strong>Uang Muka (DP) sebesar 50%</strong> dari total tagihan saat ini. Sisa pembayaran dilakukan di tempat cuci (kasir). Jika Anda batal datang, DP hangus.
                    </p>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-4">Payment Method</h3>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Transfer Bank -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment" value="Transfer Bank" class="peer hidden" required>
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-600 hover:bg-blue-50 transition h-32 group">
                            <i class="fas fa-university text-3xl text-blue-600 mb-2"></i>
                            <span class="font-semibold text-slate-700 group-hover:text-blue-600">Transfer Bank</span>
                        </div>
                    </label>
                    <!-- QRIS -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment" value="QRIS" class="peer hidden" checked required>
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-600 hover:bg-blue-50 transition h-32 group">
                            <i class="fas fa-qrcode text-3xl text-blue-600 mb-2"></i>
                            <span class="font-semibold text-slate-700 group-hover:text-blue-600">QRIS</span>
                        </div>
                    </label>
                    <!-- E-Wallet -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment" value="E-Wallet" class="peer hidden" required>
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-600 hover:bg-blue-50 transition h-32 group">
                            <i class="fas fa-wallet text-3xl text-blue-600 mb-2"></i>
                            <span class="font-semibold text-slate-700 group-hover:text-blue-600">E-Wallet</span>
                        </div>
                    </label>
                    <!-- Tunai -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment" value="Tunai" class="peer hidden" required>
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-600 hover:bg-blue-50 transition h-32 group">
                            <i class="fas fa-money-bill-wave text-3xl text-blue-600 mb-2"></i>
                            <span class="font-semibold text-slate-700 group-hover:text-blue-600">Tunai</span>
                        </div>
                    </label>
                </div>

                <!-- Dynamic Payment Details -->
                <div id="bank-details" class="hidden mt-6 p-5 border border-blue-200 bg-blue-50 rounded-xl">
                    <h4 class="font-bold text-slate-800 mb-3">Transfer Bank (Virtual Account)</h4>
                    <p class="text-sm text-slate-600 mb-4">Salin Nomor Virtual Account (VA) di bawah ini dan masukkan ke aplikasi M-Banking Anda untuk membayar DP sejumlah <strong class="text-blue-700">Rp {{ number_format($total / 2, 0, ',', '.') }}</strong></p>
                    
                    <div class="bg-white p-4 rounded-lg border border-slate-200 flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">BCA VIRTUAL ACCOUNT</p>
                            <!-- Mock VA Number: Prefix (8077) + Random/ID -->
                            <p class="font-bold text-2xl text-slate-800 tracking-widest mt-1">8077 {{ rand(1000, 9999) }} {{ str_pad($booking->id_booking, 4, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm text-slate-600 mt-1">a.n. Steamify Official</p>
                        </div>
                        <i class="fas fa-copy text-slate-400 hover:text-blue-600 cursor-pointer text-xl" title="Salin VA"></i>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 p-3 rounded-lg flex">
                        <i class="fas fa-lightbulb text-amber-500 mt-1 mr-3"></i>
                        <p class="text-xs text-amber-800">
                            <strong>Simulasi:</strong> Karena ini adalah prototipe, Anda tidak perlu benar-benar mentransfer. Cukup klik tombol <strong>"Bayar Sekarang"</strong> di bawah untuk mensimulasikan bahwa Virtual Account telah berhasil dibayar secara otomatis.
                        </p>
                    </div>
                </div>

                <div id="ewallet-details" class="hidden mt-6 p-5 border border-blue-200 bg-blue-50 rounded-xl">
                    <h4 class="font-bold text-slate-800 mb-3">Pilih Provider E-Wallet</h4>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="ewallet_provider" value="Gopay" class="peer hidden">
                            <div class="border border-slate-200 bg-white rounded-lg p-3 text-center peer-checked:border-blue-600 peer-checked:bg-blue-100 hover:bg-slate-50 transition">
                                <span class="font-bold text-slate-700">GoPay</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="ewallet_provider" value="DANA" class="peer hidden">
                            <div class="border border-slate-200 bg-white rounded-lg p-3 text-center peer-checked:border-blue-600 peer-checked:bg-blue-100 hover:bg-slate-50 transition">
                                <span class="font-bold text-slate-700">DANA</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="ewallet_provider" value="OVO" class="peer hidden">
                            <div class="border border-slate-200 bg-white rounded-lg p-3 text-center peer-checked:border-blue-600 peer-checked:bg-blue-100 hover:bg-slate-50 transition">
                                <span class="font-bold text-slate-700">OVO</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="ewallet_provider" value="ShopeePay" class="peer hidden">
                            <div class="border border-slate-200 bg-white rounded-lg p-3 text-center peer-checked:border-blue-600 peer-checked:bg-blue-100 hover:bg-slate-50 transition">
                                <span class="font-bold text-slate-700">ShopeePay</span>
                            </div>
                        </label>
                    </div>
                    <p class="text-sm text-slate-600">Nomor E-Wallet Steamify: <strong class="text-blue-700">0812-3456-7890</strong></p>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-4 rounded-xl hover:bg-blue-700 transition mt-8 flex justify-center items-center text-lg">
                <i class="fas fa-lock mr-2"></i> Bayar Sekarang
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        const bankDetails = document.getElementById('bank-details');
        const ewalletDetails = document.getElementById('ewallet-details');

        function toggleDetails() {
            let selected = document.querySelector('input[name="payment"]:checked').value;
            
            // Hide all first
            bankDetails.classList.add('hidden');
            ewalletDetails.classList.add('hidden');

            if(selected === 'Transfer Bank') {
                bankDetails.classList.remove('hidden');
            } else if(selected === 'E-Wallet') {
                ewalletDetails.classList.remove('hidden');
            }
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleDetails);
        });

        // Run once on load
        toggleDetails();
    });
</script>
@endsection