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

    // 1. KOP SURAT (Header)
    $sheet->setCellValue('A1', 'SLB NEGERI BAGIAN B GARUT');
    $sheet->setCellValue('A2', 'LAPORAN PERKEMBANGAN TERAPI SISWA');
    $sheet->setCellValue('A3', 'Jl. Pembangunan No.91, Tarogong Kidul, Kec. Tarogong Kidul, Kabupaten Garut');
    $sheet->mergeCells('A1:E1');
    $sheet->mergeCells('A2:E2');
    $sheet->mergeCells('A3:E3');

    $sheet->getStyle('A1:A2')->applyFromArray([
        'font' => ['bold' => true, 'size' => 14],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ]);
    $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // 2. INFO SISWA (Sesuai PDF)
    // Baris 1
    $sheet->setCellValue('A5', 'Nama Siswa:');
    $sheet->setCellValue('B5', $siswa->nama_siswa);
    $sheet->setCellValue('D5', 'Bulan:');
    $bulanText = $request->bulan ? \Carbon\Carbon::create(now()->year, $request->bulan, 1)->translatedFormat('F Y') : 'Semua Periode';
    $sheet->setCellValue('E5', $bulanText);

    // Baris 2
    $sheet->setCellValue('A6', 'NIS:');
    $sheet->setCellValue('B6', $siswa->nis);
    $sheet->setCellValue('D6', 'Kebutuhan Khusus:');
    $sheet->setCellValue('E6', $siswa->kebutuhan_khusus);

    // Baris 3 (Tanggal Lahir)
    $sheet->setCellValue('A7', 'Tgl Lahir:');
    $tglLahir = Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y');
    $sheet->setCellValue('B7', $tglLahir);

    $sheet->getStyle('A5:A7')->getFont()->setBold(true);
    $sheet->getStyle('D5:D6')->getFont()->setBold(true);

    // 3. TABEL DATA
    $headers = ['SESI', 'TANGGAL', 'SKOR (%)', 'HASIL KEMAJUAN', 'REKOMENDASI'];
    $sheet->fromArray($headers, NULL, 'A9');

    $styleHeaderTabel = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A9:E9')->applyFromArray($styleHeaderTabel);

    // 4. LOOPING DATA
    $row = 10;
    foreach ($laporan as $data) {
        $sheet->setCellValue('A' . $row, $data->nomor_sesi);
        $sheet->setCellValue('B' . $row, Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('d M Y'));
        $sheet->setCellValue('C' . $row, $data->skor_grafik . '%');
        $sheet->setCellValue('D' . $row, $data->hasil_kemajuan);
        $sheet->setCellValue('E' . $row, $data->rekomendasi_lanjutan);

        $sheet->getStyle("A$row:E$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("D$row:E$row")->getAlignment()->setWrapText(true);
        $row++;
    }

    // Auto size kolom
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 5. TANDA TANGAN (Footer)
    $footerRow = $row + 2;
    $sheet->setCellValue('E' . $footerRow, 'Garut, ' . date('d F Y'));
    $sheet->setCellValue('E' . ($footerRow + 1), 'Kepala Sekolah,');
    $sheet->setCellValue('E' . ($footerRow + 4), 'Kepala Sekolah SLBN B Garut');
    $sheet->getStyle('E' . ($footerRow + 4))->getFont()->setBold(true);
    $sheet->getStyle('E' . ($footerRow + 4))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

    // 6. DOWNLOAD
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
