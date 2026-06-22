<!DOCTYPE html>
<html class="h-full">
<head>
    <title>Admin Panel - Data Grafik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .bg-primary { background-color: #0d47a1; }
        .text-primary { color: #0d47a1; }
        .border-primary { border-color: #0d47a1; }
        .hover-bg-primary:hover { background-color: #0a3981; }
        .chart-container {
            position: relative;
            height: 155px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 h-full flex flex-col overflow-hidden">

    <!-- Navbar (Fixed height: h-14) -->
    <nav class="bg-white border-b border-gray-200 shadow-sm h-14 flex items-center shrink-0">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-xl font-black tracking-wider text-primary">GROWHUB</span>
                    <span class="text-[10px] uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded text-primary border border-blue-200 font-bold">Reporting</span>
                </div>
                <div class="flex space-x-2 text-xs font-semibold">
                    <a href="{{ route('admin.index') }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu User</a>
                    <a href="{{ route('admin.umkm.index') }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu UMKM</a>
                    <a href="{{ route('admin.project.index') }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu Project</a>
                    <a href="{{ route('admin.reports.list') }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu Laporan</a>
                    <a href="{{ route('admin.cancellations.list') }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu Pembatalan</a>
                    <span class="px-3 py-1.5 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Data Grafik</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition">Keluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area (Flexible, no overflow) -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col justify-between overflow-hidden">
        
        <!-- Header (Compact shrink-0) -->
        <div class="flex items-center justify-between shrink-0 mb-3">
            <div>
                <h1 class="text-xl font-bold tracking-tight text-gray-900">Dashboard Grafik Ringkas</h1>
                <p class="text-gray-400 text-xs mt-0.5">Visualisasi data keaktifan pengguna, kemitraan, dan progres penyelesaian proyek.</p>
            </div>
            <button onclick="window.print()" class="px-3 py-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg shadow-sm transition flex items-center space-x-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak</span>
            </button>
        </div>

        <!-- 1. Stat Cards (Compact shrink-0, low padding) -->
        <div class="grid grid-cols-4 gap-4 shrink-0 mb-4">
            
            <!-- Card 1: Total Pengguna -->
            <div class="bg-white border border-gray-150 rounded-xl px-4 py-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Pengguna</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-0.5">{{ $totalUsers }}</h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <!-- Card 2: Pengguna Aktif -->
            <div class="bg-white border border-gray-150 rounded-xl px-4 py-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pengguna Aktif</span>
                    <h3 class="text-xl font-extrabold text-emerald-600 mt-0.5">{{ $activeUsers }}</h3>
                </div>
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <span class="absolute flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>

            <!-- Card 3: Proyek Selesai -->
            <div class="bg-white border border-gray-150 rounded-xl px-4 py-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Proyek Selesai</span>
                    <h3 class="text-xl font-extrabold text-indigo-600 mt-0.5">{{ $completedProjects }}</h3>
                </div>
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>

            <!-- Card 4: Total Proyek -->
            <div class="bg-white border border-gray-150 rounded-xl px-4 py-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Proyek</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-0.5">{{ $totalProjects }}</h3>
                </div>
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>

        </div>

        <!-- 2. Charts 2x2 Grid (Fills remaining height, no scroll) -->
        <div class="grid grid-cols-2 gap-4 flex-1 min-h-0 overflow-hidden">
            
            <!-- Chart 1: Status Pengguna -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-between min-h-0">
                <div class="shrink-0 mb-2">
                    <h2 class="font-bold text-gray-800 text-sm">Status Keaktifan Pengguna</h2>
                    <p class="text-[10px] text-gray-400">Status akun user aktif vs diblokir/nonaktif.</p>
                </div>
                <div class="chart-container flex-1">
                    <canvas id="chartUserStatus"></canvas>
                </div>
            </div>

            <!-- Chart 2: Peran Pengguna -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-between min-h-0">
                <div class="shrink-0 mb-2">
                    <h2 class="font-bold text-gray-800 text-sm">Perbandingan Peran Pengguna</h2>
                    <p class="text-[10px] text-gray-400">Rasio penawaran (Freelancer) vs permintaan (Mitra UMKM).</p>
                </div>
                <div class="chart-container flex-1">
                    <canvas id="chartUserRoles"></canvas>
                </div>
            </div>

            <!-- Chart 3: Progres Status Project -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-between min-h-0">
                <div class="shrink-0 mb-2">
                    <h2 class="font-bold text-gray-800 text-sm">Status Progres Proyek</h2>
                    <p class="text-[10px] text-gray-400">Distribusi tahap pengerjaan proyek dari UMKM.</p>
                </div>
                <div class="chart-container flex-1">
                    <canvas id="chartProjectStatus"></canvas>
                </div>
            </div>

            <!-- Chart 4: Kategori Pekerjaan Project -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-between min-h-0">
                <div class="shrink-0 mb-2">
                    <h2 class="font-bold text-gray-800 text-sm">Kategori Pekerjaan Proyek</h2>
                    <p class="text-[10px] text-gray-400">Bidang keahlian proyek yang paling dicari.</p>
                </div>
                <div class="chart-container flex-1">
                    <canvas id="chartProjectCategories"></canvas>
                </div>
            </div>

        </div>

    </main>

    <!-- Chart Scripts -->
    <script>
        // Data dari Laravel
        const rawStatus = @json($userStatus);
        const rawRoles = @json($userRoles);
        const rawProjectStatus = @json($projectStatus);
        const rawProjectCat = @json($projectCategories);

        const capitalize = (s) => s ? s.charAt(0).toUpperCase() + s.slice(1) : '';

        // Global Chart Defaults for Clean Premium Look
        Chart.defaults.font.family = 'Outfit';
        Chart.defaults.font.size = 11;
        Chart.defaults.color = '#6b7280';

        // 1. Chart Status Pengguna (Doughnut)
        new Chart(document.getElementById('chartUserStatus').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: rawStatus.map(item => capitalize(item.status)),
                datasets: [{
                    data: rawStatus.map(item => item.total),
                    backgroundColor: rawStatus.map(item => {
                        if (item.status === 'active') return '#10b981'; // Emerald
                        if (item.status === 'inactive') return '#9ca3af'; // Gray
                        return '#ef4444'; // Rose
                    }),
                    borderWidth: 2,
                    hoverOffset: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 10,
                            padding: 10,
                            font: { family: 'Outfit', size: 11 }
                        }
                    }
                }
            }
        });

        // 2. Chart Peran Pengguna (Bar Chart)
        new Chart(document.getElementById('chartUserRoles').getContext('2d'), {
            type: 'bar',
            data: {
                labels: rawRoles.map(item => item.role),
                datasets: [{
                    data: rawRoles.map(item => item.total),
                    backgroundColor: ['#3b82f6', '#6366f1'], // Blue, Indigo
                    borderRadius: 6,
                    maxBarThickness: 35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: '#f3f4f6' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 3. Chart Status Project (Pie / Doughnut)
        new Chart(document.getElementById('chartProjectStatus').getContext('2d'), {
            type: 'pie',
            data: {
                labels: rawProjectStatus.map(item => item.status.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: rawProjectStatus.map(item => item.total),
                    backgroundColor: rawProjectStatus.map(item => {
                        if (item.status === 'open') return '#3b82f6'; // Blue
                        if (item.status === 'in_progress') return '#f59e0b'; // Amber
                        if (item.status === 'completed') return '#10b981'; // Emerald
                        return '#ef4444'; // Rose
                    }),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 10,
                            padding: 8,
                            font: { family: 'Outfit', size: 10 }
                        }
                    }
                }
            }
        });

        // 4. Chart Kategori Project (Horizontal Bar Chart)
        new Chart(document.getElementById('chartProjectCategories').getContext('2d'), {
            type: 'bar',
            data: {
                labels: rawProjectCat.map(item => item.category),
                datasets: [{
                    data: rawProjectCat.map(item => item.total),
                    backgroundColor: '#8b5cf6', // Purple
                    borderRadius: 6,
                    maxBarThickness: 20
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: '#f3f4f6' }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>