<?php

namespace App\Http\Controllers;

use App\Models\ProjectApplicant;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectApplicantController extends Controller
{
    /**
     * Submit aplikasi pelamar untuk proyek
     */
    public function store(Request $request, $project_id)
    {
        // Validasi input
        $validated = $request->validate([
            'cover_letter' => 'required|string|max:2000',
            'portfolio_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        // Cek proyek ada atau tidak
        $project = Project::findOrFail($project_id);

        // Cek apakah freelancer sudah apply ke proyek ini
        $existingApplication = ProjectApplicant::where('project_id', $project_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melamar proyek ini sebelumnya'
            ], 409);
        }

        try {
            $applicationData = [
                'project_id' => $project_id,
                'user_id' => Auth::id(),
                'cover_letter' => $validated['cover_letter'],
            ];

            // Handle file upload
            if ($request->hasFile('portfolio_file')) {
                $file = $request->file('portfolio_file');
                $filename = 'portfolio_' . Auth::id() . '_' . $project_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('portfolio_files', $filename, 'public');
                $applicationData['portfolio_file'] = $path;
            }

            // Simpan aplikasi
            $application = ProjectApplicant::create($applicationData);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi Anda berhasil dikirim!',
                'data' => $application
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan daftar pelamar untuk proyek tertentu (untuk UMKM)
     */
    public function listApplicants($project_id)
    {
        try {
            // Cari project 
            $project = Project::findOrFail($project_id);

            // Get applicants dengan freelancer info
            $applicants = ProjectApplicant::with('freelancer')
                ->where('project_id', $project_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get user name
            $nama_user = Auth::user()->full_name ?? Auth::user()->name ?? 'User';

            return view('kelola_pelamar', [
                'project' => $project,
                'applicants' => $applicants,
                'nama_user' => $nama_user,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in listApplicants: ' . $e->getMessage() . ' | Project ID: ' . $project_id);
            return redirect()->route('jelajahi_proyek')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Terima pelamar
     */
    public function accept($application_id)
    {
        try {
            $application = ProjectApplicant::findOrFail($application_id);
            
            // Verifikasi user adalah pemilik proyek
            $project = $application->project;
            
            // Update status aplikasi menjadi accepted
            $application->update([
                'status' => 'accepted',
                'decided_at' => now(),
            ]);

            // Optional: Reject aplikasi lain untuk proyek yang sama
            ProjectApplicant::where('project_id', $application->project_id)
                ->where('application_id', '!=', $application_id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected', 'decided_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Pelamar berhasil diterima'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tolak pelamar
     */
    public function reject($application_id)
    {
        try {
            $application = ProjectApplicant::findOrFail($application_id);
            
            $application->update([
                'status' => 'rejected',
                'decided_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pelamar berhasil ditolak'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus aplikasi
     */
    public function destroy($application_id)
    {
        try {
            $application = ProjectApplicant::findOrFail($application_id);
            
            // Hapus file jika ada
            if ($application->portfolio_file && Storage::disk('public')->exists($application->portfolio_file)) {
                Storage::disk('public')->delete($application->portfolio_file);
            }

            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Freelancer withdraw (batalkan) lamaran mereka
     */
    public function withdraw(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_id' => 'required|integer|exists:project,project_id',
            ]);

            $application = ProjectApplicant::where('project_id', $validated['project_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki lamaran untuk proyek ini'
                ], 404);
            }

            if ($application->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya lamaran yang masih pending yang bisa dibatalkan'
                ], 400);
            }

            // Hapus file jika ada
            if ($application->portfolio_file && Storage::disk('public')->exists($application->portfolio_file)) {
                Storage::disk('public')->delete($application->portfolio_file);
            }

            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lamaran Anda berhasil dibatalkan'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
