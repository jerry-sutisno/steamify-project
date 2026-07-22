<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Booking, Transaksi, PaketLayanan, Jadwal};

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard() {
        $totalPesanan = Transaksi::whereDate('created_at', today())->count();
        $pendapatan = Transaksi::whereDate('created_at', today())->where('status_bayar', 'Lunas')->sum('total_bayar');
        $antrianAktif = Booking::whereIn('status_booking', ['Dikonfirmasi', 'Diproses'])->count();
        $totalPelanggan = \App\Models\Pelanggan::count();

        $pesananTerbaru = Booking::with(['pelanggan', 'motor', 'paket'])
                            ->whereDate('created_at', today())
                            ->latest()
                            ->get();

        return view('admin.dashboard', compact('totalPesanan', 'pendapatan', 'antrianAktif', 'totalPelanggan', 'pesananTerbaru'));
    }

    // Queue Management (Kanban Board)
    public function queue() {
        // Ambil antrean yang masih aktif (Menunggu & Diproses) untuk semua tanggal
        $menunggu = Booking::with(['pelanggan', 'motor', 'paket'])
                    ->where('status_booking', 'Dikonfirmasi')
                    ->orderBy('tanggal_booking', 'asc')
                    ->get();
                    
        $diproses = Booking::with(['pelanggan', 'motor', 'paket'])
                    ->where('status_booking', 'Diproses')
                    ->orderBy('tanggal_booking', 'asc')
                    ->get();

        // Ambil antrean Selesai HANYA untuk hari ini agar papan tidak menumpuk
        $selesai = Booking::with(['pelanggan', 'motor', 'paket'])
                    ->where('status_booking', 'Selesai')
                    ->whereDate('updated_at', today())
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return view('admin.queue', compact('menunggu', 'diproses', 'selesai'));
    }

    // Mengubah Status Antrian (Misal dari Menunggu -> Diproses)
    public function updateQueueStatus(int $id, string $status) {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_booking' => $status]);
        return redirect()->back()->with('success', 'Status cucian diperbarui!');
    }

    // Halaman Kelola Transaksi
    public function transactions(Request $request) {
        $query = Transaksi::with(['booking.pelanggan']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('booking.pelanggan', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            })->orWhere('nomor_struk', 'like', "%{$search}%")
            ->orWhereHas('booking', function($q) use ($search) {
                $q->where('id_booking', 'like', "%{$search}%");
            });
        }
        
        $transactions = $query->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }

    // --- MANAJEMEN USER (PELANGGAN) ---
    public function users() {
        // Ambil data pelanggan beserta jumlah motor dan jumlah transaksi mereka
        $users = \App\Models\Pelanggan::withCount(['motors', 'bookings'])->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function editUser($id) {
        $user = \App\Models\Pelanggan::findOrFail($id);
        return view('admin.users_edit', compact('user'));
    }

    public function updateUser(Request $request, $id) {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggan,email,'.$id.',id_pelanggan',
            'no_hp' => 'required|numeric|digits_between:10,15',
        ]);
        
        $user = \App\Models\Pelanggan::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        if($request->filled('password')) {
            $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser($id) {
        try {
            \App\Models\Pelanggan::destroy($id);
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.users')->with('error', 'Gagal menghapus user. Pastikan user ini tidak memiliki riwayat kendaraan atau transaksi.');
        }
    }

    // --- MANAJEMEN BOOKING ---
    public function bookings() {
        $bookings = \App\Models\Booking::with(['pelanggan', 'motor', 'paket', 'jadwal', 'transaksi'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function editBooking($id) {
        $booking = \App\Models\Booking::with(['pelanggan', 'motor'])->findOrFail($id);
        $pakets = \App\Models\PaketLayanan::all();
        $jadwals = \App\Models\Jadwal::orderBy('jam_slot')->get();
        return view('admin.bookings_edit', compact('booking', 'pakets', 'jadwals'));
    }

    public function updateBooking(Request $request, $id) {
        $request->validate([
            'tanggal_booking' => 'required|date',
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
            'id_paket' => 'required|exists:paket_layanan,id_paket',
            'status_booking' => 'required|string'
        ]);
        
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->update([
            'tanggal_booking' => $request->tanggal_booking,
            'id_jadwal' => $request->id_jadwal,
            'id_paket' => $request->id_paket,
            'status_booking' => $request->status_booking
        ]);

        return redirect()->route('admin.bookings')->with('success', 'Data booking berhasil diperbarui.');
    }

    public function destroyBooking($id) {
        try {
            \App\Models\Booking::destroy($id);
            return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.bookings')->with('error', 'Gagal menghapus booking. Pastikan booking ini tidak terkait dengan transaksi.');
        }
    }

    public function lunasiPembayaran($id_booking) {
        $transaksi = \App\Models\Transaksi::where('id_booking', $id_booking)->firstOrFail();
        
        if($transaksi->sisa_bayar > 0) {
            $transaksi->update([
                'total_bayar' => $transaksi->total_bayar + $transaksi->sisa_bayar,
                'sisa_bayar' => 0,
                'jenis_pembayaran' => 'Full',
            ]);
            return redirect()->route('admin.bookings')->with('success', 'Sisa pembayaran berhasil dilunasi!');
        }
        
        return redirect()->route('admin.bookings')->with('error', 'Transaksi ini sudah lunas.');
    }

    // --- MANAJEMEN PAKET LAYANAN ---
    public function packages() {
        $packages = PaketLayanan::all();
        return view('admin.packages', compact('packages'));
    }

    public function storePackage(Request $request) {
        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'estimasi_waktu' => 'required|numeric',
            'deskripsi' => 'nullable|string'
        ]);

        PaketLayanan::create($request->all());
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function destroyPackage($id) {
        PaketLayanan::destroy($id);
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil dihapus.');
    }

    public function editPackage($id) {
        $package = PaketLayanan::findOrFail($id);
        return view('admin.packages_edit', compact('package'));
    }

    public function updatePackage(Request $request, $id) {
        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'estimasi_waktu' => 'required|numeric',
            'deskripsi' => 'nullable|string'
        ]);

        $package = PaketLayanan::findOrFail($id);
        $package->update($request->all());
        
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil diperbarui.');
    }

    // --- MANAJEMEN JADWAL ---
    public function schedules() {
        $schedules = Jadwal::orderBy('jam_slot', 'asc')->get();
        return view('admin.schedules', compact('schedules'));
    }

    public function storeSchedule(Request $request) {
        $request->validate([
            'jam' => 'required'
        ]);

        Jadwal::create([
            'jam_slot' => $request->jam,
            'status_ketersediaan' => 'Tersedia'
        ]);
        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function destroySchedule($id) {
        Jadwal::destroy($id);
        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function editSchedule($id) {
        $schedule = Jadwal::findOrFail($id);
        return view('admin.schedules_edit', compact('schedule'));
    }

    public function updateSchedule(Request $request, $id) {
        $request->validate([
            'jam' => 'required',
            'status_ketersediaan' => 'required|string'
        ]);

        $schedule = Jadwal::findOrFail($id);
        $schedule->update([
            'jam_slot' => $request->jam,
            'status_ketersediaan' => $request->status_ketersediaan
        ]);
        
        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // --- MANAJEMEN LAPORAN ---
    public function reports(Request $request) {
        $tipe = $request->input('tipe', 'bulanan');
        $bulan = $request->input('bulan', date('Y-m'));
        $mingguKe = $request->input('minggu_ke', '1');
        
        $dateObj = \Carbon\Carbon::parse($bulan . '-01');

        if ($tipe == 'mingguan') {
            if ($mingguKe == '1') {
                $startDate = $dateObj->copy()->format('Y-m-01');
                $endDate = $dateObj->copy()->format('Y-m-07');
            } elseif ($mingguKe == '2') {
                $startDate = $dateObj->copy()->format('Y-m-08');
                $endDate = $dateObj->copy()->format('Y-m-14');
            } elseif ($mingguKe == '3') {
                $startDate = $dateObj->copy()->format('Y-m-15');
                $endDate = $dateObj->copy()->format('Y-m-21');
            } else {
                $startDate = $dateObj->copy()->format('Y-m-22');
                $endDate = $dateObj->copy()->endOfMonth()->format('Y-m-d');
            }
        } else {
            $startDate = $dateObj->copy()->startOfMonth()->format('Y-m-d');
            $endDate = $dateObj->copy()->endOfMonth()->format('Y-m-d');
        }

        $transactions = Transaksi::with(['booking.pelanggan', 'booking.paket'])
            ->whereDate('tanggal_bayar', '>=', $startDate)
            ->whereDate('tanggal_bayar', '<=', $endDate)
            ->where('status_bayar', 'Lunas')
            ->get();

        $subtotal = $transactions->sum('total_bayar');
        $tax = $subtotal * 0.10;
        $totalRevenue = $subtotal + $tax;

        return view('admin.reports', compact('transactions', 'startDate', 'endDate', 'subtotal', 'tax', 'totalRevenue', 'tipe', 'bulan', 'mingguKe'));
    }

    public function generatePdf(Request $request) {
        $tipe = $request->input('tipe', 'bulanan');
        $bulan = $request->input('bulan', date('Y-m'));
        $mingguKe = $request->input('minggu_ke', '1');
        
        $dateObj = \Carbon\Carbon::parse($bulan . '-01');

        if ($tipe == 'mingguan') {
            if ($mingguKe == '1') {
                $startDate = $dateObj->copy()->format('Y-m-01');
                $endDate = $dateObj->copy()->format('Y-m-07');
            } elseif ($mingguKe == '2') {
                $startDate = $dateObj->copy()->format('Y-m-08');
                $endDate = $dateObj->copy()->format('Y-m-14');
            } elseif ($mingguKe == '3') {
                $startDate = $dateObj->copy()->format('Y-m-15');
                $endDate = $dateObj->copy()->format('Y-m-21');
            } else {
                $startDate = $dateObj->copy()->format('Y-m-22');
                $endDate = $dateObj->copy()->endOfMonth()->format('Y-m-d');
            }
        } else {
            $startDate = $dateObj->copy()->startOfMonth()->format('Y-m-d');
            $endDate = $dateObj->copy()->endOfMonth()->format('Y-m-d');
        }

        $transactions = Transaksi::with(['booking.pelanggan', 'booking.paket'])
            ->whereDate('tanggal_bayar', '>=', $startDate)
            ->whereDate('tanggal_bayar', '<=', $endDate)
            ->where('status_bayar', 'Lunas')
            ->get();

        $subtotal = $transactions->sum('total_bayar');
        $tax = $subtotal * 0.10;
        $totalRevenue = $subtotal + $tax;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports_pdf', compact('transactions', 'startDate', 'endDate', 'subtotal', 'tax', 'totalRevenue', 'tipe', 'bulan', 'mingguKe'));
        return $pdf->download('laporan_transaksi_' . $tipe . '_' . $bulan . '.pdf');
    }
}