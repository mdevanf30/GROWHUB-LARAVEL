<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'User';
        
        // Get UMKM data jika user punya UMKM
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();
        
        // Get active role dari session
        $activeRole = session()->get('active_role', 'Freelancer');
        
        $search = $request->input('search', '');
        $kategori = $request->input('kategori', '');

        // Query menggunakan DB::table
        $query = DB::table('project')
            ->leftJoin('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
            ->select('project.*', 'umkm.business_name');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('project.project_title', 'like', "%{$search}%")
                  ->orWhere('project.description', 'like', "%{$search}%")
                  ->orWhere('umkm.business_name', 'like', "%{$search}%");
            });
        }

        if (!empty($kategori) && $kategori !== 'Semua') {
            $query->where('project.category', $kategori);
        }

        $projects = $query->where('project.status', 'open')
                          ->orderBy('project.created_at', 'desc')
                          ->get();

        $list_kategori = ['Semua', 'Desain logo', 'Konten media sosial', 'Desain kemasan', 'Video', 'Website', 'Lainnya'];

        return view('jelajahi_proyek', compact('projects', 'nama_user', 'search', 'kategori', 'list_kategori', 'cek_umkm', 'activeRole'));
    }
}