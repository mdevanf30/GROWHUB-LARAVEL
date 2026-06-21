<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DetailProyekController extends Controller
{
    public function show($project_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $nama_user = $user->full_name ?? $user->name ?? 'User';
        $userId = $user->user_id;

        // Get UMKM data jika user punya UMKM
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        // Get project detail dengan informasi UMKM
        $proyek = DB::table('project')
            ->leftJoin('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
            ->select('project.*', 'umkm.business_name', 'umkm.rating', 'umkm.phone_number as umkm_phone')
            ->where('project.project_id', $project_id)
            ->first();

        if (!$proyek) {
            return redirect()->route('jelajahi_proyek')->with('error', 'Proyek tidak ditemukan');
        }

        // Format deadline
        $deadline_formatted = \Carbon\Carbon::parse($proyek->deadline)->translatedFormat('d M Y');

        // Status label
        if ($proyek->status == 'in_progress') {
            $status_label = "Dikerjakan";
            $status_bg = "bg-amber-50 text-amber-600";
        } elseif ($proyek->status == 'completed') {
            $status_label = "Selesai";
            $status_bg = "bg-green-50 text-green-600";
        } else {
            $status_label = "Terbuka";
            $status_bg = "bg-blue-50 text-blue-600";
        }

        // Tentukan view berdasarkan session role
        // Prioritas: session role > database record
        $activeRole = session()->get('active_role', 'Freelancer');
        $view = ($activeRole === 'UMKM' && $cek_umkm) ? 'detail_proyek_umkm' : 'detail_proyek_freelancer';

        return view($view, compact(
            'proyek', 
            'nama_user', 
            'cek_umkm',
            'deadline_formatted',
            'status_label',
            'status_bg'
        ));
    }
}
