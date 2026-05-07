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
        // Memastikan relasi siswa ikut terangkut untuk menampilkan tingkat & kelas
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

        // 3. Filter Berdasarkan Tingkat (New: Request dari Abang)
        if ($request->filled('tingkat')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        // 4. LOGIKA FILTER TANGGAL -> HARI
        $tanggalAktif = null;
        if ($request->filled('tanggal')) {
            $tanggalAktif = $request->tanggal;
            $hariInggris = Carbon::parse($tanggalAktif)->format('l');
            $hariDariTanggal = $mapHari[$hariInggris];

            // Filter query berdasarkan hari dari tanggal tersebut
            $query->where('hari', $hariDariTanggal);
        }
        // Filter Berdasarkan Nama Hari Manual
        elseif ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // 5. Sorting Berdasarkan Urutan Hari & Jam
        $jadwal = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                        ->orderBy('jam_mulai', 'asc')
                        ->paginate(9)
                        ->withQueryString(); 

        return view('admin.jadwal.index', compact('jadwal', 'tanggalAktif'));
    }

    public function create()
    {
        // Mengambil semua siswa untuk dropdown
        $siswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        
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
        $siswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        
        // Guru tetap muncul meskipun non-aktif untuk keperluan edit data lama
        $guru = GuruTerapis::with('user')->get();
        $tahunAjaran = TahunAjaran::all();

        $hari = JadwalTerapi::listHari();
        $pilihanKeahlian = JadwalTerapi::listJenisTerapi();

        return view('admin.jadwal.edit', compact('jadwal', 'siswa', 'guru', 'tahunAjaran', 'hari', 'pilihanKeahlian'));
    }

    public function show($id)
    {
        $jadwal = JadwalTerapi::with(['siswa', 'guru.user', 'tahunAjaran'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function update(Request $request, $id)
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