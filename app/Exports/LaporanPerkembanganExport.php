<?php

namespace App\Exports;

use App\Models\RekamTerapi;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPerkembanganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $siswaId, $bulan;

    public function __construct($siswaId, $bulan) {
        $this->siswaId = $siswaId;
        $this->bulan = $bulan;
    }

    public function collection() {
        return RekamTerapi::with(['jadwal.siswa', 'jadwal.guru'])
            ->whereHas('jadwal', fn($q) => $q->where('id_siswa', $this->siswaId))
            ->when($this->bulan, fn($q) => $q->whereMonth('tanggal_pelaksanaan', $this->bulan))
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->get();
    }

    public function headings(): array {
        return [
            ['SLB NEGERI BAGIAN B GARUT'],
            ['LAPORAN PERKEMBANGAN TERAPI'],
            [''],
            ['Sesi', 'Tanggal', 'Nama Siswa', 'Skor Grafik', 'Hasil Kemajuan', 'Rekomendasi']
        ];
    }

    public function map($row): array {
        return [
            $row->nomor_sesi,
            $row->tanggal_pelaksanaan,
            $row->jadwal->siswa->nama_siswa,
            $row->skor_grafik . '%',
            $row->hasil_kemajuan,
            $row->rekomendasi_lanjutan,
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            1    => ['font' => ['bold' => true, 'size' => 16]],
            2    => ['font' => ['bold' => true, 'size' => 14]],
            4    => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E8F0']]],
        ];
    }
}
