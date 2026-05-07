<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\JadwalTerapi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $selectedAnakId = session('selected_anak_id');
        if (!$selectedAnakId) {
            return redirect()->route('orangtua.dashboard')->with('error', 'Silakan pilih data anak terlebih dahulu.');
        }

        $anak = Siswa::findOrFail($selectedAnakId);
        
        // --- CONFIGURASI HARI INDONESIA ---
        Carbon::setLocale('id'); 
        $tanggalAktif = $request->get('tanggal', date('Y-m-d'));
        $hariIndo = Carbon::parse($tanggalAktif)->isoFormat('dddd'); 

        // Query Jadwal
        $jadwalRaw = JadwalTerapi::with(['guru.user', 'rekamTerapi' => function($q) use ($tanggalAktif) {
                $q->where('tanggal_pelaksanaan', $tanggalAktif);
            }])
            ->where('id_siswa', $selectedAnakId)
            ->where('hari', $hariIndo) 
            ->orderBy('jam_mulai', 'asc') 
            ->get();

        // Logic Sesi Otomatis
        $jadwal = $jadwalRaw->map(function ($item, $key) {
            $item->nomor_sesi = "Sesi " . ($key + 1);
            return $item;
        });

        return view('orangtua.jadwal.index', compact(
            'jadwal', 
            'anak', 
            'hariIndo', 
            'tanggalAktif'
        ));
    }

    public function show($id)
    {
        $selectedAnakId = session('selected_anak_id');
        if (!$selectedAnakId) return redirect()->route('orangtua.dashboard');
        
        $anak = Siswa::findOrFail($selectedAnakId);

        // Security: Pastikan jadwal milik anak yang dipilih
        $jadwal = JadwalTerapi::with(['siswa', 'guru.user', 'rekamTerapi'])
            ->where('id_siswa', $selectedAnakId)
            ->findOrFail($id);

        // Cari Nomor Sesi
        $urutanSesi = JadwalTerapi::where('id_siswa', $selectedAnakId)
            ->where('hari', $jadwal->hari)
            ->orderBy('jam_mulai', 'asc')
            ->pluck('id')
            ->toArray();

        $index = array_search($jadwal->id, $urutanSesi);
        $jadwal->nomor_sesi = "Sesi " . ($index + 1);

        return view('orangtua.jadwal.show', compact('jadwal', 'anak'));
    }

    public function history(Request $request)
{
    $selectedAnakId = session('selected_anak_id');
    if (!$selectedAnakId) return redirect()->route('orangtua.dashboard');

    $anak = Siswa::findOrFail($selectedAnakId);

    // Eager Loading: Ambil data rekam terapi beserta jadwal, guru, dan user-nya
    $query = \App\Models\RekamTerapi::with(['jadwal.guru.user'])
        ->whereHas('jadwal', function($q) use ($selectedAnakId) {
            $q->where('id_siswa', $selectedAnakId);
        });

    // Filter Pencarian: Nama Guru, Hasil Kemajuan, Catatan, atau Rekomendasi
    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function($q) use ($searchTerm) {
            $q->where('hasil_kemajuan', 'like', $searchTerm)
                ->orWhere('catatan_terapis', 'like', $searchTerm)
                ->orWhere('rekomendasi_lanjutan', 'like', $searchTerm)
                ->orWhere('nomor_sesi', 'like', $searchTerm) // Tambah search by nomor sesi juga
                ->orWhereHas('jadwal.guru.user', function($u) use ($searchTerm) {
                    $u->where('name', 'like', $searchTerm);
                });
        });
    }

    // Urutkan berdasarkan tanggal terbaru dan nomor sesi terbesar
    $history = $query->orderBy('tanggal_pelaksanaan', 'desc')
                     ->orderBy('nomor_sesi', 'desc')
                     ->paginate(10)
                     ->withQueryString(); // Biar pagination tetep bawa kata kunci search

    return view('orangtua.jadwal.history', compact('history', 'anak'));
}
}