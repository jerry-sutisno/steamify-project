<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin() {
        if(Auth::check()) return redirect()->route('customer.dashboard');
        return view('auth.login');
    }

    // Menampilkan form register
    public function showRegister() {
        if(Auth::check()) return redirect()->route('customer.dashboard');
        return view('auth.register');
    }

    // Proses Simpan Data Register ke Database
    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggan,email|ends_with:@gmail.com',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'password' => 'required|min:6'
        ], [
            'email.ends_with' => 'Anda harus mendaftar menggunakan alamat @gmail.com',
            'no_hp.numeric' => 'Nomor HP hanya boleh berisi angka',
            'no_hp.digits_between' => 'Nomor HP harus berjumlah antara 10 sampai 15 digit angka'
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password)
        ]);

        // Langsung otomatis login setelah daftar
        Auth::login($pelanggan);
        return redirect()->route('customer.dashboard');
    }

    // Proses Cek Login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1. Cek apakah yang login adalah Pelanggan
        $pelanggan = Pelanggan::where('email', $request->email)->first();
        if ($pelanggan && Hash::check($request->password, $pelanggan->password)) {
            Auth::login($pelanggan);
            return redirect()->route('customer.dashboard');
        }

        // 2. Cek apakah yang login adalah Admin
        $admin = \App\Models\Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Buat sesi khusus admin
            session(['is_admin' => true, 'admin_name' => $admin->nama_admin]);
            return redirect()->route('admin.dashboard');
        }

        // Jika salah semua
        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}