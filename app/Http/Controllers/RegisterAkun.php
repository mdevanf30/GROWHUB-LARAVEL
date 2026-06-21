<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterAkun extends Controller
{
    public function showRegister()
    {
        return view('daftar_mahasiswa_1');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'birth_date'      => 'required|date',
            'email'           => 'required|email|unique:users,email_address',
            'home_address'    => 'required|string',
            'phone_number'    => 'required|string|max:20',
            'password'        => 'required|string',
            'confirm_password' => 'required|same:password'
        ], [
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain',
            'confirm_password.same' => 'Konfirmasi password tidak sesuai',
        ]);

        try {
 
            $user = User::create([
                'full_name'    => $request->input('full_name'),
                'birth_date'   => $request->input('birth_date'),
                'email_address' => $request->input('email'),
                'home_address' => $request->input('home_address'),
                'phone_number' => $request->input('phone_number'),
                'password'     => Hash::make($request->input('password')),
                'status'       => 'active',
            ]);

            return redirect('/login')->with('sukses', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            return back()->with('gagal', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }
}