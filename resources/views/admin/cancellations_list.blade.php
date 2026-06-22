<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Daftar Pembatalan Proyek</title>
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
                    <a href="{{ route('admin.reports.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Laporan</a>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu Pembatalan</span>
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
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-2">Daftar Pembatalan Proyek</h1>
            <p class="text-gray-600">Kelola semua permintaan persetujuan pembatalan proyek dari pengguna</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Pembatalan</span>
                <div class="text-3xl font-black text-blue-600 mt-1">{{ $stats['total_cancellations'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Menunggu Persetujuan</span>
                <div class="text-3xl font-black text-yellow-600 mt-1">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Disetujui</span>
                <div class="text-3xl font-black text-green-600 mt-1">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Ditolak</span>
                <div class="text-3xl font-black text-red-600 mt-1">{{ $stats['rejected'] }}</div>
            </div>
        </div>

        <!-- Cancellations Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Proyek</th>
                            <th class="p-4">Tipe</th>
                            <th class="p-4">Dibatalkan Oleh</th>
                            <th class="p-4">Alasan</th>
                            <th class="p-4">Status Pengajuan</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($cancellations as $cancellation)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600 font-mono">#{{ $cancellation->cancellation_id }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-900">
                                <a href="{{ route('project.show', $cancellation->project_id) }}" class="text-blue-600 hover:underline">
                                    {{ $cancellation->project->project_title ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="p-4 text-sm">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $cancellation->cancelled_by_type === 'umkm' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-purple-50 text-purple-700 border-purple-200' }}">
                                    {{ strtoupper($cancellation->cancelled_by_type) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-semibold text-gray-900">{{ $cancellation->cancelledBy->full_name ?? 'N/A' }}</td>
                            <td class="p-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $cancellation->reason }}">{{ \Illuminate\Support\Str::limit($cancellation->reason, 50) }}</td>
                            <td class="p-4 text-sm">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border 
                                    {{ $cancellation->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 
                                       ($cancellation->status === 'approved' ? 'bg-green-50 text-green-700 border-green-200' : 
                                        'bg-red-50 text-red-700 border-red-200') }}">
                                    {{ ucfirst($cancellation->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-600 whitespace-nowrap">{{ $cancellation->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <button onclick="editCancellationStatus({{ $cancellation->cancellation_id }}, '{{ $cancellation->status }}', '{{ addslashes($cancellation->admin_notes) }}')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-300"></i>
                                <p class="text-sm">Belum ada permintaan pembatalan saat ini, rek.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $cancellations->links() }}
            </div>
        </div>
    </main>

    <!-- Modal Edit Cancellation Status -->
    <div id="editCancellationModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-gray-200">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-900">Update Status Pembatalan</h2>
                <button onclick="closeEditCancellationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="editCancellationForm" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Status Pembatalan</label>
                    <select id="cancellationStatus" name="status" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary transition-colors">
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Catatan Admin</label>
                    <textarea id="cancellationAdminNotes" name="admin_notes" placeholder="Masukkan catatan admin..." rows="3" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-150">
                    <button type="button" onclick="closeEditCancellationModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition text-sm">
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
    let currentCancellationId = null;

    function editCancellationStatus(cancellationId, currentStatus, adminNotes) {
        currentCancellationId = cancellationId;
        document.getElementById('cancellationStatus').value = currentStatus;
        document.getElementById('cancellationAdminNotes').value = adminNotes === 'null' ? '' : adminNotes;
        document.getElementById('editCancellationModal').classList.remove('hidden');
    }

    function closeEditCancellationModal() {
        document.getElementById('editCancellationModal').classList.add('hidden');
        document.getElementById('editCancellationForm').reset();
        currentCancellationId = null;
    }

    document.getElementById('editCancellationForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;

        try {
            button.disabled = true;
            button.textContent = 'Menyimpan...';

            const response = await fetch(`/admin/cancellation/${currentCancellationId}/status`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-HTTP-Method-Override': 'PUT',
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

    document.getElementById('editCancellationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditCancellationModal();
        }
    });
    </script>
</body>
</html>
