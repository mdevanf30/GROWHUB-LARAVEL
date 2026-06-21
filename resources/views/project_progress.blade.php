<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Monitoring Progress Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .pulsate-dot {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-gray-800">

    <!-- Sidebar Navigation -->
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

            <nav class="px-3 mt-4 space-y-1">
                @if($activeRole === 'UMKM')
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
                @else
                    <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                    </a>
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-user w-5"></i> Profil
                    </a>
                @endif
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm flex items-center gap-2">
                <span class="text-gray-400">Proyek</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-800 font-medium">Monitoring Progress</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($nama_user, 0, 1)) }}
                </div>
                <div class="text-sm">
                    <div class="font-semibold text-gray-900 leading-none">{{ $nama_user }}</div>
                    <div class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">{{ $activeRole }}</div>
                </div>
            </div>
        </header>

        <!-- Container -->
        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Project Info Header -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <span class="px-3 py-1 bg-blue-50 text-[#0d47a1] text-xs font-semibold rounded-full">
                                {{ $proyek->category }}
                            </span>
                            @if($proyek->status === 'in_progress')
                                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-600 text-[10px] font-bold rounded uppercase tracking-wide">
                                    Dikerjakan
                                </span>
                            @elseif($proyek->status === 'completed')
                                <span class="px-2.5 py-0.5 bg-green-50 text-green-600 text-[10px] font-bold rounded uppercase tracking-wide">
                                    Selesai
                                </span>
                            @endif
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $proyek->project_title }}</h1>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-store"></i> {{ $proyek->business_name ?? 'Mitra UMKM' }}
                        </p>
                    </div>

                    <!-- Direct Message & Report Action Buttons -->
                    <div class="flex flex-wrap gap-3 shrink-0">
                        @if($activeRole === 'UMKM')
                            <a href="{{ $freelancer_wa }}" target="_blank" class="px-4 py-2.5 bg-green-600 text-white text-xs font-bold rounded-xl hover:bg-green-700 transition flex items-center gap-2 shadow-sm">
                                <i class="fa-brands fa-whatsapp text-sm"></i> Direct Message Freelancer
                            </a>
                            <button onclick="openReportModal('freelancer')" class="px-4 py-2.5 border border-red-200 text-red-600 text-xs font-bold rounded-xl hover:bg-red-50 transition flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> Laporkan Freelancer
                            </button>
                        @else
                            <a href="{{ $umkm_wa }}" target="_blank" class="px-4 py-2.5 bg-green-600 text-white text-xs font-bold rounded-xl hover:bg-green-700 transition flex items-center gap-2 shadow-sm">
                                <i class="fa-brands fa-whatsapp text-sm"></i> Direct Message UMKM
                            </a>
                            <button onclick="openReportModal('umkm')" class="px-4 py-2.5 border border-red-200 text-red-600 text-xs font-bold rounded-xl hover:bg-red-50 transition flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> Laporkan Mitra UMKM
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Two-Column Grid: Progress Visualization & Project Info -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- LEFT/MIDDLE COLUMN: Monitoring Progress Graphics -->
                    <div class="lg:col-span-2 space-y-6">


                        <!-- Visual Progress Graphic (Mobile-style Line Chart improved) -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                                <h3 class="font-bold text-gray-900 text-sm">Progress Line Chart</h3>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Deadline: {{ $deadline_formatted }}</span>
                            </div>

                            <!-- Stepper Graphic Chart -->
                            <div class="relative py-8 px-4">
                                <!-- Horizontal Background Line -->
                                <div class="absolute left-16 right-16 top-1/2 -translate-y-1/2 h-1 bg-gray-200 rounded-full z-0"></div>
                                
                                <!-- Horizontal Progress Colored Line -->
                                @php
                                    $progress_percentage = '0%';
                                    if ($progress->current_stage === 'planning') $progress_percentage = '0%';
                                    elseif ($progress->current_stage === 'executing') $progress_percentage = '25%';
                                    elseif ($progress->current_stage === 'monitoring') $progress_percentage = '50%';
                                    elseif ($progress->current_stage === 'testing') $progress_percentage = '75%';
                                    elseif ($progress->current_stage === 'finish') $progress_percentage = '100%';
                                @endphp
                                <div class="absolute left-16 right-16 top-1/2 -translate-y-1/2 h-1 bg-blue-600 rounded-full z-0 transition-all duration-500" style="width: calc({{ $progress_percentage }} - 32px);"></div>

                                <!-- Step Nodes -->
                                <div class="relative flex justify-between z-10">
                                    
                                    <!-- Node 1: Planning -->
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $progress->current_stage === 'planning' ? 'bg-red-500 border-red-500 text-white pulsate-dot' : 'bg-blue-600 border-blue-600 text-white' }}">
                                            @if($progress->current_stage === 'planning')
                                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                            @else
                                                <i class="fa-solid fa-check text-xs"></i>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-800 mt-2">Planning</span>
                                    </div>

                                    <!-- Node 2: Executing -->
                                    @php
                                        $executing_active = $progress->current_stage === 'executing';
                                        $executing_passed = in_array($progress->current_stage, ['monitoring', 'testing', 'finish']);
                                    @endphp
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $executing_active ? 'bg-red-500 border-red-500 text-white pulsate-dot' : ($executing_passed ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-200 text-gray-400') }}">
                                            @if($executing_active)
                                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                            @elseif($executing_passed)
                                                <i class="fa-solid fa-check text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-gears text-xs"></i>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-800 mt-2">Executing</span>
                                    </div>

                                    <!-- Node 3: Monitoring -->
                                    @php
                                        $monitoring_active = $progress->current_stage === 'monitoring';
                                        $monitoring_passed = in_array($progress->current_stage, ['testing', 'finish']);
                                    @endphp
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $monitoring_active ? 'bg-red-500 border-red-500 text-white pulsate-dot' : ($monitoring_passed ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-200 text-gray-400') }}">
                                            @if($monitoring_active)
                                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                            @elseif($monitoring_passed)
                                                <i class="fa-solid fa-check text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-800 mt-2">Monitoring</span>
                                    </div>

                                    <!-- Node 4: Testing -->
                                    @php
                                        $testing_active = $progress->current_stage === 'testing';
                                        $testing_passed = $progress->current_stage === 'finish';
                                    @endphp
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $testing_active ? 'bg-red-500 border-red-500 text-white pulsate-dot' : ($testing_passed ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-200 text-gray-400') }}">
                                            @if($testing_active)
                                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                            @elseif($testing_passed)
                                                <i class="fa-solid fa-check text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-flask text-xs"></i>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-800 mt-2">Testing</span>
                                    </div>

                                    <!-- Node 5: Finish -->
                                    @php
                                        $finish_active = $progress->current_stage === 'finish';
                                    @endphp
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $finish_active ? 'bg-red-500 border-red-500 text-white pulsate-dot' : 'bg-white border-gray-200 text-gray-400' }}">
                                            @if($finish_active)
                                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                            @else
                                                <i class="fa-solid fa-flag-checkered text-xs"></i>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-800 mt-2">Finish</span>
                                    </div>

                                </div>
                            </div>

                            <!-- Active Stage Info Banner -->
                            <div class="bg-gray-50 border border-gray-100 p-4 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-800 uppercase tracking-wide">PROGRESS PROJECT:</span>
                                <span class="px-3 py-1 bg-red-50 text-red-500 text-xs font-bold rounded-lg uppercase">
                                    {{ $progress->current_stage }}
                                </span>
                            </div>
                        </div>

                        <!-- Time Remaining & Tahapan Project -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Timer Countdown -->
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                                <h4 class="font-bold text-gray-900 text-xs mb-3">Waktu Tersisa</h4>
                                <div class="bg-gray-50 border border-gray-100 p-4 rounded-xl text-center">
                                    <span id="countdown_timer" class="text-xl font-bold text-gray-800">{{ $time_remaining }}</span>
                                </div>
                                <p class="text-[9px] text-gray-400 mt-3 text-center">Dihitung otomatis berdasarkan deadline proyek.</p>
                            </div>

                            <!-- Stage Action Controls -->
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                                <h4 class="font-bold text-gray-900 text-xs mb-3">Kontrol Status Proyek</h4>
                                
                                @if($activeRole === 'UMKM')
                                    <div class="space-y-4">
                                        <!-- Display stage status for UMKM -->
                                        <div class="space-y-1.5">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Tahapan Saat Ini</label>
                                            <div class="px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-xs font-semibold text-gray-700 uppercase">
                                                {{ $progress->current_stage }}
                                            </div>
                                        </div>

                                        <!-- UMKM action: Selesaikan Proyek -->
                                        @if($proyek->status !== 'completed')
                                            @if($progress->current_stage === 'finish')
                                                <form action="{{ route('project.progress.complete', $proyek->project_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan proyek ini secara resmi? Setelah diselesaikan, Anda akan langsung diarahkan untuk mengunggah bukti transfer pembayaran.')" class="pt-2">
                                                    @csrf
                                                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                                        <i class="fa-solid fa-circle-check"></i> Selesaikan Proyek
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" disabled class="w-full py-2.5 bg-gray-200 text-gray-400 text-xs font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                                    <i class="fa-solid fa-circle-check"></i> Selesaikan Proyek
                                                </button>
                                                <p class="text-[9px] text-red-500 mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i> Menunggu freelancer menyelesaikan pekerjaan hingga tahap finish.</p>
                                            @endif
                                        @else
                                            <div class="p-2.5 bg-green-50 text-green-700 border border-green-200 rounded-xl text-center text-xs font-bold flex flex-col gap-2">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-check-double text-xs"></i> Proyek Sudah Selesai
                                                </div>
                                                @if($progress->payment_proof)
                                                    <a href="{{ asset('storage/' . $progress->payment_proof) }}" download class="mt-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 bg-white text-green-700 border border-green-200 font-semibold rounded-lg hover:bg-green-100 transition text-[10px]">
                                                        <i class="fa-solid fa-download"></i> Bukti Transfer Anda
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Dropdown for Freelancer -->
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Perbarui Tahapan Progress</label>
                                        <select id="stage_select" onchange="updateStageProgress()" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-blue-600">
                                            <option value="planning" {{ $progress->current_stage === 'planning' ? 'selected' : '' }}>1. Planning</option>
                                            <option value="executing" {{ $progress->current_stage === 'executing' ? 'selected' : '' }}>2. Executing</option>
                                            <option value="monitoring" {{ $progress->current_stage === 'monitoring' ? 'selected' : '' }}>3. Monitoring</option>
                                            <option value="testing" {{ $progress->current_stage === 'testing' ? 'selected' : '' }}>4. Testing</option>
                                            <option value="finish" {{ $progress->current_stage === 'finish' ? 'selected' : '' }}>5. Finish</option>
                                        </select>
                                        <span id="stage_update_status" class="text-[9px] font-semibold text-green-600 hidden"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Memperbarui...</span>
                                    </div>
                                @endif
                                <p class="text-[9px] text-gray-400 mt-3 text-center">
                                    {{ $activeRole === 'Freelancer' ? 'Freelancer bertanggung jawab memperbarui tahapan pengerjaan proyek.' : 'Mitra UMKM memantau progress dan menyelesaikan proyek ketika siap.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Stage Tasks Description Breakdown -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-900 text-sm mb-4 pb-3 border-b border-gray-100">Tahapan Project:</h3>
                            <div class="space-y-4 text-xs">
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <p class="font-bold text-gray-800">1. Planning</p>
                                    <p class="text-gray-500 mt-1">Analisis Kebutuhan, Pengumpulan Data, Pengumpulan Referensi Poster</p>
                                </div>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <p class="font-bold text-gray-800">2. Executing</p>
                                    <p class="text-gray-500 mt-1">Pemilihan Color Pallete, Pemilihan Elemen, Pemilihan Font, Peletakan Elemen</p>
                                </div>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <p class="font-bold text-gray-800">3. Monitoring</p>
                                    <p class="text-gray-500 mt-1">Review berkala pengerjaan proyek dan revisi</p>
                                </div>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <p class="font-bold text-gray-800">4. Testing</p>
                                    <p class="text-gray-500 mt-1">Melakukan Testing Poster kepada UMKM, Diskusi Lebih Lanjut dengan UMKM</p>
                                </div>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <p class="font-bold text-gray-800">5. Finish</p>
                                    <p class="text-gray-500 mt-1">Seluruh pekerjaan selesai dan diserahkan secara resmi untuk diselesaikan oleh UMKM</p>
                                </div>
                            </div>
                        </div>

                        <!-- Freelancer Work Submissions (Input link / File) -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <h3 class="font-bold text-gray-900 text-sm">Hasil Pekerjaan Freelancer</h3>
                                <span class="text-[9px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-bold uppercase">Submission</span>
                            </div>

                            <!-- Display current submissions -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="font-bold text-gray-500 uppercase tracking-wider text-[9px] mb-2">Link Hasil Pekerjaan</p>
                                    @if($progress->project_link)
                                        <a href="{{ $progress->project_link }}" target="_blank" class="text-blue-600 hover:underline break-all font-medium flex items-center gap-1.5">
                                            <i class="fa-solid fa-link text-gray-400"></i> {{ $progress->project_link }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Belum ada link yang diserahkan</span>
                                    @endif
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="font-bold text-gray-500 uppercase tracking-wider text-[9px] mb-2">File Pekerjaan (Upload)</p>
                                    @if($progress->project_file)
                                        <a href="{{ asset('storage/' . $progress->project_file) }}" download class="text-blue-600 hover:underline break-all font-medium flex items-center gap-1.5">
                                            <i class="fa-solid fa-file-arrow-down text-gray-400 text-sm"></i> Download File Proyek
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Belum ada file yang diunggah</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Form for Freelancer to submit link/file -->
                            @if($activeRole === 'Freelancer' && $proyek->status !== 'completed')
                                <form action="{{ route('project.progress.submit', $proyek->project_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-4 border-t border-gray-100">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wide">Serahkan Link Proyek</label>
                                            <input type="url" name="project_link" value="{{ $progress->project_link }}" placeholder="https://github.com/user/project-repo"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-blue-600">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-700 uppercase tracking-wide">Unggah File Proyek (ZIP/PDF/RAR)</label>
                                            <input type="file" name="project_file"
                                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0d47a1] hover:file:bg-blue-100">
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                            Submit Pekerjaan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Project Specifications -->
                    <div class="space-y-6">
                        
                        <!-- Project Details Card (specs from buat_proyek) -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                            <h3 class="font-bold text-gray-900 text-sm pb-3 border-b border-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-[#0b51b7]"></i> Spesifikasi Proyek
                            </h3>

                            <div class="space-y-4 text-xs">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Judul Proyek</p>
                                    <p class="font-bold text-gray-800 mt-1">{{ $proyek->project_title }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Budget</p>
                                        <p class="font-bold text-[#0b51b7] text-sm mt-1">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Deadline</p>
                                        <p class="font-bold text-gray-800 mt-1">{{ $deadline_formatted }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Lokasi Proyek</p>
                                    <p class="font-semibold text-gray-800 mt-1 flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-gray-400"></i> {{ $proyek->project_address ?? 'Remote' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Deskripsi Proyek</p>
                                    <p class="text-gray-500 mt-1 whitespace-pre-line leading-relaxed">{{ $proyek->description }}</p>
                                </div>
                                
                                <!-- Requirements -->
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Persyaratan</p>
                                    <ul class="space-y-1.5 pl-3 list-disc text-gray-500">
                                        @foreach(explode("\n", $proyek->requirements) as $req)
                                            @if(trim($req))
                                                <li>{{ trim($req) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Reference File -->
                                @if($proyek->reference_file)
                                    <div class="pt-2">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">File Referensi Pendukung</p>
                                        <a href="{{ asset('storage/' . $proyek->reference_file) }}" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition">
                                            <i class="fa-solid fa-paperclip"></i> Download Referensi
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Personnel Involved (Mitra UMKM / Freelancer Profile Details) -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                            <h3 class="font-bold text-gray-900 text-sm pb-3 border-b border-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-user-group text-[#0b51b7]"></i> Pihak Terlibat
                            </h3>
                            
                            <!-- Freelancer Profile Info -->
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-sm">
                                    {{ $freelancer ? strtoupper(substr($freelancer->full_name, 0, 1)) : 'F' }}
                                </div>
                                <div class="text-xs">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Freelancer Terpilih</p>
                                    <p class="font-bold text-gray-800">{{ $freelancer->full_name ?? 'Freelancer' }}</p>
                                    <p class="text-[10px] text-gray-500 flex items-center gap-1 mt-0.5"><i class="fa-solid fa-star text-amber-500"></i> {{ number_format($freelancer->rating ?? 4.8, 1) }} Rating</p>
                                </div>
                            </div>

                            <!-- UMKM Profile Info -->
                            <div class="flex items-center gap-3 pt-3 border-t border-gray-50">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-[#0d47a1] flex items-center justify-center font-bold text-sm">
                                    {{ $cek_umkm ? strtoupper(substr($cek_umkm->business_name, 0, 1)) : 'U' }}
                                </div>
                                <div class="text-xs">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Mitra UMKM</p>
                                    <p class="font-bold text-gray-800">{{ $cek_umkm->business_name ?? 'UMKM' }}</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5"><i class="fa-solid fa-phone text-gray-400"></i> {{ $cek_umkm->phone_number ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- Modal Laporkan (Reuse report modal style) -->
    <div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Kirim Laporan</h2>
                <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="reportForm" class="space-y-4">
                    @csrf
                    <input type="hidden" id="report_type" name="report_type" value="">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Alasan Pelaporan</label>
                        <select name="reason" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-blue-600">
                            <option value="" disabled selected>Pilih alasan...</option>
                            <option value="penipuan_fraud">Penipuan / Fraud</option>
                            <option value="pekerjaan_tidak_sesuai">Pekerjaan tidak sesuai</option>
                            <option value="tidak_profesional">Tidak profesional</option>
                            <option value="komunikasi_buruk">Komunikasi buruk</option>
                            <option value="pelanggaran_ketentuan">Pelanggaran ketentuan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Detail Tambahan</label>
                        <textarea name="details" rows="4" placeholder="Jelaskan detail laporan Anda secara lengkap..."
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-blue-600 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                        Kirim Laporan Resmi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Countdown Timer Script -->
    <script>
        const deadlineTimestamp = new Date("{{ $proyek->deadline }}T23:59:59").getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadlineTimestamp - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("countdown_timer").innerHTML = "Deadline Telah Lewat";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown_timer").innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
        }, 1000);

        // Update Stage via AJAX (for UMKM role)
        async function updateStageProgress() {
            const stage = document.getElementById('stage_select').value;
            const statusIndicator = document.getElementById('stage_update_status');
            
            statusIndicator.classList.remove('hidden');
            statusIndicator.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memperbarui...';

            try {
                const response = await fetch("{{ route('project.progress.stage', $proyek->project_id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ stage: stage })
                });

                const data = await response.json();

                if (data.success) {
                    statusIndicator.className = 'text-[9px] font-semibold text-green-600 block mt-1';
                    statusIndicator.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> ' + data.message;
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    statusIndicator.className = 'text-[9px] font-semibold text-red-600 block mt-1';
                    statusIndicator.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Gagal: ' + data.message;
                }
            } catch (error) {
                statusIndicator.className = 'text-[9px] font-semibold text-red-600 block mt-1';
                statusIndicator.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Terjadi kesalahan koneksi.';
            }
        }

        // Report Modals
        function openReportModal(type) {
            document.getElementById('report_type').value = type;
            document.getElementById('reportModal').classList.remove('hidden');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }

        document.getElementById('reportForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengirim...';

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('project.report', $proyek->project_id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    closeReportModal();
                    location.reload();
                } else {
                    alert('Gagal: ' + data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan saat mengirim laporan.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    </script>
</body>
</html>
