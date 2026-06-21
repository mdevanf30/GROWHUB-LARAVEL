<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. MANAGEMENT USER (HALAMAN UTAMA ADMIN)
    public function index(Request $request)
    {
        $user = null; 
        
        // Mengambil data user tunggal berdasarkan user_id jika tombol edit diklik
        if ($request->has('user_id')) {
            $user = DB::table('users')->where('user_id', $request->user_id)->first();
        }

        // Mengambil semua data user untuk isi tabel
        $users = DB::table('users')->get();
        
        // Kirim variabel $users dan $user ke view admin.blade.php
        return view('admin', compact('users', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name'     => 'required',
            'birth_date'    => 'required|date',
            'email_address' => 'required|email',
            'home_address'  => 'required',
            'phone_number'  => 'required',
            'status'        => 'required',
        ]);

        DB::table('users')->where('user_id', $id)->update([
            'full_name'     => $request->full_name,
            'birth_date'    => $request->birth_date,
            'email_address' => $request->email_address,
            'home_address'  => $request->home_address,
            'phone_number'  => $request->phone_number,
            'status'        => $request->status,
            'updated_at'    => now(),
        ]);

        return redirect()->route('admin.index')->with('success', 'Data User berhasil diupdate!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('user_id', $id)->delete();
        return redirect()->route('admin.index')->with('success', 'Data User berhasil dihapus!');
    }

    // 2. MANAGEMENT UMKM
    public function indexUmkm(Request $request)
    {
        $umkm_select = null;
        if ($request->has('umkm_id')) {
            $umkm_select = DB::table('umkm')->where('umkm_id', $request->umkm_id)->first();
        }

        $all_umkm = DB::table('umkm')->get();
        return view('adminumkm', compact('all_umkm', 'umkm_select'));
    }

    public function updateUmkm(Request $request, $id)
    {
        // 1. Validasi disesuaikan HANYA dengan input yang ada di form
        $request->validate([
            'business_name'   => 'required',
            'category'        => 'required',
            'description'     => 'required',
            'address'         => 'required',
            'phone_number'    => 'nullable',
            'supporting_file' => 'nullable',
            'rating'          => 'required|numeric',
        ]);

        // 2. Update database hanya untuk kolom yang ada di form Edit
        $updateData = [
            'business_name'   => $request->business_name,
            'category'        => $request->category,
            'description'     => $request->description,
            'address'         => $request->address,
            'phone_number'    => $request->phone_number,
            'rating'          => $request->rating,
            'updated_at'      => now(),
        ];

        // Update supporting_file hanya jika diisi
        if ($request->filled('supporting_file')) {
            $updateData['supporting_file'] = $request->supporting_file;
        }

        DB::table('umkm')->where('umkm_id', $id)->update($updateData);

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil diupdate!');
    }

    public function destroyUmkm($id)
    {
        DB::table('umkm')->where('umkm_id', $id)->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus!');
    }

    // 3. MANAGEMENT PROJECT
    public function indexProject(Request $request)
    {
        $project_select = null; 
    
        // Mengecek parameter query string (?project_id=) saat tombol edit di tabel diklik
        if ($request->has('project_id')) {
            $project_select = DB::table('project')
                ->leftJoin('project_progress', 'project.project_id', '=', 'project_progress.project_id')
                ->select('project.*', 'project_progress.payment_proof', 'project_progress.payment_status')
                ->where('project.project_id', $request->project_id)
                ->first();
        }

        $all_projects = DB::table('project')
            ->leftJoin('project_progress', 'project.project_id', '=', 'project_progress.project_id')
            ->select('project.*', 'project_progress.payment_proof', 'project_progress.payment_status')
            ->get();
    
        return view('admin_umkm_project', compact('all_projects', 'project_select'));
    }
 
    public function updateProject(Request $request, $id)
    {
        // 1. Sesuaikan validasi HANYA dengan kolom yang ada di form Edit
        $request->validate([
            'project_title'   => 'required',
            'category'        => 'required',
            'project_budget'  => 'required|numeric',
            'deadline'        => 'required|date',
            'status'          => 'required',
            'payment_status'  => 'nullable|in:unpaid,pending,approved,rejected',
        ]);
 
        // 2. Update data di tabel project sesuai dengan input form
        DB::table('project')->where('project_id', $id)->update([
            'project_title'   => $request->project_title,
            'category'        => $request->category,
            'project_budget'  => $request->project_budget,
            'deadline'        => $request->deadline,
            'status'          => $request->status,
            'updated_at'      => now(),
        ]);

        if ($request->has('payment_status')) {
            DB::table('project_progress')
                ->where('project_id', $id)
                ->update([
                    'payment_status' => $request->payment_status,
                    'updated_at'      => now(),
                ]);
        }
 
        return redirect()->route('admin.project.index')->with('success', 'Data project berhasil diupdate!');
    }

    public function destroyProject($id)
    {
        DB::table('project')->where('project_id', $id)->delete();
        return redirect()->route('admin.project.index')->with('success', 'Project berhasil dihapus!');
    }
    
    //grafik
    public function indexGrafik()
    {
        // 1. Metrik Utama (Stat Cards)
        $totalUsers = DB::table('users')->count();
        $activeUsers = DB::table('users')->where('status', 'active')->count();
        $totalProjects = DB::table('project')->count();
        $completedProjects = DB::table('project')->where('status', 'completed')->count();

        // 2. Grafik Status Pengguna (Active, Inactive, Banned)
        $userStatus = DB::table('users')
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // 3. Grafik Peran Pengguna (Freelancer vs UMKM)
        $totalUmkm = DB::table('umkm')->count();
        $totalFreelancers = DB::table('users')
            ->leftJoin('umkm', 'users.user_id', '=', 'umkm.user_id')
            ->whereNull('umkm.user_id')
            ->count();
            
        $userRoles = [
            ['role' => 'Freelancer', 'total' => $totalFreelancers],
            ['role' => 'Mitra UMKM', 'total' => $totalUmkm]
        ];

        // 4. Grafik Status Project
        $projectStatus = DB::table('project')
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // 5. Grafik Kategori Project
        $projectCategories = DB::table('project')
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->get();

        return view('admin.admin_grafik', compact(
            'totalUsers',
            'activeUsers',
            'totalProjects',
            'completedProjects',
            'userStatus',
            'userRoles',
            'projectStatus',
            'projectCategories'
        ));
    }
}