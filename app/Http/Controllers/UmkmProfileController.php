<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;

class UmkmProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name;
        
        // AMBIL DATA & SIMPAN KE VARIABEL $cek_umkm
        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();
        
        return view('profil', compact('cek_umkm', 'nama_user'));
    }

    public function showRegisterForm()
    {
        $user = Auth::user();
        $nama_user = $user->full_name;
        return view('daftar_umkm', compact('nama_user'));
    }

    public function processRegister(Request $request)
    {
        $user = Auth::user();
        $userId = $user->user_id;

        // Validasi input
        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'category' => 'required|in:kuliner,fashion,jasa,kerajinan,teknologi',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'supporting_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);
        
        // Handle file upload
        $fileName = null;
        if ($request->hasFile('supporting_file')) {
            $file = $request->file('supporting_file');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Create directory if not exists
            if (!file_exists(public_path('uploads/umkm'))) {
                mkdir(public_path('uploads/umkm'), 0777, true);
            }
            
            $file->move(public_path('uploads/umkm'), $fileName);
        }

        // Insert data ke database menggunakan Eloquent model
        Umkm::create([
            'user_id'         => $userId,
            'business_name'   => $validated['business_name'],
            'category'        => $validated['category'],
            'description'     => $validated['description'],
            'address'         => $validated['address'],
            'phone_number'    => $validated['phone_number'],
            'supporting_file' => $fileName
        ]);

        return redirect()->route('profil')->with('success', 'Pendaftaran UMKM berhasil! Tim kami akan memverifikasi dalam 1-2 hari kerja.');
    }

    public function create()
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $nama_user = $user->full_name;

        $cek_umkm = DB::table('umkm')->where('user_id', $userId)->first();

        return view('buat_proyek', compact('nama_user', 'cek_umkm'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user->user_id;

        $umkm = DB::table('umkm')->where('user_id', $userId)->first();
        $umkmId = $umkm ? $umkm->umkm_id : null;

        $fileName = null;
        if ($request->hasFile('reference_file')) {
            $fileName = time() . '_' . $request->file('reference_file')->getClientOriginalName();
            $request->file('reference_file')->move(public_path('uploads/projects'), $fileName);
        }

        DB::table('project')->insert([
            'umkm_id'         => $umkmId,
            'project_title'   => $request->input('project_title'),
            'category'        => $request->input('category'),
            'description'     => $request->input('description'),
            'project_budget'  => $request->input('project_budget'),
            'deadline'        => $request->input('deadline'),
            'project_address' => $request->input('project_address'),
            'requirements'    => $request->input('requirements'),
            'reference_file'  => $fileName,
            'status'          => 'open',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        return redirect('/umkm/dashboard')->with('success', 'Proyek Baru Berhasil Dipublikasikan!');
    }
}