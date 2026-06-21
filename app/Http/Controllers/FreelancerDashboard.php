<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FreelancerDashboard extends Controller
{
    public function index()
    {
        // 1. Ambil data user freelancer yang sedang login
        $user = Auth::user(); 
        $userId = $user->user_id;

        // 2. Hitung statistik riil freelancer
        $total_applied = DB::table('project_applicants')->where('user_id', $userId)->count();
        $total_active = DB::table('project_progress')->where('freelancer_id', $userId)->whereNull('completed_at')->count();
        $total_completed = DB::table('project_progress')->where('freelancer_id', $userId)->whereNotNull('completed_at')->count();

        // 3. Ambil proyek aktif & selesai yang dikerjakan oleh freelancer ini
        $active_projects = DB::table('project_progress')
            ->join('project', 'project_progress.project_id', '=', 'project.project_id')
            ->join('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
            ->select('project.*', 'umkm.business_name', 'project_progress.current_stage')
            ->where('project_progress.freelancer_id', $userId)
            ->get();

        // 4. Ambil 4 proyek terbaru dari DB (yang statusnya open)
        $projects = DB::table('project')
                        ->join('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
                        ->select('project.*', 'umkm.business_name')
                        ->where('project.status', 'open')
                        ->orderBy('project.project_id', 'desc')
                        ->limit(4)
                        ->get();

        // 5. Oper data ke file view dashboard_freelancer.blade.php
        return view('dashboard_freelance', compact(
            'user', 
            'projects', 
            'total_applied', 
            'total_active', 
            'total_completed',
            'active_projects'
        ));
    }
}