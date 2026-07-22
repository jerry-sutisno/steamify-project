<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { return redirect('/login'); });

// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- CUSTOMER AREA (Hanya bisa diakses kalau sudah login) ---
Route::prefix('customer')->name('customer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/vehicles', [CustomerController::class, 'vehicles'])->name('vehicles');
    Route::post('/vehicles', [CustomerController::class, 'storeVehicle'])->name('vehicles.store');
    Route::post('/vehicles/{id}/delete', [CustomerController::class, 'destroyVehicle'])->name('vehicles.destroy');
    
    Route::get('/booking', [CustomerController::class, 'booking'])->name('booking');
    Route::post('/booking', [CustomerController::class, 'storeBooking'])->name('booking.store');
    Route::get('/booking/check-availability', [CustomerController::class, 'checkAvailability'])->name('booking.check');
    
    Route::get('/checkout/{id}', [CustomerController::class, 'checkout'])->name('checkout');
    // Rute untuk mengeksekusi pembayaran
    Route::post('/checkout/{id}/pay', [CustomerController::class, 'processPayment'])->name('checkout.pay');
    
    Route::post('/booking/{id}/review', [CustomerController::class, 'storeReview'])->name('review.store');
        
    // Fitur Cetak Struk
    Route::get('/receipt/{id}', [CustomerController::class, 'printReceipt'])->name('receipt');

    Route::get('/history', [CustomerController::class, 'history'])->name('history');
    
    Route::get('/help', [CustomerController::class, 'help'])->name('help');
});

// --- ADMIN AREA ---
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/queue', [AdminController::class, 'queue'])->name('queue');
    Route::get('/queue/{id}/status/{status}', [AdminController::class, 'updateQueueStatus'])->name('queue.update');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    
    // Kelola User
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{id}/delete', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Kelola Booking
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{id}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::post('/bookings/{id}/update', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::post('/bookings/{id}/delete', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');
    Route::post('/bookings/{id}/lunasi', [AdminController::class, 'lunasiPembayaran'])->name('bookings.lunasi');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/pdf', [AdminController::class, 'generatePdf'])->name('reports.pdf');
    
    // Kelola Paket Layanan
    Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
    Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{id}/edit', [AdminController::class, 'editPackage'])->name('packages.edit');
    Route::post('/packages/{id}/update', [AdminController::class, 'updatePackage'])->name('packages.update');
    Route::post('/packages/{id}/delete', [AdminController::class, 'destroyPackage'])->name('packages.destroy');
    
    // Kelola Jadwal
    Route::get('/schedules', [AdminController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [AdminController::class, 'storeSchedule'])->name('schedules.store');
    Route::get('/schedules/{id}/edit', [AdminController::class, 'editSchedule'])->name('schedules.edit');
    Route::post('/schedules/{id}/update', [AdminController::class, 'updateSchedule'])->name('schedules.update');
    Route::post('/schedules/{id}/delete', [AdminController::class, 'destroySchedule'])->name('schedules.destroy');
});