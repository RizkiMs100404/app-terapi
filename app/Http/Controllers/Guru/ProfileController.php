<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('guru.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
        ], [
            'name.required' => 'Nama jangan dikosongin ya!',
            'username.unique' => 'Username ini sudah dipakai orang lain.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama kamu salah.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password nggak cocok.',
            'password.min' => 'Password minimal 8 karakter ya.'
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Keamanan akun diperbarui! Password berhasil diganti.');
    }
}