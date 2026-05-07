<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran; // Pastikan modelnya sudah di-import
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // 1. Menampilkan Tabel (Index)
    public function index(Request $request)
{
    // Ambil input dari request
    $search = $request->input('search');
    $filter_semester = $request->input('filter_semester');

    // Query dengan penanganan Filter & Search
    $dataTA = TahunAjaran::query()
        ->when($search, function ($query, $search) {
            return $query->where('rentang_tahun', 'like', "%{$search}%");
        })
        ->when($filter_semester, function ($query, $filter_semester) {
            return $query->where('semester', $filter_semester);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10) // Bagus dikasih pagination kalau data mulai banyak
        ->withQueryString(); // Agar link pagination tidak hilang saat search

    return view('admin.tahun_ajaran.index', compact('dataTA'));
}

    // 2. Menampilkan Halaman Form Tambah (Create) - INI YANG TADI ERROR
    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    // 3. Proses Simpan Data ke Database (Store)
    public function store(Request $request)
    {
        $request->validate([
            'rentang_tahun' => 'required',
            'semester' => 'required',
        ]);

        // Jika status_aktif dicentang, matikan TA yang lain dulu (Logika SIAKAD)
        if ($request->has('status_aktif')) {
            TahunAjaran::where('status_aktif', 1)->update(['status_aktif' => 0]);
        }

        TahunAjaran::create([
            'rentang_tahun' => $request->rentang_tahun,
            'semester' => $request->semester,
            'status_aktif' => $request->has('status_aktif') ? 1 : 0,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran baru berhasil ditambahkan!');
    }

    // 4. Menampilkan Halaman Form Edit (Edit) - INI JUGA HARUS ADA
    public function edit($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        return view('admin.tahun_ajaran.edit', compact('ta'));
    }

    // 5. Proses Update Data (Update)
    public function update(Request $request, $id)
    {
        $ta = TahunAjaran::findOrFail($id);

        if ($request->has('status_aktif')) {
            TahunAjaran::where('status_aktif', 1)->update(['status_aktif' => 0]);
        }

        $ta->update([
            'rentang_tahun' => $request->rentang_tahun,
            'semester' => $request->semester,
            'status_aktif' => $request->has('status_aktif') ? 1 : 0,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data periode berhasil diperbarui!');
    }

        public function toggleStatus($id)
        {
            // Matikan semua yang aktif dulu karena SIAKAD cuma boleh 1 yang aktif
            TahunAjaran::where('id', '!=', $id)->update(['status_aktif' => 0]);

            $ta = TahunAjaran::findOrFail($id);
            $ta->status_aktif = !$ta->status_aktif;
            $ta->save();

            return response()->json(['success' => true, 'new_status' => $ta->status_aktif]);
        }

    // 6. Hapus Data (Destroy)
    public function destroy($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $ta->delete();
        return redirect()->route('tahun-ajaran.index')->with('success', 'Periode berhasil dihapus!');
    }
}
