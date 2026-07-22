<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Steamify</title>
    <!-- Pemanggilan CSS yang BENAR -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md text-center border border-slate-100">
        <div class="w-40 h-40 mx-auto mb-4 flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Steamify" class="w-full h-full object-contain transform scale-125">
        </div>
        <h2 class="text-2xl font-bold text-slate-800 mb-8">Selamat Datang di Steamify</h2>
        
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-6 text-left">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="text-left">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-slate-600 mb-2">Email</label>
                <input type="email" name="email" placeholder="contoh@email.com" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
            </div>
            <div class="mb-2">
                <label class="block text-sm text-slate-600 mb-2">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-600 outline-none">
            </div>
            <div class="text-right mb-6">
                <a href="#" class="text-sm text-blue-600 font-medium">Lupa Password?</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Masuk</button>
        </form>
        
        <p class="mt-8 text-sm text-slate-600">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-semibold">Daftar di sini</a></p>
    </div>
</body>
</html>