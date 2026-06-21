<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();
        $userId = $user->user_id ?? $user->id;
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

        // Tampilkan view profil dengan data lengkap (UMKM + Freelancer)
        return view('profil', compact('nama_user', 'cek_umkm', 'freelancer'));
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