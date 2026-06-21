@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Laporan</h1>
        <p class="text-gray-600">Kelola semua laporan dari pengguna</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total_reports'] }}</div>
            <div class="text-sm text-gray-600">Total Laporan</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['open_reports'] }}</div>
            <div class="text-sm text-gray-600">Terbuka</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-orange-600">{{ $stats['in_review'] }}</div>
            <div class="text-sm text-gray-600">Dalam Tinjauan</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</div>
            <div class="text-sm text-gray-600">Terselesaikan</div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Yang Dilaporkan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $report->report_id }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $report->report_type === 'umkm' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ strtoupper($report->report_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $report->reporter->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $report->reportedUser->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $report->project->project_title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $report->reason }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                {{ $report->status === 'open' ? 'bg-red-100 text-red-700' : 
                                   ($report->status === 'in_review' ? 'bg-yellow-100 text-yellow-700' : 
                                    ($report->status === 'resolved' ? 'bg-green-100 text-green-700' : 
                                     'bg-gray-100 text-gray-700')) }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button onclick="editReportStatus({{ $report->report_id }})" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-300"></i>
                            <p>Belum ada laporan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reports->links() }}
        </div>
    </div>
</div>

<!-- Modal Edit Report Status -->
<div id="editReportModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Update Status Laporan</h2>
            <button onclick="closeEditReportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editReportForm" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                <select id="reportStatus" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="open">Terbuka</option>
                    <option value="in_review">Dalam Tinjauan</option>
                    <option value="resolved">Terselesaikan</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan Admin</label>
                <textarea id="reportAdminNotes" name="admin_notes" placeholder="Masukkan catatan admin..." rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeEditReportModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentReportId = null;

function editReportStatus(reportId) {
    currentReportId = reportId;
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
            method: 'PUT',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
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
@endsection
