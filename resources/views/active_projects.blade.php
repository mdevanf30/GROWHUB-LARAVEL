<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Proyek Aktif Anda</title>
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
                <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
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
                
                <a href="{{ route('dashboard_freelance') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0d47a1] hover:underline mb-6">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Proyek Aktif Anda</h1>
                    <p class="text-gray-500 text-sm mt-1">Daftar semua proyek aktif yang sedang Anda kerjakan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($active_projects as $proyek)
                        @php
                            $targetRoute = route('project.progress', $proyek->project_id);
                        @endphp
                        <a href="{{ $targetRoute }}" class="bg-white p-6 rounded-2xl border border-amber-200/60 hover:border-amber-400 shadow-sm hover:shadow-md transition-all duration-200 block">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900 leading-tight">{{ $proyek->project_title }}</h4>
                                    <p class="text-xs text-gray-400 mt-1">{{ $proyek->business_name }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-[9px] font-bold rounded uppercase tracking-wide">
                                        {{ $proyek->current_stage }}
                                    </span>
                                    <span id="countdown-{{ $proyek->project_id }}" class="px-2.5 py-1 bg-red-50 text-red-600 text-[9px] font-semibold rounded tracking-wide font-mono whitespace-nowrap" data-deadline="{{ $proyek->deadline }}">
                                        Loading...
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-50 text-xs">
                                <div>
                                    <p class="text-[10px] text-gray-400 leading-none">Anggaran</p>
                                    <p class="font-bold text-[#0b51b7] mt-1.5">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-blue-600 font-bold text-[11px] flex items-center gap-1">
                                    Buka Monitoring <i class="fa-solid fa-arrow-right"></i>
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
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Real-time Countdown Timer for Deadlines
            function updateCountdowns() {
                const countdownElements = document.querySelectorAll("[data-deadline]");
                countdownElements.forEach(function(el) {
                    const deadlineStr = el.getAttribute("data-deadline");
                    const targetDate = new Date(deadlineStr + "T23:59:59").getTime();
                    const now = new Date().getTime();
                    const difference = targetDate - now;

                    if (difference < 0) {
                        el.innerText = "Waktu Habis";
                        el.classList.remove("bg-red-50", "text-red-600");
                        el.classList.add("bg-gray-100", "text-gray-500");
                        return;
                    }

                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    el.innerText = `${days}h ${hours}j ${minutes}m ${seconds}s`;
                });
            }

            updateCountdowns();
            setInterval(updateCountdowns, 1000);
        });
    </script>
</body>
</html>
