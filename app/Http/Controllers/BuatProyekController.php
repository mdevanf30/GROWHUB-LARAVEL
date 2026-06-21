<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BuatProyekController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name ?? $user->name ?? 'User';

        // Query wajib menggunakan 'user_id' sesuai struktur tabel UMKM kamu
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        // Return langsung ke blade buat_proyek
        return view('buat_proyek', compact('nama_user', 'cek_umkm'));
    }

    public function store(Request $request)
    {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    $cek_umkm = DB::table('umkm')->where('user_id', $user->user_id)->first();

    if (!$cek_umkm) {
        return redirect()->back()->with('error', 'Anda harus mendaftarkan UMKM terlebih dahulu!');
    }

    DB::table('project')->insert([
        'umkm_id'         => $cek_umkm->umkm_id,
        'project_title'   => $request->input('project_title'),
        'category'        => $request->input('category'),
        'description'     => $request->input('description'),
        'project_budget'  => $request->input('project_budget'),
        'deadline'        => $request->input('deadline'),
        'project_address' => $request->input('project_address'),
        'requirements'    => $request->input('requirements'), 
        'status'          => 'open', 
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

    return redirect()->route('umkm.dashboard')->with('success', 'Proyek berhasil dipublikasikan!');
    }
}
