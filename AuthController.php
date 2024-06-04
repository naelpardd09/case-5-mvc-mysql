<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.register');
    }
    
    public function registerPost(Request $request)
    {
        // Validasi input
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Inisialisasi nama file foto profil
        $photoName = null;
        
        // Cek apakah ada file foto yang diupload
        if ($request->hasFile('profile_image')) {
            // Buat nama file yang unik berdasarkan waktu dan ekstensi file asli
            $photoName = time() . '.' . $request->profile_image->extension();
            // Simpan file ke direktori 'public/photos'
            $request->profile_image->storeAs('public/photos', $photoName);
        }
    
        // Buat pengguna baru
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $photoName, // Simpan nama file foto profil di database
        ]);

    
        return redirect()->route('login');
    }
    


    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $request->session()->put('user', $user);
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->except('password'));
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }
}
