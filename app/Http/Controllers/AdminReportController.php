<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ProjectCancellation;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * Tampilkan daftar semua reports
     */
    public function reportsList()
    {
        $reports = Report::with(['project', 'reporter', 'reportedUser'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total_reports' => Report::count(),
            'open_reports' => Report::where('status', 'open')->count(),
            'in_review' => Report::where('status', 'in_review')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
        ];

        return view('admin.reports_list', compact('reports', 'stats'));
    }

    /**
     * Tampilkan daftar semua cancellations
     */
    public function cancellationsList()
    {
        $cancellations = ProjectCancellation::with(['project', 'cancelledBy'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total_cancellations' => ProjectCancellation::count(),
            'pending' => ProjectCancellation::where('status', 'pending')->count(),
            'approved' => ProjectCancellation::where('status', 'approved')->count(),
            'rejected' => ProjectCancellation::where('status', 'rejected')->count(),
        ];

        return view('admin.cancellations_list', compact('cancellations', 'stats'));
    }

    /**
     * Update status report
     */
    public function updateReportStatus(Request $request, $report_id)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_review,resolved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $report = Report::findOrFail($report_id);
            
            $report->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
                'reviewed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status laporan berhasil diperbarui'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update status cancellation
     */
    public function updateCancellationStatus(Request $request, $cancellation_id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $cancellation = ProjectCancellation::findOrFail($cancellation_id);
            
            // Jika status already approved, prevent changes
            if ($cancellation->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembatalan yang sudah disetujui tidak bisa diubah'
                ], 400);
            }

            $cancellation->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
            ]);

            // If approving, update project status
            if ($validated['status'] === 'approved' && $cancellation->status !== 'approved') {
                $cancellation->project->update(['status' => 'cancelled']);
                $cancellation->update(['approved_at' => now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pembatalan berhasil diperbarui'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
