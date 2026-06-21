<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Jelajahi Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <div class="bg-[#0b51b7] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200">
                        @if($activeRole === 'UMKM')
                            <i class="fa-solid fa-store text-lg"></i>
                        @else
                            <i class="fa-regular fa-user text-lg"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">ROLE</p>
                        <p class="font-semibold text-sm leading-none">
                            @if($activeRole === 'UMKM' && $cek_umkm)
                                {{ $cek_umkm->business_name }}
                            @else
                                Freelancer
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <nav class="px-3 space-y-1">
                @if($activeRole === 'UMKM')
                    <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 bg-[#1e60c0] text-white rounded-lg text-sm font-medium shadow-sm">
                        <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                    </a>
                    <a href="{{ route('project.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-circle-plus w-5"></i> Buat Proyek
                    </a>
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-regular fa-user w-5"></i> Profil
                    </a>
                @else
                    <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 bg-[#1e60c0] text-white rounded-lg text-sm font-medium shadow-sm">
                        <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                    </a>
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-regular fa-user w-5"></i> Profil
                    </a>
                @endif
            </nav>
        </div>

        <div class="p-4 border-t border-blue-800/30">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-jelajahi').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form-jelajahi" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-end px-8 shrink-0">
            <div class="flex items-center gap-6">
                <div class="relative text-gray-400 cursor-pointer">
                    <i class="fa-regular fa-bell text-xl"></i>
                </div>
                <div class="flex items-center gap-3 pl-6 border-l border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($nama_user, 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <div class="font-semibold text-gray-900">{{ $nama_user }}</div>
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">
                            @if($activeRole === 'UMKM')
                                UMKM
                            @else
                                Freelancer
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Jelajahi Proyek</h1>
                    <p class="text-gray-500 text-sm mt-1">Temukan proyek yang sesuai dengan keahlian Anda.</p>
                </div>

                <form method="GET" action="{{ route('jelajahi_proyek') }}" class="flex gap-4 mb-6">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul proyek, deskripsi, atau nama UMKM..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-1 focus:ring-[#0b51b7] focus:border-[#0b51b7] outline-none shadow-sm transition">
                        
                        @if(!empty($kategori))
                            <input type="hidden" name="kategori" value="{{ $kategori }}">
                        @endif
                    </div>
                    <button type="submit" class="px-6 py-3 bg-[#0b51b7] text-white rounded-xl font-medium hover:bg-blue-800 transition shadow-sm flex items-center gap-2">
                        Cari
                    </button>
                    @if(!empty($search) || !empty($kategori))
                    <a href="{{ route('jelajahi_proyek') }}" class="px-6 py-3 bg-white border border-gray-200 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl font-medium transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-xmark"></i> Reset
                    </a>
                    @endif
                </form>

                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($list_kategori as $cat)
                        @php
                            $isActive = ($kategori == $cat) || (empty($kategori) && $cat == 'Semua');
                            
                            $btnClass = $isActive 
                                ? "px-5 py-2 bg-[#0b51b7] text-white rounded-full text-sm font-medium shadow-sm"
                                : "px-5 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-medium hover:bg-blue-100 transition";
                            
                            // Build URL dengan query helper Laravel
                            $urlParams = [];
                            if ($cat !== 'Semua') $urlParams['kategori'] = $cat;
                            if (!empty($search)) $urlParams['search'] = $search;
                            
                            $targetUrl = route('jelajahi_proyek') . ($urlParams ? '?' . http_build_query($urlParams) : '');
                        @endphp
                        <a href="{{ $targetUrl }}" class="{{ $btnClass }}">{{ $cat }}</a>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @forelse($projects as $proyek)
                        @php
                            // Logika Status Badge
                            if ($proyek->status == 'in_progress') {
                                $status_label = "Dikerjakan";
                                $status_bg = "bg-amber-50 text-amber-600";
                            } elseif ($proyek->status == 'completed') {
                                $status_label = "Selesai";
                                $status_bg = "bg-green-50 text-green-600";
                            } else {
                                $status_label = "Terbuka";
                                $status_bg = "bg-blue-50 text-[#0b51b7]";
                            }

                            $lokasi = $proyek->project_address ?? 'Remote / Online';
                            
                            // Format Tanggal dengan Carbon bawaan Laravel
                            $deadline = \Carbon\Carbon::parse($proyek->deadline)->translatedFormat('d M Y');
                        @endphp
                        
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full">
                                        {{ $proyek->category }}
                                    </span>
                                    <span class="px-2.5 py-0.5 {{ $status_bg }} text-[10px] font-bold rounded uppercase tracking-wide">
                                        {{ $status_label }}
                                    </span>
                                </div>
                                
                                <h4 class="font-bold text-gray-900 leading-tight mb-2 text-lg line-clamp-1">
                                    {{ $proyek->project_title }}
                                </h4>
                                <p class="text-sm text-gray-500 mb-3 line-clamp-2">
                                    {{ $proyek->description }}
                                </p>
                                <p class="text-xs text-gray-400 font-medium mb-4 flex items-center gap-1.5">
                                    <i class="fa-solid fa-store text-gray-400"></i> {{ $proyek->business_name ?? 'Mitra UMKM' }}
                                </p>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="flex justify-between items-end mb-4 pt-2">
                                    <div>
                                        <p class="text-[11px] text-gray-400 font-medium leading-none">Anggaran Proyek</p>
                                        <p class="font-bold text-[#0b51b7] text-lg mt-1">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center py-3.5 border-t border-b border-gray-50 mb-4 text-xs text-gray-500">
                                    <div class="flex items-center gap-1.5 max-w-[50%] truncate">
                                        <i class="fa-solid fa-location-dot shrink-0 text-gray-400"></i>
                                        <span class="truncate">{{ $lokasi }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-clock text-gray-400"></i>
                                        <span>{{ $deadline }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('project.show', $proyek->project_id) }}" class="w-full py-2.5 bg-[#0b51b7] text-white text-xs font-semibold rounded-xl text-center block hover:bg-blue-800 transition shadow-sm">
                                    Lihat Detail Proyek
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center p-16 bg-white rounded-2xl border border-gray-100 text-center">
                            <div class="text-gray-300 mb-4"><i class="fa-regular fa-folder-open text-6xl"></i></div>
                            <h3 class="text-lg font-bold text-gray-700">Proyek Tidak Ditemukan</h3>
                            <p class="text-gray-400 text-xs mt-1 max-w-sm">Maaf, kata kunci atau filter kategori yang Anda pilih saat ini tidak memiliki proyek aktif.</p>
                            <a href="{{ route('jelajahi_proyek') }}" class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-100 transition">Lihat Semua Proyek</a>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>

</body>
</html>