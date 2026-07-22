<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Steamify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-blue-50/50 flex items-center justify-center h-screen p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl flex overflow-hidden border border-slate-100 min-h-[500px]">
        <!-- Kiri: Promosi -->
        <div class="w-1/2 bg-blue-50/30 p-10 flex flex-col justify-center items-center text-center hidden md:flex">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Motorcycle Care</h2>
            <p class="text-slate-600 text-sm mb-8 px-4">Bergabunglah dengan Steamify untuk pengalaman cuci motor yang cepat, bersih, dan terpercaya.</p>
            <div class="w-64 h-64 bg-white rounded-xl shadow-sm border border-blue-100 flex items-center justify-center text-blue-500 text-6xl">
                <i class="fas fa-motorcycle"></i>
            </div>
        </div>

        <!-- Kanan: Form Register -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <div class="w-20 h-20 mx-auto mb-2 flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Steamify" class="w-full h-full object-contain transform scale-125">
            </div>
            <h2 class="text-xl font-bold text-slate-800 text-center mb-2">Buat Akun Baru</h2>
            <p class="text-slate-500 text-sm text-center mb-6">Daftar untuk mulai memesan layanan.</p>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <i class="far fa-user absolute left-3 top-3.5 text-slate-400"></i>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap Anda" class="w-full pl-9 pr-4 py-2.5 rounded-lg border @error('nama') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                    </div>
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                    <div class="relative">
                        <i class="far fa-envelope absolute left-3 top-3.5 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="w-full pl-9 pr-4 py-2.5 rounded-lg border @error('email') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                    </div>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Telepon</label>
                    <div class="relative">
                        <i class="fas fa-phone-alt absolute left-3 top-3.5 text-slate-400"></i>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="081234567890" class="w-full pl-9 pr-4 py-2.5 rounded-lg border @error('no_hp') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                    </div>
                    @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3.5 text-slate-400"></i>
                        <input type="password" name="password" placeholder="••••••••" class="w-full pl-9 pr-4 py-2.5 rounded-lg border @error('password') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-600 outline-none text-sm">
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition mt-2">Daftar Sekarang</button>
            </form>

            <p class="mt-6 text-sm text-center text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold">Masuk di sini</a></p>
        </div>
    </div>
</body>

</html>