<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'password' => ['required', 'string', 'confirmed'],
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan $user adalah instance model User
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save(); // <- Method save() hanya bisa dipakai pada model Eloquent
        }

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
