<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steamify Admin</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between">
        <div>
            <div class="p-6 border-b border-slate-800">
                <h1 class="text-2xl font-bold text-blue-400">Steamify</h1>
                <p class="text-xs text-slate-400 mt-1">Management Portal</p>
            </div>
            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-chart-line w-6"></i> Dashboard
                </a>
                <a href="{{ route('admin.queue') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.queue') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-tasks w-6"></i> Queue
                </a>
                <a href="{{ route('admin.transactions') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.transactions') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-wallet w-6"></i> Transactions
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.reports') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-chart-bar w-6"></i> Laporan
                </a>
                <a href="{{ route('admin.packages') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.packages*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-box w-6"></i> Kelola Paket
                </a>
                <a href="{{ route('admin.schedules') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.schedules*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-calendar-alt w-6"></i> Kelola Jadwal
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-users w-6"></i> Kelola User
                </a>
                <a href="{{ route('admin.bookings') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.bookings*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800' }} rounded-lg transition">
                    <i class="fas fa-calendar-check w-6"></i> Kelola Booking
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-red-400 hover:bg-slate-800 rounded-lg transition">
                    <i class="fas fa-sign-out-alt w-6"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center shadow-sm">
            <form action="{{ route('admin.transactions') }}" method="GET" class="relative w-96">
                <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari struk, ID pesanan, nama/hp pelanggan..." class="w-full bg-slate-100 rounded-full py-2 pl-10 pr-4 outline-none focus:ring-2 focus:ring-blue-500 transition">
            </form>
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                @php
                    $pendingNotifications = \App\Models\Booking::where('status_booking', 'Pending')->latest()->take(5)->get();
                    $notifCount = \App\Models\Booking::where('status_booking', 'Pending')->count();
                @endphp
                <div class="relative">
                    <button onclick="document.getElementById('notifDropdown').classList.toggle('hidden'); document.getElementById('profileDropdown').classList.add('hidden');" class="text-slate-500 hover:text-slate-800 relative focus:outline-none">
                        <i class="far fa-bell text-xl"></i>
                        @if($notifCount > 0)
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white w-4 h-4 rounded-full text-[10px] flex items-center justify-center font-bold">{{ $notifCount }}</span>
                        @endif
                    </button>
                    <!-- Dropdown Notif -->
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-100 z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-100 bg-slate-50 font-bold text-slate-700 flex justify-between items-center">
                            <span>Notifikasi</span>
                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">{{ $notifCount }} Baru</span>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse($pendingNotifications as $notif)
                            <a href="{{ route('admin.queue') }}" class="block p-4 border-b border-slate-50 hover:bg-slate-50 transition">
                                <p class="text-sm font-semibold text-slate-800">Pesanan Baru: #BK-{{ str_pad($notif->id_booking, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-xs text-slate-500 mt-1">Pelanggan telah melakukan pemesanan, menunggu pembayaran.</p>
                                <p class="text-[10px] text-slate-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                            </a>
                            @empty
                            <div class="p-6 text-center text-slate-400 text-sm">
                                Belum ada notifikasi baru.
                            </div>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.queue') }}" class="block text-center p-3 text-sm text-blue-600 font-semibold hover:bg-slate-50 border-t border-slate-100">
                            Lihat Antrian
                        </a>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="relative">
                    <button onclick="document.getElementById('profileDropdown').classList.toggle('hidden'); document.getElementById('notifDropdown').classList.add('hidden');" class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center font-bold text-blue-700 overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{ substr(session('admin_name', 'A'), 0, 1) }}
                    </button>
                    <!-- Dropdown Profile -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-100">
                            <p class="font-bold text-slate-800 truncate">{{ session('admin_name', 'Administrator') }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ session('admin_email', 'admin@steamify.com') }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block p-3 text-sm text-red-500 hover:bg-red-50 transition font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Script to close dropdowns when clicking outside -->
            <script>
                document.addEventListener('click', function(event) {
                    const notifDropdown = document.getElementById('notifDropdown');
                    const profileDropdown = document.getElementById('profileDropdown');
                    const notifBtn = notifDropdown.previousElementSibling;
                    const profileBtn = profileDropdown.previousElementSibling;
                    
                    if (!notifDropdown.contains(event.target) && !notifBtn.contains(event.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                    if (!profileDropdown.contains(event.target) && !profileBtn.contains(event.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            </script>
        </header>

        <!-- Dynamic Page Content -->
        <div class="p-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
