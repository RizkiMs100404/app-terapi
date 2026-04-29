<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Orangtua;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
   public function index(Request $request)
{
    $query = Siswa::with(['orangtua.user', 'tahunAjaran']);

    // 1. Search Logic (Dikelompokkan agar OR tidak merusak filter AND lainnya)
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
            'id_orangtua' => 'required',
            'id_tahun_ajaran' => 'required',
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required',
            'provinsi' => 'required', // Wajib ada saat bikin baru
        ]);

        Siswa::create($request->all());
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
        // 1. Validasi data yang pasti ada
        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'id_orangtua' => 'required',
            'id_tahun_ajaran' => 'required',
        ]);

        // 2. Ambil semua input
        $data = $request->all();

        /**
         * 3. LOGIKA PENGAMAN WILAYAH
         * Jika input wilayah kosong (karena user tidak mengubah dropdown),
         * maka kita isi kembali dengan data yang sudah ada di database ($siswa->...)
         */
        $data['provinsi']       = $request->provinsi ?: $siswa->provinsi;
        $data['kabupaten_kota'] = $request->kabupaten_kota ?: $siswa->kabupaten_kota;
        $data['kecamatan']      = $request->kecamatan ?: $siswa->kecamatan;
        $data['kelurahan']      = $request->kelurahan ?: $siswa->kelurahan;

        // 4. Update data ke database
        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
