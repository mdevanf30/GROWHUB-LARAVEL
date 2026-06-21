<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Submit laporan untuk UMKM atau Freelancer
     */
    public function store(Request $request, $project_id)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:umkm,freelancer',
            'reason' => 'required|string',
            'details' => 'nullable|string|max:2000',
        ]);

        try {
            $project = Project::findOrFail($project_id);

            // Tentukan user yang dilaporkan
            if ($validated['report_type'] === 'umkm') {
                $reportedUserId = $project->umkm->user_id; // User UMKM
            } else {
                // Untuk freelancer, perlu cek siapa freelancer yang accepted di project ini
                $acceptedApplicant = $project->applicants()
                    ->where('status', 'accepted')
                    ->first();
                
                if (!$acceptedApplicant) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Belum ada freelancer yang diterima untuk proyek ini'
                    ], 400);
                }
                $reportedUserId = $acceptedApplicant->user_id;
            }

            // Cek apakah sudah ada laporan yang sama
            $existingReport = Report::where('project_id', $project_id)
                ->where('reporter_id', Auth::id())
                ->where('reported_user_id', $reportedUserId)
                ->where('report_type', $validated['report_type'])
                ->where('status', '!=', 'rejected')
                ->first();

            if ($existingReport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah membuat laporan untuk proyek ini sebelumnya'
                ], 409);
            }

            // Simpan laporan
            $report = Report::create([
                'project_id' => $project_id,
                'reporter_id' => Auth::id(),
                'reported_user_id' => $reportedUserId,
                'report_type' => $validated['report_type'],
                'reason' => $validated['reason'],
                'details' => $validated['details'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan Anda berhasil dikirim. Tim kami akan segera meninjau.',
                'data' => $report
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
