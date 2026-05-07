<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if (!$user->profilOrangtua) {
            return redirect()->route('orangtua.dashboard')->with('error', 'Profil orang tua belum diatur.');
        }

        // SESUAIKAN DISINI: Pakai 'selected_anak_id' sesuai SidebarComposer
        $id_anak = session('selected_anak_id');
        
        if (!$id_anak) {
            $anakPertama = Siswa::where('id_orangtua', $user->profilOrangtua->id)->first();
            if ($anakPertama) {
                session(['selected_anak_id' => $anakPertama->id]);
                $id_anak = $anakPertama->id;
            } else {
                return redirect()->route('orangtua.dashboard')->with('error', 'Data anak tidak ditemukan.');
            }
        }

        $siswa = Siswa::where('id', $id_anak)
                      ->where('id_orangtua', $user->profilOrangtua->id)
                      ->firstOrFail();

        return view('orangtua.siswa.edit', compact('siswa'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        // SESUAIKAN DISINI JUGA
        $id_anak = session('selected_anak_id');
        
        $siswa = Siswa::where('id', $id_anak)
                      ->where('id_orangtua', $user->profilOrangtua->id)
                      ->firstOrFail();

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat_lengkap' => 'required',
            'kebutuhan_khusus' => 'required',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::exists('public/foto_siswa/' . $siswa->foto)) {
                Storage::delete('public/foto_siswa/' . $siswa->foto);
            }

            $file = $request->file('foto');
            $nama_foto = time() . '_' . $siswa->nis . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_siswa', $nama_foto);
            $data['foto'] = $nama_foto;
        }

        $siswa->update($data);

        return back()->with('success', 'Data profil anak berhasil diperbarui!');
    }
}