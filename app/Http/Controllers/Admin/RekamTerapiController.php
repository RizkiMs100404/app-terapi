<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekamTerapiController extends Controller
{
    /**
     * Menampilkan daftar semua hasil terapi (Admin Panel)
     */
    public function index(Request $request)
    {
        // Eager load relasi untuk menghindari N+1 query
        $query = RekamTerapi::with(['jadwal.siswa', 'jadwal.guru.user']);

        // Filter 1: Pencarian Nama Siswa
        if ($request->filled('search')) {
            $query->whereHas('jadwal.siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }

        // Filter 2: Status Kehadiran (Hadir, Izin, Sakit, dsb)
        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }

        // Filter 3: Hasil Kemajuan (Enum: Meningkat, Tetap, Menurun, dsb)
        if ($request->filled('kemajuan')) {
            $query->where('hasil_kemajuan', $request->kemajuan);
        }

        // Filter 4: Tanggal Pelaksanaan Spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pelaksanaan', $request->tanggal);
        }

        // Urutkan berdasarkan tanggal terbaru
        $rekamTerapi = $query->latest('tanggal_pelaksanaan')->paginate(10);

        return view('admin.rekam-terapi.index', compact('rekamTerapi'));
    }

    /**
     * Menampilkan detail lengkap satu record terapi
     */
    public function show($id)
    {
        $rekam = RekamTerapi::with([
            'jadwal.siswa',
            'jadwal.guru.user',
            'jadwal.tahunAjaran'
        ])->findOrFail($id);

        return view('admin.rekam-terapi.show', compact('rekam'));
    }

    /**
     * Menghapus record hasil terapi beserta file lampirannya
     */
    public function destroy($id)
    {
        try {
            $rekam = RekamTerapi::findOrFail($id);

            // Cek dan hapus file fisik di storage agar tidak memenuhi server
            if ($rekam->file_lampiran && Storage::disk('public')->exists($rekam->file_lampiran)) {
                Storage::disk('public')->delete($rekam->file_lampiran);
            }

            $rekam->delete();

            // Pastikan redirect menggunakan prefix admin. sesuai web.php yang baru
            return redirect()->route('admin.rekam-terapi.index')
                             ->with('success', 'Data rekam terapi dan lampiran berhasil dihapus secara permanen.');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
