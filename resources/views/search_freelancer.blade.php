<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Cari Freelancer</title>
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
                <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
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
            <div class="max-w-5xl mx-auto space-y-6">
                
                <a href="{{ route('umkm.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0d47a1] hover:underline mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Cari Freelancer</h1>
                        <p class="text-xs text-gray-400 mt-0.5">Temukan talenta terbaik untuk menunjang proyek UMKM Anda.</p>
                    </div>

                    <!-- Search Input Form -->
                    <form action="{{ route('umkm.search-freelancer') }}" method="GET" class="flex items-center gap-2 w-full md:w-80">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau keahlian..." 
                                   class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-gray-200 rounded-xl focus:border-blue-500 outline-none shadow-sm transition">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-[#0d47a1] hover:bg-[#0a3981] text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Cari
                        </button>
                    </form>
                </div>

                @if(!empty($search))
                    <p class="text-xs text-gray-500">Hasil pencarian untuk: <span class="font-bold text-[#0d47a1]">"{{ $search }}"</span></p>
                @endif

                <!-- Freelancers Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($freelancers as $f)
                        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm flex items-start gap-4 hover:shadow-md transition">
                            <!-- Avatar -->
                            <a href="{{ route('profil', $f->user_id) }}" class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0 hover:bg-blue-700 transition cursor-pointer">
                                {{ strtoupper(substr($f->full_name, 0, 1)) }}
                            </a>

                            <!-- Details -->
                            <div class="flex-1 space-y-2">
                                <div>
                                    <a href="{{ route('profil', $f->user_id) }}" class="hover:underline hover:text-blue-600 transition">
                                        <h3 class="font-bold text-gray-900 leading-snug">{{ $f->full_name }}</h3>
                                    </a>
                                    <div class="flex items-center gap-1.5 text-xs text-yellow-500 font-semibold mt-1">
                                        <i class="fa-solid fa-star"></i>
                                        <span>{{ number_format($f->rating ?? 0.0, 1) }} / 5.0</span>
                                    </div>
                                </div>

                                <div class="text-[11px] text-gray-500 space-y-1">
                                    <p><i class="fa-solid fa-envelope mr-1.5 text-gray-400"></i>{{ $f->email_address }}</p>
                                    @if($f->phone_number)
                                        <p><i class="fa-solid fa-phone mr-1.5 text-gray-400"></i>{{ $f->phone_number }}</p>
                                    @endif
                                    @if($f->home_address)
                                        <p><i class="fa-solid fa-location-dot mr-2 text-gray-400"></i>{{ $f->home_address }}</p>
                                    @endif
                                </div>

                                <div class="pt-2">
                                    <a href="{{ route('profil', $f->user_id) }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 hover:text-blue-800 transition">
                                        Lihat Profil Lengkap <i class="fa-solid fa-arrow-right text-[8px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-12 text-center text-gray-500 rounded-2xl border border-gray-150 shadow-sm">
                            <i class="fa-solid fa-users-slash text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-sm font-semibold">Freelancer tidak ditemukan</p>
                            <p class="text-xs text-gray-400 mt-1">Coba gunakan kata kunci pencarian yang lain, rek.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>

</body>
</html>
