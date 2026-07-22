<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steamify</title>
    <!-- Pemanggilan CSS yang sudah BENAR (tanpa kurung siku) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between">
        <div>
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">Steamify</h1>
                <p class="text-xs text-slate-500">Premium Wash Service</p>
            </div>
            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('customer.dashboard') ? 'bg-blue-600 text-white rounded-lg shadow-sm' : 'text-slate-600 hover:bg-slate-100 rounded-lg transition' }}">
                    <i class="fas fa-th-large mr-3"></i> Dashboard
                </a>
                <a href="{{ route('customer.booking') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('customer.booking') ? 'bg-blue-600 text-white rounded-lg shadow-sm' : 'text-slate-600 hover:bg-slate-100 rounded-lg transition' }}">
                    <i class="fas fa-tint mr-3"></i> Booking
                </a>
                <a href="{{ route('customer.vehicles') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('customer.vehicles') ? 'bg-blue-600 text-white rounded-lg shadow-sm' : 'text-slate-600 hover:bg-slate-100 rounded-lg transition' }}">
                    <i class="fas fa-motorcycle mr-3"></i> Vehicles
                </a>
                <a href="{{ route('customer.history') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('customer.history') ? 'bg-blue-600 text-white rounded-lg shadow-sm' : 'text-slate-600 hover:bg-slate-100 rounded-lg transition' }}">
                    <i class="fas fa-history mr-3"></i> History
                </a>
            </nav>
        </div>
        <div class="p-4">

            <div class="mt-4 text-sm text-slate-500 px-4 space-y-3 pb-4">
                <a href="{{ route('customer.help') }}" class="block {{ request()->routeIs('customer.help') ? 'text-blue-600 font-bold' : 'hover:text-slate-800' }}">
                    <i class="far fa-question-circle mr-2"></i> Bantuan
                </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-left text-red-500 hover:text-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </button>
            </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center">
            <div class="relative w-96">
                <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                <input type="text" placeholder="Search..." class="w-full bg-slate-100 rounded-full py-2 pl-10 pr-4 outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button onclick="toggleDropdown('customerNotifDropdown')" class="text-slate-500 hover:text-slate-800 relative focus:outline-none pt-1">
                        <i class="far fa-bell text-xl"></i>
                    </button>
                    <div id="customerNotifDropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-slate-100 z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-100 bg-slate-50 font-bold text-slate-700">Notifikasi</div>
                        <div class="p-6 text-center text-slate-400 text-sm">Belum ada notifikasi baru.</div>
                    </div>
                </div>

                <!-- Help -->
                <div class="relative">
                    <button onclick="toggleDropdown('customerHelpDropdown')" class="text-slate-500 hover:text-slate-800 focus:outline-none pt-1">
                        <i class="far fa-question-circle text-xl"></i>
                    </button>
                    <div id="customerHelpDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 overflow-hidden">
                        <a href="{{ route('customer.help') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-100"><i class="fas fa-book mr-2 text-slate-400"></i> Panduan Booking</a>
                        <a href="https://wa.me/6282120716470" target="_blank" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50"><i class="fas fa-headset mr-2 text-slate-400"></i> Hubungi CS</a>
                    </div>
                </div>

                <!-- Profile -->
                <div class="relative">
                    <button onclick="toggleDropdown('customerProfileDropdown')" class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center font-bold text-blue-700 overflow-hidden focus:outline-none ring-2 ring-transparent focus:ring-blue-500 transition">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'P', 0, 1)) }}
                    </button>
                    <div id="customerProfileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-100">
                            <p class="font-bold text-slate-800 truncate">{{ Auth::user()->nama ?? 'Pelanggan' }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'user@email.com' }}</p>
                        </div>
                        <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-100"><i class="fas fa-user-circle mr-2 text-slate-400"></i> Profil Saya</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Dropdown Toggle Script -->
            <script>
                function toggleDropdown(id) {
                    const dropdowns = ['customerNotifDropdown', 'customerHelpDropdown', 'customerProfileDropdown'];
                    dropdowns.forEach(dropdownId => {
                        if (dropdownId !== id) {
                            document.getElementById(dropdownId).classList.add('hidden');
                        }
                    });
                    document.getElementById(id).classList.toggle('hidden');
                }

                document.addEventListener('click', function(event) {
                    const dropdowns = ['customerNotifDropdown', 'customerHelpDropdown', 'customerProfileDropdown'];
                    dropdowns.forEach(id => {
                        const dropdown = document.getElementById(id);
                        if (dropdown) {
                            const btn = dropdown.previousElementSibling;
                            if (!dropdown.contains(event.target) && !btn.contains(event.target)) {
                                dropdown.classList.add('hidden');
                            }
                        }
                    });
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