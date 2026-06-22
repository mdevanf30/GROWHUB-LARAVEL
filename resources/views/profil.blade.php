<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Profil {{ session('active_role') ?? 'Freelancer' }}</title>
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
                        <p class="font-semibold text-sm leading-none">
                            {{ session('active_role') === 'UMKM' ? ($cek_umkm->business_name ?? 'Mitra UMKM') : 'Freelancer' }}
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
                
                @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif
                
                <div class="bg-[#0b51b7] text-white p-6 rounded-2xl flex items-center justify-between relative shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-white text-[#0b51b7] flex items-center justify-center text-2xl font-bold">
                            {{ strtoupper(substr($nama_user, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ $nama_user }}</h2>
                            
                            @if(session('active_role') === 'UMKM' && isset($cek_umkm))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-white/20 text-xs font-medium mt-1">
                                    <i class="fa-solid fa-store text-[10px]"></i> {{ $cek_umkm->business_name }}
                                </span>
                            @endif

                            <div class="flex items-center gap-4 text-xs text-blue-200 mt-2">
                                <span><i class="fa-solid fa-location-dot mr-1"></i> {{ $freelancer->home_address ?? 'Surabaya' }}</span>
                                <span><i class="fa-solid fa-envelope mr-1"></i> {{ $freelancer->email_address ?? 'student@email.com' }}</span>
                                <span class="text-yellow-300"><i class="fa-solid fa-star mr-1"></i> 
                                    {{ session('active_role') === 'UMKM' ? (number_format($cek_umkm->rating ?? 0.0, 1)) : (number_format($freelancer->rating ?? 0.0, 1)) }}/5.0
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('freelancer.edit') }}" class="absolute top-6 right-6 px-4 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold rounded-lg border border-white/30 flex items-center gap-1.5 transition-colors">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </a>
                </div>

                @if(isset($cek_umkm) && $cek_umkm)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Mode Profil</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Anda sedang melihat sebagai <span class="font-bold text-[#0d47a1]">{{ session('active_role') }}</span></p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-medium {{ session('active_role') === 'Freelancer' ? 'text-gray-900 font-bold' : 'text-gray-400' }}">Freelancer</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                               {{ session('active_role') === 'UMKM' ? 'checked' : '' }}
                               onchange="window.location.href=this.checked ? '{{ route('switch.role', 'UMKM') }}' : '{{ route('switch.role', 'Freelancer') }}'">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0d47a1]"></div>
                        </label>
                        <span class="text-xs font-medium {{ session('active_role') === 'UMKM' ? 'text-gray-900 font-bold' : 'text-gray-400' }}">UMKM</span>
                    </div>
                </div>
                @endif

                @if(session('active_role') === 'UMKM' && isset($cek_umkm))
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-store text-[#0b51b7]"></i> Info UMKM
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-briefcase"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Nama Bisnis</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $cek_umkm->business_name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-tags"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Kategori</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $cek_umkm->category ?? 'Fashion' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Nomor Telepon</p>
                                    <p class="text-xs font-semibold text-gray-700">{{ $cek_umkm->phone_number }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 md:col-span-2">
                                <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Alamat UMKM</p>
                                    <p class="text-xs font-semibold text-gray-700">{{ $cek_umkm->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('project.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b51b7] text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                                Buat Proyek Baru <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endif

                @if(!isset($cek_umkm) || !$cek_umkm)
                    <div class="bg-gradient-to-r from-[#1e40af] to-[#0b51b7] text-white p-6 rounded-2xl shadow-sm border border-blue-700">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-store"></i></div>
                            <div class="flex-1">
                                <span class="px-2 py-0.5 bg-white/20 text-[10px] font-bold rounded-md uppercase tracking-wider">Untuk Pemilik Bisnis</span>
                                <h3 class="text-lg font-bold mt-1.5">Kembangkan Bisnis Anda di GrowHub</h3>
                                <p class="text-xs text-blue-100 mt-1 leading-relaxed">Daftarkan UMKM Anda & temukan freelancer mahasiswa berbakat untuk setiap kebutuhan digital.</p>
                                <div class="flex items-center justify-between pt-4 border-t border-white/10 mt-5">
                                    <div class="flex items-center gap-4 text-[11px] text-blue-200">
                                        <span><b class="text-white">1</b> Daftar UMKM</span>
                                        <span><i class="fa-solid fa-arrow-right text-[9px]"></i></span>
                                        <span><b class="text-white">2</b> Verifikasi</span>
                                    </div>
                                    <a href="{{ route('umkm.register') }}" class="px-4 py-2 bg-white text-[#0b51b7] text-xs font-bold rounded-xl flex items-center gap-1 hover:bg-blue-50 transition-colors shadow-sm">
                                        Daftarkan UMKM Sekarang <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Nomor Telepon</p>
                                <p class="text-xs font-semibold text-gray-700">
                                    {{ $freelancer->phone_number ?? 'Belum Diisi' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-calendar-days"></i></div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Tanggal Lahir</p>
                                <p class="text-xs font-semibold text-gray-700">
                                    {{ $freelancer->birth_date ?? 'Belum Diisi' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 md:col-span-2">
                            <div class="w-10 h-10 bg-blue-50 text-[#0b51b7] rounded-xl flex items-center justify-center"><i class="fa-solid fa-house"></i></div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400">Alamat Rumah</p>
                                <p class="text-xs font-semibold text-gray-700">
                                    {{ $freelancer->home_address ?? 'Belum Diisi' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Statistik</h3>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <div class="text-gray-400 mb-1"><i class="fa-solid fa-briefcase text-sm"></i></div>
                                <p class="text-xl font-bold text-gray-900">{{ $projectCount }}</p>
                                <p class="text-[9px] text-gray-400 uppercase font-medium mt-0.5">Proyek</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <div class="text-gray-400 mb-1"><i class="fa-solid fa-award text-sm"></i></div>
                                <p class="text-xl font-bold text-gray-900">8</p>
                                <p class="text-[9px] text-gray-400 uppercase font-medium mt-0.5">Sertifikat</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <div class="text-gray-400 mb-1"><i class="fa-solid fa-star text-sm text-yellow-400"></i></div>
                                <p class="text-xl font-bold text-gray-900">
                                    {{ session('active_role') === 'UMKM' ? (number_format($cek_umkm->rating ?? 0.0, 1)) : (number_format($freelancer->rating ?? 0.0, 1)) }}
                                </p>
                                <p class="text-[9px] text-gray-400 uppercase font-medium mt-0.5">Rating</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Keahlian</h3>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">Desain Grafis</span>
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">Adobe Illustrator</span>
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">Figma</span>
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">Branding</span>
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">UI/UX Design</span>
                            <span class="px-2.5 py-1 bg-blue-50 text-[#0b51b7] text-[11px] font-medium rounded-lg">Canva</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-gray-900">Proyek Selesai</h3>
                    @forelse($completedProjects as $cp)
                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <h4 class="text-xs font-bold text-gray-800">{{ $cp->project_title }}</h4>
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    {{ $cp->completed_at ? \Carbon\Carbon::parse($cp->completed_at)->translatedFormat('F Y') : 'Baru saja selesai' }}
                                </p>
                            </div>
                            <div class="text-xs text-amber-400 flex items-center gap-0.5">
                                @if($cp->rating)
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $cp->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                @else
                                    <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">Belum Dinilai</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            <p>Belum ada proyek yang selesai.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>
</body>
</html>