<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Dashboard Freelancer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-[#0d47a1] text-white flex flex-col justify-between shrink-0">
        <div class="flex flex-col">
            <div class="h-20 flex items-center px-6 gap-3">
                <div class="bg-white p-1.5 rounded-lg flex items-center justify-center w-8 h-8">
                    <img src="{{ asset('IMAGES/LOGO_GROWHUB-removebg-preview.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-xl font-bold tracking-wide">GrowHub</span>
            </div>

            <div class="px-6 mb-6">
                <div class="bg-[#0d47a1] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-regular fa-user text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">Role</p>
                        <p class="font-semibold text-sm leading-none">Freelancer</p>
                    </div>
                </div>
            </div>

            <nav class="px-3 mt-4 space-y-1">
                <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-border-all w-5"></i> Dashboard
                </a>
                <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-user w-5"></i> Profil
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-blue-800/30">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-red-600 rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-end px-8 shrink-0">
            <div class="flex items-center gap-6">
                <div class="relative text-gray-400 cursor-pointer">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </div>
                <div class="flex items-center gap-3 pl-6 border-l border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($user->full_name, 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <div class="font-semibold text-gray-900">{{ $user->full_name }}</div>
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">Freelancer</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-6xl mx-auto">
                
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">Selamat datang kembali! Temukan proyek yang sesuai dengan keahlian Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-[#0d47a1] group-hover:bg-[#0d47a1] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Cari Proyek</p>
                            <p class="text-xs text-gray-500">Temukan proyek UMKM</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-[#0d47a1] group-hover:bg-[#0d47a1] group-hover:text-white transition-colors">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Portfolio</p>
                            <p class="text-xs text-gray-500">Kelola profil & keahlian</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Lamaran Terkirim</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_applied }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">Total lamaran Anda</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center"><i class="fa-solid fa-briefcase"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Proyek Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_active }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">Sedang dikerjakan</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center"><i class="fa-regular fa-clock"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Proyek Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_completed }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">Berhasil diselesaikan</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center"><i class="fa-regular fa-circle-check"></i></div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Rating</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($user->rating ?? 4.8, 1) }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">Berdasarkan ulasan</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center"><i class="fa-regular fa-star"></i></div>
                    </div>
                </div>

                <!-- Proyek Aktif Anda Section -->
                <div class="mb-10">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Proyek Aktif Anda</h3>
                        <p class="text-gray-500 text-xs mt-0.5">Kelola dan pantau progress pengerjaan proyek aktif Anda di sini.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($active_projects as $proyek)
                            @php
                                $targetRoute = $proyek->status === 'completed'
                                    ? route('project.payment', $proyek->project_id)
                                    : route('project.progress', $proyek->project_id);
                            @endphp
                            <a href="{{ $targetRoute }}" class="bg-white p-6 rounded-2xl border {{ $proyek->status === 'completed' ? 'border-green-200/60 hover:border-green-400' : 'border-amber-200/60 hover:border-amber-400' }} shadow-sm hover:shadow-md transition-all duration-200 block">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-900 leading-tight">{{ $proyek->project_title }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">{{ $proyek->business_name }}</p>
                                    </div>
                                    @if($proyek->status === 'completed')
                                        <span class="px-2.5 py-1 bg-green-50 text-green-600 text-[9px] font-bold rounded uppercase tracking-wide">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-[9px] font-bold rounded uppercase tracking-wide">
                                            {{ $proyek->current_stage }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-50 text-xs">
                                    <div>
                                        <p class="text-[10px] text-gray-400 leading-none">Anggaran</p>
                                        <p class="font-bold text-[#0b51b7] mt-1.5">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-blue-600 font-bold text-[11px] flex items-center gap-1">
                                        {{ $proyek->status === 'completed' ? 'Buka Pembayaran' : 'Buka Monitoring' }} <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full bg-white p-8 text-center text-gray-500 rounded-2xl border border-gray-100 shadow-sm">
                                <i class="fa-solid fa-clock-rotate-left text-3xl text-gray-300 mb-2 block"></i>
                                Anda belum memiliki proyek aktif yang sedang dikerjakan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Proyek Terbaru</h3>
                    <a href="#" class="text-sm font-semibold text-[#0b51b7] hover:underline">Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($projects as $proyek)
                    <a href="{{ route('project.show', $proyek->project_id) }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow block">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 leading-tight">{{ $proyek->project_title }}</h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $proyek->business_name }}</p>
                            </div>
                            <span class="px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-full uppercase">Terbuka</span>
                        </div>
                        <div class="flex justify-between items-center mt-6">
                            <p class="font-bold text-[#0b51b7]">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400">{{ date('d M Y', strtotime($proyek->deadline)) }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-2 bg-white p-8 text-center text-gray-500 rounded-2xl border border-gray-100 shadow-sm">
                        <i class="fa-solid fa-folder-open text-3xl text-gray-300 mb-2 block"></i>
                        Belum ada proyek terbaru yang tersedia saat ini, rek.
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>

</body>
</html>