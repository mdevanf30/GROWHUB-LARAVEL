<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi data (disesuaikan dengan nama kolom di Model User kamu)
        $validator = Validator::make($request->all(), [
            'full_name'     => 'required|string|max:100',
            'birth_date'    => 'required|date',
            // Perhatikan: unique:users,email_address wajib ditulis lengkap begini
            'email_address' => 'required|string|email|max:150|unique:users,email_address',
            'home_address'  => 'required|string',
            'phone_number'  => 'required|string|max:20',
            'password'      => 'required|string|min:6',
        ]);

        // Jika validasi gagal (misal email sudah ada), kembalikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // 2. Simpan user baru ke database GrowHub
        $user = User::create([
            'full_name'     => $request->full_name,
            'birth_date'    => $request->birth_date,
            'email_address' => $request->email_address,
            'home_address'  => $request->home_address,
            'phone_number'  => $request->phone_number,
            'password'      => Hash::make($request->password), // Password wajib di-hash
            'rating'        => 0.00, // Rating awal otomatis 0
            'status'        => 'active' // Mengisi kolom status di fillable kamu
        ]);

        // 3. Kembalikan respon sukses format JSON ke Android
        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi GrowHub berhasil!',
            'data'    => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // 1. Validasi inputan (hanya butuh email dan password)
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email',
            'password'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // 2. Cari user berdasarkan email_address
        $user = User::where('email_address', $request->email_address)->first();

        // 3. Cek apakah user ada DAN apakah passwordnya cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau Password salah!'
            ], 401); // 401 artinya Unauthorized (Tidak diizinkan)
        }

        // 4. Jika cocok, buatkan Token Sanctum untuk Android
        $token = $user->createToken('GrowHubToken')->plainTextToken;

        // 5. Kembalikan respon sukses beserta Token-nya
        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil!',
            'data'    => $user,
            'token   ' => $token // Token ini yang akan disimpan di Room Database Android nanti
        ], 200);
    }
}