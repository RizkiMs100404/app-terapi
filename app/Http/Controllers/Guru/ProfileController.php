<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        // Kita eager load relasi guruTerapis-nya biar ringan
        return view('guru.profile.edit', [
            'user' => auth()->user()->load('guruTerapis')
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $guru = $user->guruTerapis;

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
            'nomor_hp' => 'nullable|string|max:20',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required'   => 'Nama jangan dikosongin ya!',
            'username.unique' => 'Username ini sudah dipakai orang lain.',
            'email.unique'    => 'Email ini sudah terdaftar.',
            'foto.image'      => 'File harus berupa gambar.',
            'foto.max'        => 'Ukuran foto maksimal 2MB ya.'
        ]);

        // 1. Update data dasar di tabel Users
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
        ]);

        // 2. Siapkan data untuk tabel guru_terapis
        $guruData = [
            'nomor_hp' => $request->nomor_hp,
        ];

        // 3. Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada biar gak nyampah di storage
            if ($guru->foto) {
                Storage::delete('public/foto_guru/' . $guru->foto);
            }

            $file = $request->file('foto');
            $nama_foto = time() . "_" . $file->getClientOriginalName();
            $file->storeAs('public/foto_guru', $nama_foto);
            
            $guruData['foto'] = $nama_foto;
        }

        // 4. Update ke tabel guru_terapis lewat relasi
        $guru->update($guruData);

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required'         => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama kamu salah.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.confirmed'                => 'Konfirmasi password nggak cocok.',
            'password.min'                      => 'Password minimal 8 karakter ya.'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Keamanan akun diperbarui! Password berhasil diganti.');
    }
}