<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Motor, PaketLayanan, Jadwal, Booking, Transaksi};
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Halaman Dashboard Pelanggan
    public function dashboard() {
        $user_id = Auth::id(); // Ambil ID pelanggan yang sedang login
        
        // Cari bookingan terakhir (paling baru) dari customer ini
        $latestBooking = Booking::with(['motor', 'paket', 'transaksi'])
                            ->where('id_pelanggan', $user_id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        $activeBooking = null;
        if ($latestBooking) {
            // Jika pesanan terbaru masih aktif (belum selesai)
            if (in_array($latestBooking->status_booking, ['Pending', 'Dikonfirmasi', 'Diproses'])) {
                $activeBooking = $latestBooking;
            } 
            // ATAU jika pesanan terbaru sudah selesai tapi belum di-review
            elseif ($latestBooking->status_booking == 'Selesai' && is_null($latestBooking->rating)) {
                $activeBooking = $latestBooking;
            }
        }

        return view('customer.dashboard', compact('activeBooking'));
    }

    // Menampilkan Daftar Motor Pelanggan
    public function vehicles() {
        $motors = Motor::where('id_pelanggan', Auth::id())->get();
        return view('customer.vehicles', compact('motors'));
    }

    // Simpan Data Motor Baru ke Database
    public function storeVehicle(Request $request) {
        Motor::create([
            'id_pelanggan' => Auth::id(),
            'merk_motor' => $request->merk_motor,
            'tipe_motor' => $request->tipe_motor,
            'warna_motor' => $request->warna_motor,
            'plat_nomor' => strtoupper($request->plat_nomor),
        ]);
        return redirect()->back()->with('success', 'Motor berhasil ditambahkan!');
    }

    // Hapus Motor
    public function destroyVehicle($id) {
        $motor = Motor::where('id_motor', $id)->where('id_pelanggan', Auth::id())->firstOrFail();
        
        // Cek jika motor sedang ada di antrian/booking aktif (opsional)
        $isBooked = Booking::where('id_motor', $id)->whereIn('status_booking', ['Pending', 'Dikonfirmasi', 'Diproses'])->exists();
        if ($isBooked) {
            return redirect()->back()->with('error', 'Gagal menghapus! Motor sedang dalam antrian cucian.');
        }

        $motor->delete();
        return redirect()->back()->with('success', 'Data motor berhasil dihapus!');
    }

    // Halaman Form Booking (Book a Wash)
    public function booking() {
        $motors = Motor::where('id_pelanggan', Auth::id())->get();
        $pakets = PaketLayanan::all();
        // Jadwal master yang statusnya tersedia
        $jadwals = Jadwal::where('status_ketersediaan', 'Tersedia')->orderBy('jam_slot')->get();
        return view('customer.booking', compact('motors', 'pakets', 'jadwals'));
    }

    // Mengecek ketersediaan jam secara dinamis berdasarkan tanggal
    public function checkAvailability(Request $request) {
        $tanggal = $request->tanggal;
        // Cari id_jadwal yang sudah dibooking pada tanggal tersebut (status tidak dibatalkan)
        $bookedJadwalIds = Booking::where('tanggal_booking', $tanggal)
                                  ->whereIn('status_booking', ['Pending', 'Dikonfirmasi', 'Diproses', 'Selesai'])
                                  ->pluck('id_jadwal')
                                  ->toArray();
        return response()->json($bookedJadwalIds);
    }

    // Simpan Draft Booking (Masuk ke status Pending sebelum bayar)
    public function storeBooking(Request $request) {
        // Validasi Anti-Double Booking di sisi server
        $isBooked = Booking::where('tanggal_booking', $request->tanggal_booking)
                           ->where('id_jadwal', $request->id_jadwal)
                           ->whereIn('status_booking', ['Pending', 'Dikonfirmasi', 'Diproses', 'Selesai'])
                           ->exists();
        
        if($isBooked) {
            return redirect()->back()->with('error', 'Mohon maaf, jadwal pada jam tersebut baru saja dipesan oleh orang lain. Silakan pilih jam lain.');
        }

        $booking = Booking::create([
            'id_pelanggan' => Auth::id(),
            'id_motor' => $request->id_motor,
            'id_paket' => $request->id_paket,
            'id_jadwal' => $request->id_jadwal,
            'tanggal_booking' => $request->tanggal_booking,
            'status_booking' => 'Pending'
        ]);
        
        // Arahkan ke halaman pembayaran
        return redirect()->route('customer.checkout', $booking->id_booking);
    }

    // Halaman Checkout (Tagihan)
    public function checkout(int $id) {
        $booking = Booking::with(['motor', 'paket'])->findOrFail($id);
        
        // Pastikan booking ini milik user yang login
        if($booking->id_pelanggan != Auth::id()) abort(403);

        $service_fee = 2000;
        $total = $booking->paket->harga + $service_fee;

        return view('customer.checkout', compact('booking', 'service_fee', 'total'));
    }

    // Proses Pembayaran & Generate Nomor Antrian
    public function processPayment(Request $request, int $id) {
        $booking = Booking::findOrFail($id);
        $service_fee = 2000;
        $total = $booking->paket->harga + $service_fee;

        $jenisPembayaran = 'DP';
        $totalBayar = $total / 2;
        $sisaBayar = $total - $totalBayar;

        // 1. Hitung urutan antrian hari ini (Misal: A-01)
        $jumlahBookingHariIni = Booking::where('tanggal_booking', $booking->tanggal_booking)
                                       ->whereNotNull('nomor_antrian')
                                       ->count();
        $nomorAntrian = 'A-' . str_pad($jumlahBookingHariIni + 1, 2, '0', STR_PAD_LEFT);

        // 2. Buat record Transaksi
        Transaksi::create([
            'id_booking' => $booking->id_booking,
            'nomor_struk' => 'INV-' . time() . rand(10, 99),
            'metode_bayar' => $request->payment ?? 'QRIS', // Default QRIS jika kosong
            'jenis_pembayaran' => $jenisPembayaran,
            'tanggal_bayar' => now(),
            'total_bayar' => $totalBayar,
            'sisa_bayar' => $sisaBayar,
            'status_bayar' => 'Lunas' // Status Lunas berarti kewajiban pembayaran saat ini (Full/DP) sudah dibayar
        ]);

        // 3. Update status booking & masukkan nomor antrian
        $booking->update([
            'status_booking' => 'Dikonfirmasi',
            'nomor_antrian' => $nomorAntrian
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Pembayaran Berhasil! Nomor Antrian Anda: ' . $nomorAntrian);
    }

    // Riwayat Transaksi Pelanggan
    public function history() {
        $transactions = Transaksi::with(['booking.paket'])
                        ->whereHas('booking', function($query) {
                            $query->where('id_pelanggan', Auth::id());
                        })->orderBy('created_at', 'desc')->get();
                        
        return view('customer.history', compact('transactions'));
    }

    // Fitur Cetak Struk
    public function printReceipt($id) {
        $transaksi = Transaksi::with(['booking.paket', 'booking.motor', 'booking.pelanggan'])->findOrFail($id);
        
        // Pastikan hanya pemilik struk atau admin yang bisa cetak (opsional, untuk keamanan)
        if ($transaksi->booking->id_pelanggan != Auth::id() && Auth::user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.receipt', compact('transaksi'));
    }

    // Fitur Rating & Ulasan
    public function storeReview(Request $request, $id) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $booking = Booking::where('id_booking', $id)->where('id_pelanggan', Auth::id())->firstOrFail();
        
        if ($booking->status_booking != 'Selesai') {
            return redirect()->back()->with('error', 'Hanya pesanan yang telah selesai yang bisa diberi ulasan.');
        }

        $booking->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    // Halaman Bantuan / FAQ
    public function help() {
        return view('customer.help');
    }
}