<?php

namespace App\Http\Controllers;

use App\Models\ProjectCancellation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectCancellationController extends Controller
{
    /**
     * Submit permintaan pembatalan proyek (dari UMKM atau Freelancer)
     */
    public function store(Request $request, $project_id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:2000',
            'cancelled_by' => 'nullable|in:umkm,freelancer',
        ]);

        try {
            $project = Project::findOrFail($project_id);

            // Tentukan tipe pembatalan (default: UMKM jika tidak dikirim)
            $cancelledByType = $validated['cancelled_by'] ?? 'umkm';

            // Jika freelancer batalkan, cek apakah mereka ada di project ini
            if ($cancelledByType === 'freelancer') {
                $application = ProjectApplicant::where('project_id', $project_id)
                    ->where('user_id', Auth::id())
                    ->first();

                if (!$application) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak terdaftar di proyek ini'
                    ], 403);
                }
            }

            // Cek apakah sudah ada permintaan pembatalan yang pending/approved
            $existingCancellation = ProjectCancellation::where('project_id', $project_id)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($existingCancellation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyek ini sudah memiliki permintaan pembatalan yang sedang diproses'
                ], 409);
            }

            // Cek status proyek - jangan boleh batalkan jika sudah completed
            if ($project->status === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa membatalkan proyek yang sudah selesai'
                ], 400);
            }

            // Simpan permintaan pembatalan dengan status langsung approved (otomatis)
            $cancellation = ProjectCancellation::create([
                'project_id' => $project_id,
                'cancelled_by' => Auth::id(),
                'cancelled_by_type' => $cancelledByType,
                'reason' => $validated['reason'],
                'status' => 'approved',
                'approved_at' => now(),
                'admin_notes' => "Pembatalan dari: " . ($cancelledByType === 'freelancer' ? 'Freelancer' : 'UMKM'),
            ]);

            // Langsung update status proyek menjadi cancelled
            $project->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Proyek berhasil dibatalkan.',
                'data' => $cancellation
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve pembatalan proyek (untuk admin)
     */
    public function approve($cancellation_id)
    {
        try {
            $cancellation = ProjectCancellation::findOrFail($cancellation_id);
            
            // Update status proyek menjadi cancelled
            $cancellation->project->update(['status' => 'cancelled']);
            
            // Update cancellation status
            $cancellation->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proyek berhasil dibatalkan'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
