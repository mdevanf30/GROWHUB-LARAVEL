<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelamar - {{ $project->project_title }} - GrowHub</title>
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

            <div class="px-6 mb-6 mt-6">
                <div class="bg-[#0b51b7] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-solid fa-store text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">ROLE</p>
                        <p class="font-semibold text-sm leading-none">UMKM</p>
                    </div>
                </div>
            </div>

            <nav class="px-3 space-y-1">
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
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-detail').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form-detail" action="{{ route('logout') }}" method="POST" class="hidden">
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
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">UMKM</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-6xl mx-auto">
                
                <!-- Back Button -->
                <a href="{{ route('project.show', $project->project_id) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke detail proyek
                </a>

                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Pelamar</h1>
                    <p class="text-gray-600">{{ $project->project_title }}</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-medium mb-1">TOTAL PELAMAR</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $applicants->count() }}</h3>
                            </div>
                            <i class="fa-solid fa-users text-3xl text-blue-100"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-medium mb-1">MENUNGGU REVIEW</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $applicants->where('status', 'pending')->count() }}</h3>
                            </div>
                            <i class="fa-solid fa-hourglass-end text-3xl text-yellow-100"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 font-medium mb-1">DITERIMA</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $applicants->where('status', 'accepted')->count() }}</h3>
                            </div>
                            <i class="fa-solid fa-check-circle text-3xl text-green-100"></i>
                        </div>
                    </div>
                </div>

                <!-- Applicants List -->
                @if($applicants->count() > 0)
                    <div class="space-y-4">
                        @foreach($applicants as $applicant)
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <!-- Left Side - Freelancer Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <!-- Avatar -->
                                        <a href="{{ route('profil', $applicant->freelancer->user_id) }}" class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0 hover:bg-blue-700 transition cursor-pointer" title="Lihat profil {{ $applicant->freelancer->full_name }}">
                                            {{ strtoupper(substr($applicant->freelancer->full_name, 0, 1)) }}
                                        </a>

                                        <!-- Info -->
                                        <div class="flex-1 pt-1">
                                            <a href="{{ route('profil', $applicant->freelancer->user_id) }}" class="hover:underline hover:text-blue-600 transition" title="Lihat profil {{ $applicant->freelancer->full_name }}">
                                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $applicant->freelancer->full_name }}</h3>
                                            </a>
                                            <div class="flex items-center gap-6 mb-3">
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                                    <span>{{ $applicant->freelancer->rating ?? '0' }} Rating</span>
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <i class="fa-solid fa-calendar-days text-gray-400 mr-2"></i>{{ $applicant->created_at->diffForHumans() }}
                                                </div>
                                            </div>

                                            <!-- Cover Letter Preview -->
                                            <div class="mb-3">
                                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg italic">
                                                    "{{ \Illuminate\Support\Str::limit($applicant->cover_letter, 150) }}"
                                                </p>
                                            </div>

                                            <!-- Status Badge -->
                                            @if($applicant->status === 'pending')
                                                <span class="inline-block px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full">
                                                    <i class="fa-solid fa-hourglass-end mr-1"></i>Menunggu Review
                                                </span>
                                            @elseif($applicant->status === 'accepted')
                                                <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full">
                                                    <i class="fa-solid fa-check-circle mr-1"></i>Diterima
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">
                                                    <i class="fa-solid fa-x-circle mr-1"></i>Ditolak
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Right Side - Actions -->
                                    <div class="flex flex-col gap-2 ml-4">
                                        @if($applicant->portfolio_file)
                                            <a href="{{ asset('storage/' . $applicant->portfolio_file) }}" target="_blank" 
                                               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-eye"></i> Lihat CV/Portfolio
                                            </a>
                                        @endif

                                        @if($applicant->status === 'pending')
                                            <button onclick="acceptApplicant({{ $applicant->application_id }})" 
                                                    class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-check"></i> Terima
                                            </button>
                                            <button onclick="rejectApplicant({{ $applicant->application_id }})" 
                                                    class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-x"></i> Tolak
                                            </button>
                                        @elseif($applicant->status === 'rejected')
                                            <button onclick="deleteApplicant({{ $applicant->application_id }})" 
                                                    class="px-4 py-2 bg-gray-600 text-white text-sm font-bold rounded-lg hover:bg-gray-700 transition flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <i class="fa-solid fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pelamar</h3>
                        <p class="text-gray-600">Tidak ada freelancer yang melamar proyek ini belum.</p>
                    </div>
                @endif

            </div>
        </div>

    </main>

    <script>
        async function acceptApplicant(applicationId) {
            if (!confirm('Yakin menerima pelamar ini? Pelamar lain akan ditolak otomatis.')) {
                return;
            }

            try {
                const response = await fetch(`/applicant/${applicationId}/accept`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menerima pelamar');
            }
        }

        async function rejectApplicant(applicationId) {
            if (!confirm('Yakin menolak pelamar ini?')) {
                return;
            }

            try {
                const response = await fetch(`/applicant/${applicationId}/reject`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menolak pelamar');
            }
        }

        async function deleteApplicant(applicationId) {
            if (!confirm('Yakin menghapus data pelamar ini?')) {
                return;
            }

            try {
                const response = await fetch(`/applicant/${applicationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data');
            }
        }
    </script>

</body>
</html>
