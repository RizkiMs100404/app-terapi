<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data profil guru
        $guru = Auth::user()->guruTerapis;

        if (!$guru) {
            return redirect()->back()->with('error', 'Profil Guru tidak ditemukan.');
        }

        // 2. Mapping Hari Indonesia
        $mapHari = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];

        // 3. Tentukan Tanggal & Hari Acuan
        $tanggalDipilih = $request->filled('tanggal') ? $request->tanggal : Carbon::now()->format('Y-m-d');
        $hariInggris = Carbon::parse($tanggalDipilih)->format('l');
        $hariAcuan = $mapHari[$hariInggris];

        // 4. Mulai Query
        $query = JadwalTerapi::with(['siswa', 'tahunAjaran', 'rekamTerapi'])
            ->where('id_guru', $guru->id);

        // Filter: Pencarian (Nama/NISN)
        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        // Filter: Tingkat (SDLB/SMPLB/SMALB)
        if ($request->filled('tingkat')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        // Filter: Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Filter: Hari (Jika tidak sedang mencari nama, default ke hari yang dipilih)
        if (!$request->filled('search')) {
            $query->where('hari', $hariAcuan);
        }

        // 5. Eksekusi
        $jadwal = $query->orderBy('jam_mulai', 'asc')->get();

        return view('guru.jadwal.index', [
            'jadwal' => $jadwal,
            'hariIni' => $hariAcuan,
            'tanggalAktif' => $tanggalDipilih 
        ]);
    }

    /**
     * Menampilkan detail jadwal khusus untuk dashboard guru
     */
    public function show($id)
    {
        $guru = Auth::user()->guruTerapis;

        // Ambil data jadwal dengan relasi, pastikan milik guru yang sedang login
        $jadwal = JadwalTerapi::with(['siswa', 'guru.user', 'tahunAjaran'])
            ->where('id_guru', $guru->id)
            ->findOrFail($id);

        return view('guru.jadwal.show', compact('jadwal'));
    }
}