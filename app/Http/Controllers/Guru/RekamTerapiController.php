<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalTerapi;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekamTerapiController extends Controller
{
    /**
     * Tampilkan form input hasil terapi
     */
    public function create($id_jadwal)
    {
        // Ambil data jadwal beserta siswanya
        $jadwal = JadwalTerapi::with('siswa')->findOrFail($id_jadwal);

        // LOGIKA OTOMATIS SESI:
        // Menghitung berapa kali siswa ini sudah melakukan rekam terapi (lintas jadwal)
        $nomorSesi = RekamTerapi::whereHas('jadwal', function($q) use ($jadwal) {
            $q->where('id_siswa', $jadwal->id_siswa);
        })->count() + 1;

        return view('guru.rekam-terapi.create', compact('jadwal', 'nomorSesi'));
    }

    /**
     * Simpan data hasil terapi baru
     */
    public function store(Request $request)
    {
        // Validasi Ketat
        $request->validate([
            'id_jadwal'             => 'required|exists:jadwal_terapi,id',
            'tanggal_pelaksanaan'   => 'required|date',
            'nomor_sesi'            => 'required|integer',
            'hasil_kemajuan'        => 'required|in:Menurun,Tetap,Meningkat,Meningkat Pesat', // Validasi Enum
            'catatan_terapis'       => 'required|string',
            'rekomendasi_lanjutan'  => 'nullable|string',
            'skor_grafik'           => 'required|integer|min:0|max:100',
            'status_kehadiran'      => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'file_lampiran'         => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        try {
            $data = $request->all();

            // Handle upload file lampiran
            if ($request->hasFile('file_lampiran')) {
                $file = $request->file('file_lampiran');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('lampiran_terapi', $filename, 'public');
                $data['file_lampiran'] = $path;
            }

            // Simpan data
            RekamTerapi::create($data);

            return redirect()->route('guru.jadwal.index')
                             ->with('success', 'Laporan sesi terapi berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Tampilkan form edit hasil terapi
     */
    public function edit($id)
    {
        // Load relasi agar nama siswa muncul di view edit
        $rekamTerapi = RekamTerapi::with('jadwal.siswa')->findOrFail($id);
        return view('guru.rekam-terapi.edit', compact('rekamTerapi'));
    }

    /**
     * Update data hasil terapi
     */
    public function update(Request $request, $id)
    {
        $rekamTerapi = RekamTerapi::findOrFail($id);

        $request->validate([
            'tanggal_pelaksanaan'   => 'required|date',
            'skor_grafik'           => 'required|integer|min:0|max:100',
            'hasil_kemajuan'        => 'required|in:Menurun,Tetap,Meningkat,Meningkat Pesat',
            'status_kehadiran'      => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'catatan_terapis'       => 'required|string',
            'rekomendasi_lanjutan'  => 'nullable|string',
            'file_lampiran'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Pastikan mimes sesuai kebutuhan
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('file_lampiran')) {
                // 1. Hapus file lama jika ada
                if ($rekamTerapi->file_lampiran && Storage::disk('public')->exists($rekamTerapi->file_lampiran)) {
                    Storage::disk('public')->delete($rekamTerapi->file_lampiran);
                }

                // 2. Upload file baru
                $file = $request->file('file_lampiran');
                $filename = time() . '_' . $file->getClientOriginalName();
                // Simpan ke folder public/lampiran_terapi
                $path = $file->storeAs('lampiran_terapi', $filename, 'public');

                // 3. Masukkan path baru ke array data
                $data['file_lampiran'] = $path;
            } else {
                // Jika tidak upload foto baru, tetap pakai path foto yang lama
                $data['file_lampiran'] = $rekamTerapi->file_lampiran;
            }

            $rekamTerapi->update($data);

            return redirect()->route('guru.jadwal.index')
                             ->with('success', 'Hasil terapi berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function history(Request $request)
    {
        // 1. Safety Check Relasi
        if (!auth()->user()->guruTerapis) {
            return redirect()->back()->with('error', 'Otoritas Guru Terapis tidak valid.');
        }

        $guruId = auth()->user()->guruTerapis->id;

        // 2. Base Query dengan Eager Loading
        $query = RekamTerapi::with(['jadwal.siswa'])
            ->whereHas('jadwal', function($q) use ($guruId) {
                $q->where('id_guru', $guruId);
            });

        // 3. Search Logic yang Lebih Luas
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('jadwal.siswa', function($s) use ($search) {
                    $s->where('nama_siswa', 'like', "%{$search}%");
                })
                ->orWhere('nomor_sesi', 'like', "%{$search}%")
                ->orWhere('hasil_kemajuan', 'like', "%{$search}%")
                ->orWhere('status_kehadiran', 'like', "%{$search}%");
            });
        }

        // 4. Sort & Paginate
        // Gunakan 12 atau 10 agar pas dengan grid jika nanti mau ganti layout
        $riwayat = $query->latest('tanggal_pelaksanaan')
                        ->latest('created_at')
                        ->paginate(10);

        return view('guru.rekam-terapi.history', compact('riwayat'));
    }
}
