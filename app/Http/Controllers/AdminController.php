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
            $project_select = DB::table('project')->where('project_id', $request->project_id)->first();
        }

        $all_projects = DB::table('project')->get();
    
        // Kirim variabel $project_select ke file Blade kamu
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

        return redirect()->route('admin.project.index')->with('success', 'Data project berhasil diupdate!');
    }

    public function destroyProject($id)
    {
        DB::table('project')->where('project_id', $id)->delete();
        return redirect()->route('admin.project.index')->with('success', 'Project berhasil dihapus!');
    }
}