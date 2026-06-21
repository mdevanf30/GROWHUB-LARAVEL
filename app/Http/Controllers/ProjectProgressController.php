<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectProgressController extends Controller
{
    /**
     * Tampilkan halaman monitoring progress proyek
     */
    public function show($project_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'User';

        // Fetch project and joined UMKM details
        $proyek = DB::table('project')
            ->leftJoin('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
            ->select('project.*', 'umkm.business_name', 'umkm.phone_number as umkm_phone', 'umkm.user_id as umkm_user_id')
            ->where('project.project_id', $project_id)
            ->first();

        if (!$proyek) {
            $activeRole = session()->get('active_role', 'Freelancer');
            $redirectRoute = $activeRole === 'UMKM' ? 'umkm.dashboard' : 'dashboard_freelance';
            return redirect()->route($redirectRoute)->with('error', 'Proyek tidak ditemukan.');
        }

        // Redirect to payment if project is completed
        if ($proyek->status === 'completed') {
            return redirect()->route('project.payment', $project_id);
        }

        // Fetch project progress
        $progress = ProjectProgress::where('project_id', $project_id)->first();

        if (!$progress) {
            // Jaga-jaga data lama: coba cari pelamar yang statusnya accepted
            $acceptedApplicant = DB::table('project_applicants')
                ->where('project_id', $project_id)
                ->where('status', 'accepted')
                ->first();

            if ($acceptedApplicant) {
                $progress = ProjectProgress::create([
                    'project_id' => $project_id,
                    'freelancer_id' => $acceptedApplicant->user_id,
                    'current_stage' => 'planning',
                ]);
            } else {
                $activeRole = session()->get('active_role', 'Freelancer');
                $redirectRoute = $activeRole === 'UMKM' ? 'umkm.dashboard' : 'dashboard_freelance';
                return redirect()->route($redirectRoute)->with('error', 'Progress proyek tidak ditemukan.');
            }
        }

        $activeRole = session()->get('active_role', 'Freelancer');

        // Authorization check
        if ($activeRole === 'UMKM') {
            // Check if current user owns the UMKM that owns this project
            $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();
            if (!$cek_umkm || $proyek->umkm_id !== $cek_umkm->umkm_id) {
                return redirect()->route('umkm.dashboard')->with('error', 'Anda tidak memiliki hak akses ke proyek ini.');
            }
        } else {
            // Check if current user is the assigned freelancer
            if ($progress->freelancer_id !== $userId) {
                return redirect()->route('dashboard_freelance')->with('error', 'Anda tidak terdaftar sebagai freelancer pada proyek ini.');
            }
            $cek_umkm = DB::table('umkm')->where('user_id', $proyek->umkm_user_id)->first();
        }

        // Fetch freelancer info
        $freelancer = User::where('user_id', $progress->freelancer_id)->first();

        // Format deadline
        $deadline_formatted = \Carbon\Carbon::parse($proyek->deadline)->translatedFormat('d M Y');

        // Calculate time remaining (e.g. for dynamic display)
        $deadline_date = \Carbon\Carbon::parse($proyek->deadline)->endOfDay();
        $now = \Carbon\Carbon::now();
        $time_remaining = '';
        if ($now->greaterThan($deadline_date)) {
            $time_remaining = 'Deadline Telah Lewat';
        } else {
            $days = $now->diffInDays($deadline_date);
            $hours = $now->copy()->addDays($days)->diffInHours($deadline_date);
            $minutes = $now->copy()->addDays($days)->addHours($hours)->diffInMinutes($deadline_date);
            $time_remaining = "{$days} hari {$hours} jam {$minutes} menit";
        }

        // Format whatsapp numbers
        $freelancer_wa = $freelancer && $freelancer->phone_number 
            ? 'https://wa.me/' . preg_replace('/^0/', '62', $freelancer->phone_number) 
            : '#';

        $umkm_wa = $proyek->umkm_phone 
            ? 'https://wa.me/' . preg_replace('/^0/', '62', $proyek->umkm_phone) 
            : '#';

        return view('project_progress', compact(
            'proyek',
            'progress',
            'freelancer',
            'cek_umkm',
            'activeRole',
            'nama_user',
            'deadline_formatted',
            'time_remaining',
            'freelancer_wa',
            'umkm_wa'
        ));
    }

    /**
     * Update tahapan (stage) proyek oleh UMKM
     */
    public function updateStage(Request $request, $project_id)
    {
        $validated = $request->validate([
            'stage' => 'required|in:planning,executing,monitoring,testing,finish'
        ]);

        try {
            $project = Project::findOrFail($project_id);
            $progress = ProjectProgress::where('project_id', $project_id)->firstOrFail();

            // Authorization check (only assigned freelancer)
            if ($progress->freelancer_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Hanya freelancer terpilih yang dapat memperbarui tahapan progress.'], 403);
            }

            $progress->update([
                'current_stage' => $validated['stage']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tahapan proyek berhasil diperbarui ke: ' . ucfirst($validated['stage'])
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Freelancer menaruh link atau upload file project
     */
    public function submitWork(Request $request, $project_id)
    {
        $validated = $request->validate([
            'project_link' => 'nullable|url|max:500',
            'project_file' => 'nullable|file|mimes:pdf,zip,rar,jpg,jpeg,png|max:20480', // Max 20MB
        ]);

        try {
            $progress = ProjectProgress::where('project_id', $project_id)->firstOrFail();

            // Authorization check (only freelancer assigned)
            if ($progress->freelancer_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai freelancer pada proyek ini.');
            }

            $updateData = [];

            if ($request->has('project_link')) {
                $updateData['project_link'] = $validated['project_link'];
            }

            // Handle file upload
            if ($request->hasFile('project_file')) {
                // Delete old file if exists
                if ($progress->project_file) {
                    Storage::disk('public')->delete($progress->project_file);
                }

                $file = $request->file('project_file');
                $filename = 'work_' . Auth::id() . '_' . $project_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('project_files', $filename, 'public');
                $updateData['project_file'] = $path;
            }

            $progress->update($updateData);

            return redirect()->back()->with('success', 'Hasil pekerjaan berhasil di-update.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function completeProject(Request $request, $project_id)
    {
        try {
            $project = Project::findOrFail($project_id);
            $progress = ProjectProgress::where('project_id', $project_id)->firstOrFail();

            // Authorization check (only project owner UMKM)
            $cek_umkm = DB::table('umkm')->where('user_id', Auth::id())->first();
            if (!$cek_umkm || $project->umkm_id !== $cek_umkm->umkm_id) {
                return redirect()->back()->with('error', 'Hanya mitra UMKM pemilik proyek yang dapat menandai proyek selesai.');
            }

            // Cek apakah status progress sudah finish
            if ($progress->current_stage !== 'finish') {
                return redirect()->back()->with('error', 'Proyek belum dapat diselesaikan karena freelancer belum mencapai tahapan finish.');
            }

            // Update project status to completed
            $project->update(['status' => 'completed']);

            // Update progress completed time
            $progress->update([
                'completed_at' => now()
            ]);

            return redirect()->route('project.payment', $project_id)->with('success', 'Proyek telah ditandai selesai! Silakan unggah bukti transfer pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Mengunggah bukti pembayaran proyek oleh UMKM (setelah proyek diselesaikan)
     */
    public function uploadPaymentProof(Request $request, $project_id)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // Max 5MB
        ]);

        try {
            $project = Project::findOrFail($project_id);
            $progress = ProjectProgress::where('project_id', $project_id)->firstOrFail();

            // Authorization check (only project owner UMKM)
            $cek_umkm = DB::table('umkm')->where('user_id', Auth::id())->first();
            if (!$cek_umkm || $project->umkm_id !== $cek_umkm->umkm_id) {
                return redirect()->back()->with('error', 'Hanya mitra UMKM pemilik proyek yang dapat mengunggah bukti pembayaran.');
            }

            // Cek apakah proyek sudah selesai
            if ($project->status !== 'completed') {
                return redirect()->back()->with('error', 'Unggah bukti pembayaran hanya dapat dilakukan setelah proyek selesai ditandai.');
            }

            // Handle payment proof upload
            if ($request->hasFile('payment_proof')) {
                // Delete old proof if exists
                if ($progress->payment_proof) {
                    Storage::disk('public')->delete($progress->payment_proof);
                }

                $file = $request->file('payment_proof');
                $filename = 'pay_' . $project_id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payment_proofs', $filename, 'public');
                
                $progress->update([
                    'payment_proof' => $path,
                    'payment_status' => 'pending'
                ]);
            }

            return redirect()->route('project.payment', $project_id)->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran khusus untuk proyek yang sudah selesai
     */
    public function showPayment($project_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'User';

        // Fetch project and joined UMKM details
        $proyek = DB::table('project')
            ->leftJoin('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
            ->select('project.*', 'umkm.business_name', 'umkm.phone_number as umkm_phone', 'umkm.user_id as umkm_user_id')
            ->where('project.project_id', $project_id)
            ->first();

        if (!$proyek) {
            $activeRole = session()->get('active_role', 'Freelancer');
            $redirectRoute = $activeRole === 'UMKM' ? 'umkm.dashboard' : 'dashboard_freelance';
            return redirect()->route($redirectRoute)->with('error', 'Proyek tidak ditemukan.');
        }

        // Cek progress
        $progress = ProjectProgress::where('project_id', $project_id)->first();
        if (!$progress) {
            $activeRole = session()->get('active_role', 'Freelancer');
            $redirectRoute = $activeRole === 'UMKM' ? 'umkm.dashboard' : 'dashboard_freelance';
            return redirect()->route($redirectRoute)->with('error', 'Progress proyek tidak ditemukan.');
        }

        $activeRole = session()->get('active_role', 'Freelancer');

        // Authorization check
        if ($activeRole === 'UMKM') {
            $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();
            if (!$cek_umkm || $proyek->umkm_id !== $cek_umkm->umkm_id) {
                return redirect()->route('umkm.dashboard')->with('error', 'Anda tidak memiliki hak akses ke pembayaran proyek ini.');
            }
        } else {
            if ($progress->freelancer_id !== $userId) {
                return redirect()->route('dashboard_freelance')->with('error', 'Anda tidak terdaftar sebagai freelancer pada proyek ini.');
            }
            $cek_umkm = DB::table('umkm')->where('user_id', $proyek->umkm_user_id)->first();
        }

        return view('project_payment', compact(
            'proyek',
            'progress',
            'cek_umkm',
            'activeRole',
            'nama_user'
        ));
    }

    /**
     * Submit rating untuk Freelancer atau UMKM setelah pembayaran sukses
     */
    public function submitRating(Request $request, $project_id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        try {
            $project = Project::findOrFail($project_id);
            $progress = ProjectProgress::where('project_id', $project_id)->firstOrFail();

            if ($progress->payment_status !== 'approved') {
                return redirect()->back()->with('error', 'Rating hanya dapat diberikan setelah status pembayaran sukses / terverifikasi.');
            }

            $activeRole = session()->get('active_role', 'Freelancer');
            $ratingVal = $validated['rating'];

            if ($activeRole === 'UMKM') {
                // UMKM memberikan rating kepada Freelancer
                $cek_umkm = DB::table('umkm')->where('user_id', Auth::id())->first();
                if (!$cek_umkm || $project->umkm_id !== $cek_umkm->umkm_id) {
                    return redirect()->back()->with('error', 'Hanya mitra UMKM pemilik proyek yang dapat memberikan rating.');
                }

                if ($progress->rating_for_freelancer !== null) {
                    return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk freelancer pada proyek ini.');
                }

                // Update rating di project_progress
                $progress->update([
                    'rating_for_freelancer' => $ratingVal
                ]);

                // Hitung rata-rata rating baru untuk Freelancer (users table)
                $freelancerId = $progress->freelancer_id;
                $avgRating = ProjectProgress::where('freelancer_id', $freelancerId)
                    ->whereNotNull('rating_for_freelancer')
                    ->avg('rating_for_freelancer');

                // Bulatkan ke 1 desimal
                $avgRatingFormatted = round($avgRating, 1);

                DB::table('users')->where('user_id', $freelancerId)->update([
                    'rating' => $avgRatingFormatted,
                    'updated_at' => now()
                ]);

                return redirect()->back()->with('success', 'Terima kasih! Rating untuk freelancer berhasil dikirim.');

            } else {
                // Freelancer memberikan rating kepada UMKM
                if ($progress->freelancer_id !== Auth::id()) {
                    return redirect()->back()->with('error', 'Hanya freelancer terpilih yang dapat memberikan rating.');
                }

                if ($progress->rating_for_umkm !== null) {
                    return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk mitra UMKM pada proyek ini.');
                }

                // Update rating di project_progress
                $progress->update([
                    'rating_for_umkm' => $ratingVal
                ]);

                // Hitung rata-rata rating baru untuk UMKM
                $umkmId = $project->umkm_id;
                
                // Cari semua project_id milik UMKM ini
                $projectIds = DB::table('project')->where('umkm_id', $umkmId)->pluck('project_id');
                
                $avgRating = ProjectProgress::whereIn('project_id', $projectIds)
                    ->whereNotNull('rating_for_umkm')
                    ->avg('rating_for_umkm');

                $avgRatingFormatted = round($avgRating, 1);

                DB::table('umkm')->where('umkm_id', $umkmId)->update([
                    'rating' => $avgRatingFormatted,
                    'updated_at' => now()
                ]);

                return redirect()->back()->with('success', 'Terima kasih! Rating untuk mitra UMKM berhasil dikirim.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
