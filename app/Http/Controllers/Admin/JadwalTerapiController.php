<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalTerapi;
use App\Models\Siswa;
use App\Models\GuruTerapis;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalTerapiController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalTerapi::with(['siswa', 'guru.user', 'tahunAjaran']);

        // 1. Mapping Hari Indonesia
        $mapHari = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];

        // 2. Filter Nama Siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }

        // 3. LOGIKA FILTER TANGGAL -> HARI
        $tanggalAktif = null;
        if ($request->filled('tanggal')) {
            $tanggalAktif = $request->tanggal;
            $hariInggris = Carbon::parse($tanggalAktif)->format('l');
            $hariDariTanggal = $mapHari[$hariInggris];

            // Filter query berdasarkan hari dari tanggal tersebut
            $query->where('hari', $hariDariTanggal);
        }
        // Filter Berdasarkan Nama Hari Manual (jika masih pakai dropdown hari)
        elseif ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // 4. Sorting & Pagination
        $jadwal = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                        ->orderBy('jam_mulai', 'asc')
                        ->paginate(9)
                        ->withQueryString(); // Agar filter tidak hilang saat pindah page

        return view('admin.jadwal.index', compact('jadwal', 'tanggalAktif'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        // Load relasi user agar nama guru muncul di dropdown
        $guru = GuruTerapis::with('user')->where('status_kerja', 'Aktif')->get();
        $tahunAjaran = TahunAjaran::orderBy('status_aktif', 'desc')->get();

        // Ambil data enum dari Model agar sinkron
        $hari = JadwalTerapi::listHari();
        $pilihanKeahlian = JadwalTerapi::listJenisTerapi();

        return view('admin.jadwal.create', compact('siswa', 'guru', 'tahunAjaran', 'hari', 'pilihanKeahlian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_guru' => 'required|exists:guru_terapis,id',
            'id_tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis_terapi' => 'required',
        ]);

        JadwalTerapi::create($request->all());
        return redirect()->route('jadwal-terapi.index')->with('success', 'Jadwal berhasil dijadwalkan!');
    }

    public function edit($id)
    {
        $jadwal = JadwalTerapi::findOrFail($id);
        $siswa = Siswa::all();
        // Tetap munculkan guru meskipun status non-aktif jika sudah terlanjur ada di jadwal
        $guru = GuruTerapis::with('user')->get();
        $tahunAjaran = TahunAjaran::all();

        // Ambil data enum dari Model
        $hari = JadwalTerapi::listHari();
        $pilihanKeahlian = JadwalTerapi::listJenisTerapi();

        return view('admin.jadwal.edit', compact('jadwal', 'siswa', 'guru', 'tahunAjaran', 'hari', 'pilihanKeahlian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_guru' => 'required',
            'id_tahun_ajaran' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis_terapi' => 'required',
        ]);

        $jadwal = JadwalTerapi::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('jadwal-terapi.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        JadwalTerapi::destroy($id);
        return redirect()->route('jadwal-terapi.index')->with('success', 'Jadwal telah dihapus!');
    }
}
