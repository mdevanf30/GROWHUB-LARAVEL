<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($id = null)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $is_own_profile = !$id || ($id == ($user->user_id ?? $user->id));
        $userId = $is_own_profile ? ($user->user_id ?? $user->id) : $id;
        $nama_user = $user->full_name ?? $user->name ?? 'User GrowHub';

        // Ambil data UMKM jika ada
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        // Jika session active_role belum diset, buat default
        if (!session()->has('active_role')) {
            session(['active_role' => 'Freelancer']);
        }

        // Ambil data user untuk info pribadi
        $freelancer = DB::table('users')->where('user_id', $userId)->first() ?? $user;

        if (!isset($freelancer->email_address) && isset($freelancer->email)) {
            $freelancer->email_address = $freelancer->email;
        }

        $profile_name = $freelancer->full_name ?? $freelancer->name ?? 'User GrowHub';
        $login_umkm = DB::table('umkm')->where('user_id', $user->user_id ?? $user->id)->first();

        // Ambil daftar proyek selesai dan ratingnya secara dinamis
        $completedProjects = [];
        $totalCompletedCount = 0;
        $display_role = $is_own_profile ? session('active_role') : 'Freelancer';

        if ($display_role !== 'UMKM') {
            $completedProjects = DB::table('project_progress')
                ->join('project', 'project_progress.project_id', '=', 'project.project_id')
                ->select('project.project_title', 'project_progress.completed_at', 'project_progress.rating_for_freelancer as rating', 'project.project_id')
                ->where('project_progress.freelancer_id', $userId)
                ->whereNotNull('project_progress.completed_at')
                ->where('project_progress.payment_status', 'approved')
                ->orderBy('project_progress.completed_at', 'desc')
                ->take(3)
                ->get();

            $totalCompletedCount = DB::table('project_progress')
                ->where('freelancer_id', $userId)
                ->whereNotNull('completed_at')
                ->where('payment_status', 'approved')
                ->count();
        }

        $projectCount = $totalCompletedCount;

        // Tampilkan view profil dengan data lengkap (UMKM + Freelancer)
        return view('profil', compact('nama_user', 'cek_umkm', 'freelancer', 'completedProjects', 'projectCount', 'totalCompletedCount', 'is_own_profile', 'display_role', 'profile_name', 'login_umkm'));
    }

    /**
     * Tampilkan seluruh riwayat proyek freelancer yang sudah selesai dan disetujui pembayarannya
     */
    public function completedProjects($id = null)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $is_own_profile = !$id || ($id == ($user->user_id ?? $user->id));
        $userId = $is_own_profile ? ($user->user_id ?? $user->id) : $id;
        
        $targetUser = DB::table('users')->where('user_id', $userId)->first() ?? $user;
        $nama_user = $targetUser->full_name ?? $targetUser->name ?? 'User GrowHub';
        $login_umkm = DB::table('umkm')->where('user_id', $user->user_id ?? $user->id)->first();

        // Ambil semua proyek selesai, paid, and verified
        $completedProjects = DB::table('project_progress')
            ->join('project', 'project_progress.project_id', '=', 'project.project_id')
            ->select('project.project_title', 'project_progress.completed_at', 'project_progress.rating_for_freelancer as rating', 'project.project_id')
            ->where('project_progress.freelancer_id', $userId)
            ->whereNotNull('project_progress.completed_at')
            ->where('project_progress.payment_status', 'approved')
            ->orderBy('project_progress.completed_at', 'desc')
            ->get();

        $projectCount = count($completedProjects);

        return view('completed_projects_list', compact('nama_user', 'completedProjects', 'projectCount', 'is_own_profile', 'login_umkm'));
    }

    public function edit()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $userId = $user->user_id ?? $user->id;
        $nama_user = $user->full_name ?? $user->name ?? 'User GrowHub';

        $freelancer = DB::table('users')->where('user_id', $userId)->first() 
                      ?? DB::table('users')->where('id', $userId)->first() 
                      ?? $user;

        return view('edit_profil_freelancer', compact('freelancer', 'nama_user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $userId = $user->user_id ?? $user->id;

        // Cari tahu kolom primary key yang pas untuk query update
        $primaryKey = DB::table('users')->where('user_id', $userId)->exists() ? 'user_id' : 'id';

        DB::table('users')
            ->where($primaryKey, $userId)
            ->update([
                'full_name'    => $request->input('full_name'),
                'phone_number' => $request->input('phone'),       
                'birth_date'   => $request->input('birth_date'), 
                'home_address' => $request->input('address'),     
            ]);

        return redirect('/freelancer/profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}