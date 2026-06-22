<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UMKMDashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'Mitra GrowHub';

        // 1. Ambil data UMKM
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        // 2. Inisialisasi variabel proyek sebagai array kosong dulu
        $proyek_umkm = [];

        // 3. Jika data UMKM ditemukan, cari semua proyek yang pernah dibuat oleh UMKM ini
        if ($cek_umkm) {
            $proyek_umkm = DB::table('project')
                ->where('umkm_id', $cek_umkm->umkm_id)
                ->orderBy('created_at', 'desc') // Proyek terbaru muncul di paling atas
                ->get();
        }

        // 4. Lempar variabel $proyek_umkm ke file blade dashboard UMKM
        return view('dashboard_umkm', compact('nama_user', 'cek_umkm', 'proyek_umkm'));
    }

    public function searchFreelancers(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'Mitra GrowHub';

        // Ambil data UMKM jika ada
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        // Ambil input pencarian
        $search = $request->input('search');

        // Query users table
        $query = DB::table('users');

        // Filter out admin users
        $query->where(function($q) {
            $q->where('email_address', 'not like', '%growhubadmin.gmail.com')
              ->whereNotIn('email_address', ['admin@growhub.com', 'admin@gmail.com']);
        });

        // Filter by search query if present
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('home_address', 'like', '%' . $search . '%');
            });
        }

        $freelancers = $query->orderBy('full_name', 'asc')->get();

        return view('search_freelancer', compact('nama_user', 'cek_umkm', 'freelancers', 'search'));
    }
}