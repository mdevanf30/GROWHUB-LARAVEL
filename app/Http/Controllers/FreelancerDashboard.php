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

        // 2. Ambil 4 proyek terbaru dari DB
        $projects = DB::table('project')
                        ->join('umkm', 'project.umkm_id', '=', 'umkm.umkm_id')
                        ->select('project.*', 'umkm.business_name')
                        ->orderBy('project.project_id', 'desc')
                        ->limit(4)
                        ->get();

        // 3. Oper data ke file view dashboard_freelancer.blade.php
        return view('dashboard_freelance', compact('user', 'projects'));
    }
}