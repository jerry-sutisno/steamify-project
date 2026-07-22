<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        \App\Models\Admin::create([
            'nama_admin' => 'Administrator',
            'email' => 'admin@steamify.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);

        // 2. Buat Akun Pelanggan Default
        \App\Models\Pelanggan::create([
            'nama' => 'Budi Pelanggan',
            'email' => 'pelanggan@steamify.com',
            'no_hp' => '081234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);

        // 3. Buat Paket Layanan
        \App\Models\PaketLayanan::insert([
            ['nama_paket' => 'Cuci Body Saja', 'harga' => 15000, 'estimasi_waktu' => 15],
            ['nama_paket' => 'Cuci Standar', 'harga' => 20000, 'estimasi_waktu' => 30],
            ['nama_paket' => 'Cuci Salju + Wax', 'harga' => 35000, 'estimasi_waktu' => 45],
            ['nama_paket' => 'Cuci Komplit (Detailing)', 'harga' => 75000, 'estimasi_waktu' => 90],
        ]);

        // 4. Buat Jadwal / Slot Waktu
        $jamBuka = 8;
        $jamTutup = 17;
        
        $jadwalData = [];
        for ($i = $jamBuka; $i < $jamTutup; $i++) {
            $jadwalData[] = [
                'jam_slot' => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                'status_ketersediaan' => 'Tersedia'
            ];
            $jadwalData[] = [
                'jam_slot' => str_pad($i, 2, '0', STR_PAD_LEFT) . ':30:00',
                'status_ketersediaan' => 'Tersedia'
            ];
        }
        
        \App\Models\Jadwal::insert($jadwalData);
    }
}
