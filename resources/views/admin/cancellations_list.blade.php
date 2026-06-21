@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Pembatalan Proyek</h1>
        <p class="text-gray-600">Kelola semua permintaan pembatalan proyek</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total_cancellations'] }}</div>
            <div class="text-sm text-gray-600">Total Pembatalan</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            <div class="text-sm text-gray-600">Menunggu Persetujuan</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
            <div class="text-sm text-gray-600">Disetujui</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
            <div class="text-sm text-gray-600">Ditolak</div>
        </div>
    </div>

    <!-- Cancellations Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Dibatalkan Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($cancellations as $cancellation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $cancellation->cancellation_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a href="{{ route('project.show', $cancellation->project_id) }}" class="text-blue-600 hover:underline">
                                {{ $cancellation->project->project_title ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $cancellation->cancelled_by_type === 'umkm' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ strtoupper($cancellation->cancelled_by_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $cancellation->cancelledBy->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($cancellation->reason, 50) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                {{ $cancellation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                   ($cancellation->status === 'approved' ? 'bg-green-100 text-green-700' : 
                                    'bg-red-100 text-red-700') }}">
                                {{ ucfirst($cancellation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $cancellation->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <button onclick="editCancellationStatus({{ $cancellation->cancellation_id }})" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-3xl mb-2 text-gray-300"></i>
                            <p>Belum ada permintaan pembatalan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $cancellations->links() }}
        </div>
    </div>
</div>

<!-- Modal Edit Cancellation Status -->
<div id="editCancellationModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Update Status Pembatalan</h2>
            <button onclick="closeEditCancellationModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editCancellationForm" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                <select id="cancellationStatus" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="pending">Menunggu Persetujuan</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan Admin</label>
                <textarea id="cancellationAdminNotes" name="admin_notes" placeholder="Masukkan catatan admin..." rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeEditCancellationModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
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
let currentCancellationId = null;

function editCancellationStatus(cancellationId) {
    currentCancellationId = cancellationId;
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

document.getElementById('editCancellationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditCancellationModal();
    }
});
</script>
@endsection
