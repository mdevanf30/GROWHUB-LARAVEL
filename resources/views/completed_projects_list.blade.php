<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Riwayat Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet">
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
                    <div class="text-blue-200">
                        @if(session('active_role') === 'UMKM')
                            <i class="fa-solid fa-store text-lg"></i>
                        @else
                            <i class="fa-regular fa-user text-lg"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">
                            {{ session('active_role') === 'UMKM' ? 'UMKM' : 'ROLE' }}
                        </p>
                        <p class="font-semibold text-sm leading-none font-sans">
                            {{ session('active_role') === 'UMKM' ? ($login_umkm->business_name ?? 'Mitra UMKM') : 'Freelancer' }}
                        </p>
                    </div>
                </div>
            </div>

            <nav class="px-3 mt-4 space-y-1">
                @if(session('active_role') === 'UMKM')
                    <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                @endif

                <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                     <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                </a>
                
                @if(session('active_role') === 'UMKM')
                    <a href="{{ route('project.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-circle-plus w-5"></i> Buat Proyek
                    </a>
                @endif

                <a href="{{ route('freelancer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-white bg-[#1e60c0] rounded-md text-sm font-medium">
                    <i class="fa-solid fa-user w-5"></i> Profil
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-blue-800/30">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
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
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">{{ session('active_role') ?? 'Freelancer' }}</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('freelancer.profile') }}" class="w-8 h-8 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-colors shadow-sm">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Proyek Lengkap</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    @forelse($completedProjects as $cp)
                        <a href="{{ route('project.results', $cp->project_id) }}" class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $cp->project_title }}</h4>
                                <p class="text-[11px] text-gray-400 mt-1">
                                    Selesai pada {{ $cp->completed_at ? \Carbon\Carbon::parse($cp->completed_at)->translatedFormat('d F Y') : 'Baru saja selesai' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-sm text-amber-400 flex items-center gap-0.5">
                                    @if($cp->rating)
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $cp->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                    @else
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Belum Dinilai</span>
                                    @endif
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-sm">
                            <i class="fa-regular fa-folder-open text-3xl mb-3 block text-gray-300"></i>
                            <p>Belum ada proyek yang selesai.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</body>
</html>
