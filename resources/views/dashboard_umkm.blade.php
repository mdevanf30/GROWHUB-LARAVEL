<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Dashboard UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
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
                <div class="bg-[#0b51b7] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-solid fa-store text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">UMKM</p>
                        <p class="font-semibold text-sm leading-none">{{ $cek_umkm->business_name ?? 'Mitra UMKM' }}</p>
                    </div>
                </div>
            </div>

            <nav class="px-3 mt-4 space-y-1">
                <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white bg-[#1e60c0] rounded-md text-sm font-medium">
                    <i class="fa-solid fa-border-all w-5"></i> Dashboard
                </a>
                <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                     <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                </a>
                <a href="{{ route('project.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-circle-plus w-5"></i> Buat Proyek
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-user w-5"></i> Profil
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-blue-800/30">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-umkm').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form-umkm" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
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
                        {{ strtoupper(substr($nama_user, 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <div class="font-semibold text-gray-900">{{ $nama_user }}</div>
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">UMKM</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-7xl mx-auto space-y-6">
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard UMKM {{ $cek_umkm->business_name ?? 'Bisnis Anda' }}</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola proyek dan temukan freelancer terbaik untuk bisnis Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('project.create') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:border-blue-500/30 transition-all cursor-pointer">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-[#0d47a1]"><i class="fa-solid fa-plus text-sm"></i></div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-800">Buat Proyek</h3>
                            <p class="text-[10px] text-gray-400">Publikasikan kebutuhan baru</p>
                        </div>
                    </a>
                    <a href="{{ route('umkm.search-freelancer') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:border-blue-500/30 transition-all cursor-pointer">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-[#0d47a1]"><i class="fa-solid fa-user-gear text-sm"></i></div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-800">Cari Freelancer</h3>
                            <p class="text-[10px] text-gray-400">Temukan talenta terbaik untuk proyek Anda</p>
                        </div>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-medium text-gray-400">Total Proyek</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ count($proyek_umkm ?? []) }}</h2>
                            <p class="text-[10px] text-green-500 mt-0.5">+2 bulan ini</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50/60 rounded-xl flex items-center justify-center text-[#0d47a1] text-sm"><i class="fa-solid fa-briefcase"></i></div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-medium text-gray-400">Sedang Dikerjakan</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $proyek_umkm instanceof \Illuminate\Support\Collection ? $proyek_umkm->where('status', 'in_progress')->count() : 0 }}
                            </h2>
                            <p class="text-[10px] text-amber-500 mt-0.5">1 mendekati deadline</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50/60 rounded-xl flex items-center justify-center text-[#0d47a1] text-sm"><i class="fa-regular fa-clock"></i></div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-medium text-gray-400">Selesai</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $proyek_umkm instanceof \Illuminate\Support\Collection ? $proyek_umkm->where('status', 'completed')->count() : 0 }}
                            </h2>
                            <p class="text-[10px] text-green-500 mt-0.5">+1 bulan ini</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50/60 rounded-xl flex items-center justify-center text-[#0d47a1] text-sm"><i class="fa-regular fa-circle-check"></i></div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-medium text-gray-400">Pelamar Masuk</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">0</h2>
                            <p class="text-[10px] text-blue-500 mt-0.5">0 minggu ini</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50/60 rounded-xl flex items-center justify-center text-[#0d47a1] text-sm"><i class="fa-solid fa-users"></i></div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-gray-900">Proyek Anda</h2>
                        <a href="#" class="text-xs font-bold text-[#0d47a1] flex items-center gap-1 hover:underline">Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-folder-open text-[#0b51b7]"></i> Proyek yang Anda Buka
                        </h3>
                        
                        <div class="space-y-3">
                            @forelse($proyek_umkm as $proyek)
                                @php
                                    $targetRoute = $proyek->status === 'completed' 
                                        ? route('project.payment', $proyek->project_id) 
                                        : ($proyek->status === 'in_progress' ? route('project.progress', $proyek->project_id) : route('project.show', $proyek->project_id));
                                @endphp
                                <a href="{{ $targetRoute }}" class="flex items-center justify-between p-3.5 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-blue-300 transition-all block">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800">{{ $proyek->project_title }}</h4>
                                        <div class="flex items-center gap-3 text-[10px] text-gray-400 mt-1">
                                            <span><i class="fa-solid fa-calendar mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($proyek->deadline)->format('d/m/y') }}</span>
                                            
                                            @if($proyek->status === 'open')
                                                <span class="px-2 py-0.5 bg-blue-50 text-[#0d47a1] rounded font-semibold text-[9px]">Terbuka</span>
                                            @elseif($proyek->status === 'in_progress')
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded font-semibold text-[9px]">Dikerjakan</span>
                                            @elseif($proyek->status === 'completed')
                                                <span class="px-2 py-0.5 bg-green-50 text-green-600 rounded font-semibold text-[9px]">Selesai</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-gray-50 text-gray-500 rounded font-semibold text-[9px]">Dibatalkan</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-bold text-[#0b51b7]">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-6 text-gray-400 text-xs">
                                    <p>Belum ada proyek yang dibuka. Yuk, buat proyek pertama Anda!</p>
                                    <a href="{{ route('project.create') }}" class="text-[#0b51b7] font-semibold hover:underline mt-1 inline-block">Buat Proyek Sekarang →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        @if(session('success'))
        <div class="absolute bottom-6 right-6 bg-white p-4 rounded-xl border border-gray-100 shadow-lg flex items-start gap-3 max-w-sm border-l-4 border-l-green-500 animate-bounce">
            <div class="text-xl">🎉</div>
            <div>
                <h4 class="text-xs font-bold text-gray-800">Berhasil!</h4>
                <p class="text-[10px] text-gray-400 mt-0.5">{{ session('success') }}</p>
            </div>
            <button class="text-gray-300 hover:text-gray-500 ml-2" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark text-xs"></i></button>
        </div>
        @endif

    </main>

</body>
</html>