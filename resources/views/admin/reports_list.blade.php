<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Daftar Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-primary { background-color: #0d47a1; }
        .text-primary { color: #0d47a1; }
        .border-primary { border-color: #0d47a1; }
        .hover-bg-primary:hover { background-color: #0a3981; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-black tracking-wider text-primary">GROWHUB</span>
                    <span class="text-xs uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded text-primary border border-blue-200 font-bold">Admin Panel</span>
                </div>
                <div class="flex space-x-2 text-sm font-semibold">
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu User</a>
                    <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu UMKM</a>
                    <a href="{{ route('admin.project.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Project</a>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu Laporan</span>
                    <a href="{{ route('admin.cancellations.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Pembatalan</a>
                    <a href="{{ route('admin.grafik.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Data Grafik</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition">Keluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-2">Daftar Laporan</h1>
            <p class="text-gray-600">Kelola semua laporan aduan dari pengguna secara langsung</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Laporan</span>
                <div class="text-3xl font-black text-blue-600 mt-1">{{ $stats['total_reports'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Terbuka</span>
                <div class="text-3xl font-black text-red-600 mt-1">{{ $stats['open_reports'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Dalam Tinjauan</span>
                <div class="text-3xl font-black text-orange-500 mt-1">{{ $stats['in_review'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Terselesaikan</span>
                <div class="text-3xl font-black text-green-600 mt-1">{{ $stats['resolved'] }}</div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Tipe</th>
                            <th class="p-4">Pelapor</th>
                            <th class="p-4">Yang Dilaporkan</th>
                            <th class="p-4">Proyek</th>
                            <th class="p-4">Alasan</th>
                            <th class="p-4">Status Laporan</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600 font-mono">#{{ $report->report_id }}</td>
                            <td class="p-4 text-sm">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $report->report_type === 'umkm' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-purple-50 text-purple-700 border-purple-200' }}">
                                    {{ strtoupper($report->report_type) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-semibold text-gray-900">{{ $report->reporter->full_name ?? 'N/A' }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-900">{{ $report->reportedUser->full_name ?? 'N/A' }}</td>
                            <td class="p-4 text-sm text-gray-600">{{ $report->project->project_title ?? 'N/A' }}</td>
                            <td class="p-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $report->reason }}">{{ $report->reason }}</td>
                            <td class="p-4 text-sm">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border 
                                    {{ $report->status === 'open' ? 'bg-red-50 text-red-700 border-red-200' : 
                                       ($report->status === 'in_review' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                        ($report->status === 'resolved' ? 'bg-green-50 text-green-700 border-green-200' : 
                                         'bg-gray-50 text-gray-700 border-gray-200')) }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <button onclick="editReportStatus({{ $report->report_id }}, '{{ $report->status }}', '{{ addslashes($report->admin_notes) }}')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-300"></i>
                                <p class="text-sm">Belum ada laporan aduan saat ini, rek.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reports->links() }}
            </div>
        </div>
    </main>

    <!-- Modal Edit Report Status -->
    <div id="editReportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-900">Update Status Laporan</h2>
                <button onclick="closeEditReportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="editReportForm" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Status Laporan</label>
                    <select id="reportStatus" name="status" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary transition-colors">
                        <option value="open">Terbuka</option>
                        <option value="in_review">Dalam Tinjauan</option>
                        <option value="resolved">Terselesaikan</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Catatan Admin</label>
                    <textarea id="reportAdminNotes" name="admin_notes" placeholder="Masukkan catatan admin..." rows="3" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-150">
                    <button type="button" onclick="closeEditReportModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition text-sm">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-2 bg-[#0d47a1] text-white font-semibold rounded-xl hover:bg-blue-800 transition text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let currentReportId = null;

    function editReportStatus(reportId, currentStatus, adminNotes) {
        currentReportId = reportId;
        document.getElementById('reportStatus').value = currentStatus;
        document.getElementById('reportAdminNotes').value = adminNotes === 'null' ? '' : adminNotes;
        document.getElementById('editReportModal').classList.remove('hidden');
    }

    function closeEditReportModal() {
        document.getElementById('editReportModal').classList.add('hidden');
        document.getElementById('editReportForm').reset();
        currentReportId = null;
    }

    document.getElementById('editReportForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;

        try {
            button.disabled = true;
            button.textContent = 'Menyimpan...';

            const response = await fetch(`/admin/report/${currentReportId}/status`, {
                method: 'POST', // Laravel POST with PUT method spoofing via fields
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-HTTP-Method-Override': 'PUT', // Spoofing PUT request
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
            alert('Terjadi kesalahan: ' + error.message);
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    });

    document.getElementById('editReportModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditReportModal();
        }
    });
    </script>
</body>
</html>
