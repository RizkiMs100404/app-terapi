<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Orangtua;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['orangtua.user', 'tahunAjaran']);

        // 1. Search Logic (Nama & NIS)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Jenis Kelamin
        if ($request->filled('jk')) {
            $query->where('jenis_kelamin', $request->jk);
        }

        // 3. Filter Tahun Ajaran
        if ($request->filled('ta')) {
            $query->where('id_tahun_ajaran', $request->ta);
        }

        // 4. Filter Tingkat (Tambahan Baru)
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $siswa = $query->latest()->paginate(10);
        $tahunAjaran = TahunAjaran::all();

        return view('admin.siswa.index', compact('siswa', 'tahunAjaran'));
    }

    public function create()
    {
        $orangtua = Orangtua::with('user')->get();
        $tahunAjaran = TahunAjaran::all();
        return view('admin.siswa.create', compact('orangtua', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_orangtua'     => 'required',
            'id_tahun_ajaran' => 'required',
            'nis'             => 'required|unique:siswa,nis',
            'nama_siswa'      => 'required|string|max:255',
            'kelas'           => 'required|string|max:50', // Validasi baru
            'tingkat'         => 'required|in:SDLB,SMPLB,SMALB', // Validasi baru
            'jenis_kelamin'   => 'required',
            'tanggal_lahir'   => 'required|date',
            'alamat_lengkap'  => 'required',
            'provinsi'        => 'required',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $request->nis . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_siswa', $filename);
            $data['foto'] = $filename;
        }

        Siswa::create($data);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $orangtua = Orangtua::with('user')->get();
        $tahunAjaran = TahunAjaran::all();
        return view('admin.siswa.edit', compact('siswa', 'orangtua', 'tahunAjaran'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'             => 'required|unique:siswa,nis,' . $siswa->id,
            'nama_siswa'      => 'required|string|max:255',
            'kelas'           => 'required|string|max:50', // Validasi baru
            'tingkat'         => 'required|in:SDLB,SMPLB,SMALB', // Validasi baru
            'jenis_kelamin'   => 'required',
            'id_orangtua'     => 'required',
            'id_tahun_ajaran' => 'required',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Logika Pengaman Wilayah (jika input wilayah kosong saat update)
        $data['provinsi']       = $request->provinsi ?: $siswa->provinsi;
        $data['kabupaten_kota'] = $request->kabupaten_kota ?: $siswa->kabupaten_kota;
        $data['kecamatan']      = $request->kecamatan ?: $siswa->kecamatan;
        $data['kelurahan']      = $request->kelurahan ?: $siswa->kelurahan;

        // Handle Update Foto
        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::exists('public/foto_siswa/' . $siswa->foto)) {
                Storage::delete('public/foto_siswa/' . $siswa->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $request->nis . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_siswa', $filename);
            $data['foto'] = $filename;
        } else {
            $data['foto'] = $siswa->foto;
        }

        $siswa->update($data);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto && Storage::exists('public/foto_siswa/' . $siswa->foto)) {
            Storage::delete('public/foto_siswa/' . $siswa->foto);
        }

        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }
}