<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::all();
        $query = RekamTerapi::with(['jadwal.siswa', 'jadwal.guru.user']);

        if ($request->filled('siswa_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_siswa', $request->siswa_id);
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pelaksanaan', $request->bulan);
        }

        if ($request->filled('sesi')) {
            $query->where('nomor_sesi', $request->sesi);
        }

        $laporan = $query->orderBy('tanggal_pelaksanaan', 'asc')->get();
        $rataRataSkor = $laporan->avg('skor_grafik') ?? 0;

        return view('admin.laporan.index', compact('siswa', 'laporan', 'rataRataSkor'));
    }

    public function exportPdf(Request $request)
    {
        if (!$request->filled('siswa_id')) {
            return redirect()->route('admin.laporan.index')
                ->with('error', 'Pilih nama siswa dan klik tombol "Terapkan" terlebih dahulu!');
        }

        $dataSiswa = Siswa::findOrFail($request->siswa_id);
        $laporan = RekamTerapi::whereHas('jadwal', function($q) use ($request) {
            $q->where('id_siswa', $request->siswa_id);
        })
        ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pelaksanaan', $request->bulan))
        ->orderBy('tanggal_pelaksanaan', 'asc')
        ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf_template', [
            'laporan' => $laporan,
            'siswa' => $dataSiswa,
            'bulan' => $request->bulan
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Perkembangan_{$dataSiswa->nama_siswa}.pdf");
    }

    public function exportExcel(Request $request)
    {
        if (!$request->filled('siswa_id')) {
            return redirect()->route('admin.laporan.index')
                ->with('error', 'Wajib pilih siswa dan klik "Terapkan" sebelum export Excel!');
        }

        $siswa = Siswa::findOrFail($request->siswa_id);
        $laporan = RekamTerapi::with(['jadwal.guru.user'])
            ->whereHas('jadwal', fn($q) => $q->where('id_siswa', $request->siswa_id))
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pelaksanaan', $request->bulan))
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- 1. INSERT LOGO ---
        if (file_exists(public_path('img/logo.png'))) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo Provinsi');
            $drawing->setPath(public_path('img/logo.png'));
            $drawing->setHeight(80);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        // --- 2. KOP SURAT RESMI ---
        $sheet->setCellValue('A1', 'PEMERINTAH DAERAH PROVINSI JAWA BARAT');
        $sheet->setCellValue('A2', 'DINAS PENDIDIKAN');
        $sheet->setCellValue('A3', 'SEKOLAH LUAR BIASA NEGERI B GARUT');
        $sheet->setCellValue('A4', 'Alamat : Jalan RSU No. 62 Telp ( 0262 ) 233968 Ds. Sukakarya Kec. Tarogong Kidul');
        $sheet->setCellValue('A5', 'Email: slbnbgarutkeren@gmail.com / slbnb_garut@yahoo.com');
        
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A5:E5');

        $sheet->getStyle('A1:A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A3')->getFont()->setSize(14);
        $sheet->getStyle('A4:A5')->applyFromArray([
            'font' => ['italic' => true, 'size' => 9],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('A5:E5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);

        // --- 3. JUDUL LAPORAN ---
        $sheet->setCellValue('A7', 'LAPORAN PERKEMBANGAN TERAPI SISWA');
        $sheet->mergeCells('A7:E7');
        $sheet->getStyle('A7')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'underline' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // --- 4. INFO SISWA (DITAMBAH TINGKAT & KELAS) ---
        $sheet->setCellValue('A9', 'Nama Siswa:');
        $sheet->setCellValue('B9', $siswa->nama_siswa);
        $sheet->setCellValue('D9', 'Bulan:');
        $bulanText = $request->bulan ? \Carbon\Carbon::create(now()->year, $request->bulan, 1)->translatedFormat('F Y') : 'Semua Periode';
        $sheet->setCellValue('E9', $bulanText);

        $sheet->setCellValue('A10', 'NIS:');
        $sheet->setCellValue('B10', $siswa->nis);
        $sheet->setCellValue('D10', 'Kebutuhan Khusus:');
        $sheet->setCellValue('E10', $siswa->kebutuhan_khusus);

        // BARIS BARU UNTUK TINGKAT & KELAS
        $sheet->setCellValue('A11', 'Tingkat / Kelas:');
        $sheet->setCellValue('B11', $siswa->tingkat . ' / Kelas ' . $siswa->kelas);

        $sheet->getStyle('A9:A11')->getFont()->setBold(true);
        $sheet->getStyle('D9:D10')->getFont()->setBold(true);

        // --- 5. TABEL DATA (HEADER GESER KE BARIS 13) ---
        $headers = ['SESI', 'TANGGAL', 'SKOR (%)', 'HASIL KEMAJUAN', 'REKOMENDASI'];
        $sheet->fromArray($headers, NULL, 'A13');

        $styleHeaderTabel = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THICK]],
        ];
        $sheet->getStyle('A13:E13')->applyFromArray($styleHeaderTabel);

        // --- 6. LOOPING DATA ---
        $row = 14;
        foreach ($laporan as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('d M Y'));
            $sheet->setCellValue('C' . $row, $data->skor_grafik . '%');
            $sheet->setCellValue('D' . $row, $data->hasil_kemajuan);
            $sheet->setCellValue('E' . $row, $data->rekomendasi_lanjutan);

            $sheet->getStyle("A$row:E$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("D$row:E$row")->getAlignment()->setWrapText(true);
            $row++;
        }

        // Lebar Kolom
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(35);

        // --- 7. TANDA TANGAN ---
        $footerRow = $row + 2;
        $sheet->setCellValue('D' . $footerRow, 'Ditandatangani secara elektronik oleh :');
        $sheet->setCellValue('D' . ($footerRow + 1), 'KEPALA SEKOLAH');
        $sheet->setCellValue('D' . ($footerRow + 4), 'Dra. NIASUNIAWATI');
        $sheet->setCellValue('D' . ($footerRow + 5), 'PEMBINA TK.I, IV/b');

        $sheet->getStyle('D' . ($footerRow + 1) . ':D' . ($footerRow + 4))->getFont()->setBold(true);
        $sheet->getStyle('D' . $footerRow . ':E' . ($footerRow + 5))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        // --- 8. DOWNLOAD ---
        $fileName = "Laporan_Perkembangan_" . str_replace(' ', '_', $siswa->nama_siswa) . ".xlsx";
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $fileName .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}