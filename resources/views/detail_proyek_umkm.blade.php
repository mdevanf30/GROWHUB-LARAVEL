<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $proyek->project_title }} - GrowHub</title>
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
            
            @if($cek_umkm)
            <div class="px-6 mb-6">
                <div class="bg-[#0b51b7] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-solid fa-store text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">ROLE</p>
                        <p class="font-semibold text-sm leading-none">{{ $cek_umkm->business_name ?? 'Mitra UMKM' }}</p>
                    </div>
                </div>
            </div>
            @endif

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
                <a href="{{ route('jelajahi_proyek') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar proyek
                </a>

                <div class="grid grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="col-span-2 space-y-6">
                        <!-- Category & Status -->
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full">
                                {{ $proyek->category }}
                            </span>
                            <span class="px-3 py-1 {{ $status_bg }} text-xs font-bold rounded-full uppercase tracking-wide">
                                {{ $status_label }}
                            </span>
                        </div>

                        <!-- Project Title -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $proyek->project_title }}</h1>
                            <div class="flex flex-wrap items-center gap-6 text-gray-600 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                    <span>{{ $proyek->project_address ?? 'Remote / Online' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-gray-400"></i>
                                    <span>Deadline: {{ $deadline_formatted }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users text-gray-400"></i>
                                    <span>{{ $jumlah_pelamar }} pelamar</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-file-lines text-blue-600"></i> Deskripsi Proyek
                            </h2>
                            <p class="text-gray-600 text-base leading-relaxed">
                                {{ $proyek->description }}
                            </p>
                        </div>

                        <!-- Requirements Section -->
                        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-checklist text-blue-600"></i> Persyaratan
                            </h2>
                            <ul class="space-y-3">
                                @php
                                    $requirements = explode("\n", trim($proyek->requirements));
                                @endphp
                                @foreach($requirements as $req)
                                    @if(trim($req))
                                        <li class="flex items-start gap-3 text-gray-600">
                                            <span class="text-blue-500 mt-1 flex-shrink-0">•</span>
                                            <span>{{ trim($req) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- File Reference Section (if available) -->
                        @if($proyek->reference_file)
                        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-file-download text-blue-600"></i> File Referensi
                            </h2>
                            <a href="{{ asset('storage/' . $proyek->reference_file) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                                <i class="fa-solid fa-download"></i> Download File
                            </a>
                        </div>
                        @endif

                    </div>

                    <!-- Sidebar -->
                    <div class="col-span-1">
                        <!-- Budget Card -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
                            <p class="text-xs text-gray-400 font-medium mb-2">Budget Proyek</p>
                            <h3 class="text-3xl font-bold text-blue-600 mb-6">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Project Owner Card -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-6">
                            <p class="text-xs text-gray-400 font-medium mb-3">Pemilik Proyek</p>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                    {{ strtoupper(substr($proyek->business_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $proyek->business_name ?? 'UMKM' }}</h4>
                                    <p class="text-xs text-gray-500">UMKM</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-yellow-400 text-xs mb-3">
                                <i class="fa-solid fa-star"></i>
                                <span class="text-gray-900 font-medium">{{ $proyek->rating ?? '4.8' }} Rating</span>
                            </div>
                        </div>

                        <!-- Action Buttons - UMKM View -->
                        <div class="space-y-3">
                            <a href="{{ route('project.applicants', $proyek->project_id) }}" class="w-full py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-users"></i> Kelola Pelamar ({{ $jumlah_pelamar }})
                            </a>

                            <button onclick="openCancelModal()" class="w-full py-3 border-2 border-red-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Batalkan Proyek
                            </button>

                            <button onclick="openReportFreelancerModal()" class="w-full py-3 border-2 border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-flag"></i> Laporkan Freelancer
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </main>

    <!-- Modal Batalkan Proyek -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Batalkan Proyek</h2>
                <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <p class="text-gray-700">
                    Apakah Anda yakin ingin membatalkan proyek <strong>{{ $proyek->project_title }}</strong>?
                </p>

                <form id="cancelForm" class="space-y-5">
                    @csrf

                    <!-- Reason Textarea -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            <i class="fa-solid fa-pen-to-square text-blue-600 mr-2"></i>Alasan Pembatalan
                        </label>
                        <textarea id="cancelReason" name="reason" placeholder="Jelaskan alasan pembatalan..." required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            rows="4"></textarea>
                    </div>

                    <!-- Warning -->
                    <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                        <p class="text-xs text-red-700">
                            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                            Tindakan ini akan membatalkan proyek. Freelancer yang sudah diterima akan diberitahu.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="button" onclick="closeCancelModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                            Kembali
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check"></i> Ya, Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Laporkan Freelancer -->
    <div id="reportFreelancerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Laporkan Freelancer</h2>
                <button onclick="closeReportFreelancerModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="reportFreelancerForm" class="p-6 space-y-5">
                @csrf

                <!-- Warning Message -->
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        Laporan akan ditinjau oleh tim kami. Pastikan informasi yang Anda berikan akurat.
                    </p>
                </div>

                <!-- Reason Dropdown -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fa-solid fa-list text-blue-600 mr-2"></i>Alasan Laporan
                    </label>
                    <select id="reportFreelancerReason" name="reason" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        <option value="">Pilih alasan</option>
                        <option value="penipuan_fraud">Penipuan / Fraud</option>
                        <option value="pekerjaan_tidak_sesuai">Pekerjaan tidak sesuai</option>
                        <option value="tidak_profesional">Tidak profesional</option>
                        <option value="komunikasi_buruk">Komunikasi buruk</option>
                        <option value="pelanggaran_ketentuan">Pelanggaran ketentuan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Report Details -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fa-solid fa-pen-to-square text-blue-600 mr-2"></i>Detail Laporan
                    </label>
                    <textarea id="reportFreelancerDetails" name="details" placeholder="Jelaskan masalah yang Anda alami dengan detail..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        rows="5"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 2000 karakter</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeReportFreelancerModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-send"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const projectId = {{ $proyek->project_id }};

        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('cancelForm').reset();
        }

        function openReportFreelancerModal() {
            document.getElementById('reportFreelancerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeReportFreelancerModal() {
            document.getElementById('reportFreelancerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('reportFreelancerForm').reset();
        }

        // Handle Cancel Form Submit
        document.getElementById('cancelForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            try {
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

                const response = await fetch(`/project/${projectId}/cancel`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    closeCancelModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membatalkan proyek. Silakan coba lagi.');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Handle Report Freelancer Form Submit
        document.getElementById('reportFreelancerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('report_type', 'freelancer');

            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            try {
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';

                const response = await fetch(`/project/${projectId}/report`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    closeReportFreelancerModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Close modals when clicking outside
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });

        document.getElementById('reportFreelancerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportFreelancerModal();
            }
        });
    </script>

</body>
</html>
