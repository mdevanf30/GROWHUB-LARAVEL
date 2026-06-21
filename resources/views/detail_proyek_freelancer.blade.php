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

            <nav class="px-3 mt-4 space-y-1">
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
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
                        <div class="text-[11px] text-gray-500 uppercase tracking-wider">Freelancer</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-6xl mx-auto">
                <a href="{{ route('jelajahi_proyek') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-6 text-sm font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar proyek
                </a>

                <div class="grid grid-cols-3 gap-8">
                    <div class="col-span-2 space-y-6">
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

                        <!-- Action Buttons - Freelancer View -->
                        <div class="space-y-3">
                            <button onclick="openLamarModal()" class="w-full py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-check"></i> Lamar Proyek Ini
                            </button>

                            <button onclick="openReportModal()" class="w-full py-3 border-2 border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-flag"></i> Laporkan UMKM
                            </button>

                            <button onclick="openCancelProjectModal()" class="w-full py-3 border-2 border-red-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Batalkan Proyek
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </main>

    <!-- Modal Lamar Proyek -->
    <div id="lamarModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Lamar Proyek</h2>
                <button onclick="closeLamarModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="lamarForm" class="p-6 space-y-5">
                @csrf

                <!-- Project Info -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $proyek->project_title }}</h3>
                    <p class="text-xs text-gray-600">Budget: <span class="font-semibold">Rp {{ number_format($proyek->project_budget, 0, ',', '.') }}</span></p>
                </div>

                <!-- Cover Letter / Pesan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fa-solid fa-pen-to-square text-blue-600 mr-2"></i>Pesan / Cover Letter
                    </label>
                    <textarea id="coverLetter" name="cover_letter" placeholder="Jelaskan mengapa Anda cocok untuk proyek ini..." required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        rows="5"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 2000 karakter</p>
                </div>

                <!-- File Upload CV/Portfolio -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fa-solid fa-upload text-blue-600 mr-2"></i>Upload CV / Portfolio (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-500 transition" onclick="document.getElementById('portfolioFile').click()">
                        <input type="file" id="portfolioFile" name="portfolio_file" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="updateFileName()">
                        <div>
                            <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX, JPG, PNG - Max 10MB</p>
                        </div>
                        <p id="fileName" class="text-xs text-blue-600 font-medium mt-2 hidden"></p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeLamarModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-send"></i> Kirim Lamaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Laporkan UMKM -->
    <div id="reportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Laporkan UMKM</h2>
                <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="reportForm" class="p-6 space-y-5">
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
                    <select id="reportReason" name="reason" required
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
                    <textarea id="reportDetails" name="details" placeholder="Jelaskan masalah yang Anda alami dengan detail..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        rows="5"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 2000 karakter</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeReportModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-send"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Batalkan Lamaran -->
    <div id="withdrawModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Batalkan Lamaran</h2>
                <button onclick="closeWithdrawModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <p class="text-gray-700">
                    Apakah Anda yakin ingin membatalkan lamaran untuk proyek <strong>{{ $proyek->project_title }}</strong>?
                </p>

                <form id="withdrawForm" class="space-y-5">
                    @csrf

                    <!-- Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                            Lamaran yang dibatalkan tidak bisa dipulihkan. UMKM akan menerima notifikasi tentang pembatalan ini.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="button" onclick="closeWithdrawModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                            Tidak
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check"></i> Ya, Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Batalkan Proyek (Freelancer) -->
    <div id="cancelProjectModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Batalkan Proyek</h2>
                <button onclick="closeCancelProjectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <p class="text-gray-700">
                    Apakah Anda yakin ingin membatalkan proyek <strong>{{ $proyek->project_title }}</strong>?
                </p>

                <form id="cancelProjectForm" class="space-y-5">
                    @csrf

                    <!-- Reason Textarea -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            <i class="fa-solid fa-pen-to-square text-blue-600 mr-2"></i>Alasan Pembatalan
                        </label>
                        <textarea id="cancelProjectReason" name="reason" placeholder="Jelaskan alasan pembatalan..." required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            rows="4"></textarea>
                    </div>

                    <!-- Warning -->
                    <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                        <p class="text-xs text-red-700">
                            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                            Tindakan ini akan membatalkan proyek. UMKM akan menerima notifikasi pembatalan ini.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="button" onclick="closeCancelProjectModal()" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
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

    <script>
        const projectId = {{ $proyek->project_id }};

        function openLamarModal() {
            document.getElementById('lamarModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLamarModal() {
            document.getElementById('lamarModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('lamarForm').reset();
            document.getElementById('fileName').classList.add('hidden');
        }

        function openReportModal() {
            document.getElementById('reportModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('reportForm').reset();
        }

        function openWithdrawModal() {
            document.getElementById('withdrawModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeWithdrawModal() {
            document.getElementById('withdrawModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('withdrawForm').reset();
        }

        function openCancelProjectModal() {
            document.getElementById('cancelProjectModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelProjectModal() {
            document.getElementById('cancelProjectModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('cancelProjectForm').reset();
        }

        function updateFileName() {
            const fileInput = document.getElementById('portfolioFile');
            const fileName = document.getElementById('fileName');
            if (fileInput.files.length > 0) {
                fileName.textContent = 'File: ' + fileInput.files[0].name;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        }

        // Handle Lamar Form Submit
        document.getElementById('lamarForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            try {
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';

                const response = await fetch(`/project/${projectId}/apply`, {
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
                    closeLamarModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim lamaran. Silakan coba lagi.');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Handle Report Form Submit
        document.getElementById('reportForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('report_type', 'umkm');

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
                    closeReportModal();
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
        document.getElementById('lamarModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLamarModal();
            }
        });

        document.getElementById('reportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportModal();
            }
        });

        // Handle Withdraw Form Submit
        document.getElementById('withdrawForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            try {
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

                const response = await fetch(`/applicant/withdraw`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        project_id: projectId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    closeWithdrawModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membatalkan lamaran. Silakan coba lagi.');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Handle Cancel Project Form Submit (Freelancer)
        document.getElementById('cancelProjectForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('cancelled_by', 'freelancer');

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
                    closeCancelProjectModal();
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

        // Close modals when clicking outside
        document.getElementById('withdrawModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWithdrawModal();
            }
        });

        document.getElementById('cancelProjectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelProjectModal();
            }
        });
    </script>

</body>
</html>
