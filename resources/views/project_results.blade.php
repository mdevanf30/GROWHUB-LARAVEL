<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Proyek - GrowHub</title>
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
                    <div class="text-blue-200">
                        @if($activeRole === 'UMKM')
                            <i class="fa-solid fa-store text-lg"></i>
                        @else
                            <i class="fa-regular fa-user text-lg"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">
                            {{ $activeRole === 'UMKM' ? 'UMKM' : 'ROLE' }}
                        </p>
                        <p class="font-semibold text-sm leading-none font-semibold">
                            {{ $activeRole === 'UMKM' ? ($proyek->business_name ?? 'Mitra UMKM') : 'Freelancer' }}
                        </p>
                    </div>
                </div>
            </div>

            <nav class="px-3 mt-4 space-y-1">
                @if($activeRole === 'UMKM')
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
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">{{ $activeRole }}</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-3xl mx-auto space-y-6">
                
                <button onclick="history.back()" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-xs font-semibold transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </button>

                <!-- Project Detail Card -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                    <div class="border-b border-gray-100 pb-3 flex justify-between items-start">
                        <div>
                            <span class="px-2.5 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-md uppercase tracking-wider">{{ $proyek->category }}</span>
                            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $proyek->project_title }}</h3>
                        </div>
                        <span class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Selesai</span>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi Proyek</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">{{ $proyek->description }}</p>
                    </div>

                    <!-- Details grid -->
                    <div class="grid grid-cols-2 gap-4 border-t border-gray-50 pt-4">
                        <div>
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Budget Proyek</h4>
                            <p class="text-sm font-bold text-blue-600 mt-0.5">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pemilik Proyek</h4>
                            <p class="text-xs font-semibold text-gray-800 mt-0.5">{{ $proyek->business_name ?? 'Mitra UMKM' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Deliverables (Hasil Pekerjaan) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-box-open text-blue-600"></i> Hasil Pekerjaan yang Diserahkan
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Link Submission -->
                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-2">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-link text-gray-400"></i> Link Hasil Pekerjaan
                            </h4>
                            @if($progress->project_link)
                                <a href="{{ $progress->project_link }}" target="_blank" class="text-xs text-blue-600 font-medium hover:underline break-all block">
                                    {{ $progress->project_link }}
                                </a>
                            @else
                                <p class="text-xs text-gray-400 italic">Tidak ada link yang diserahkan.</p>
                            @endif
                        </div>

                        <!-- File Submission -->
                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-2">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-file-arrow-down text-gray-400"></i> File Hasil Pekerjaan
                            </h4>
                            @if($progress->project_file)
                                <a href="{{ asset('storage/' . $progress->project_file) }}" download class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-lg transition">
                                    <i class="fa-solid fa-download"></i> Download File Proyek
                                </a>
                            @else
                                <p class="text-xs text-gray-400 italic">Tidak ada file yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Rating & Feedback Section -->
                @if($progress->rating_for_freelancer)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Penilaian & Ulasan Mitra UMKM</h4>
                    <div class="flex items-center gap-1 text-amber-400 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= $progress->rating_for_freelancer ? 'text-amber-400' : 'text-gray-200' }}"></i>
                        @endfor
                        <span class="text-gray-800 font-bold ml-1.5 text-xs">{{ number_format($progress->rating_for_freelancer, 1) }} / 5.0</span>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </main>
</body>
</html>