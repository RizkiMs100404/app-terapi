<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perkembangan - {{ $siswa->nama_siswa }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .header h2 { margin: 0; font-size: 14pt; color: #2563eb; }
        .header p { margin: 2px; font-size: 9pt; italic; }

        .info-siswa { width: 100%; margin-bottom: 20px; font-size: 10pt; }
        .info-siswa td { padding: 3px 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 9pt; }
        th { background-color: #f1f5f9; border: 1px solid #cbd5e1; padding: 10px; text-transform: uppercase; }
        td { border: 1px solid #cbd5e1; padding: 8px; vertical-align: top; }

        .skor-box { font-weight: bold; color: #1e40af; text-align: center; }
        .footer { margin-top: 30px; float: right; width: 200px; text-align: center; font-size: 10pt; }
        .signature { margin-top: 60px; border-top: 1px solid #000; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SLB NEGERI BAGIAN B GARUT</h1>
        <h2>LAPORAN PERKEMBANGAN TERAPI SISWA</h2>
        <p>Jl. Pembangunan No.91, Tarogong Kidul, Kec. Tarogong Kidul, Kabupaten Garut</p>
    </div>

    <table class="info-siswa">
    <tr>
        <td width="15%"><strong>Nama Siswa</strong></td>
        <td width="35%">: {{ $siswa->nama_siswa }}</td>
        <td width="15%"><strong>Bulan</strong></td>
        <td width="35%">: {{ request('bulan') ? \Carbon\Carbon::create(now()->year, request('bulan'), 1)->translatedFormat('F Y') : 'Semua Periode' }}</td>
    </tr>
    <tr>
        <td><strong>NIS</strong></td>
        <td>: {{ $siswa->nis }}</td>
        <td><strong>Kebutuhan Khusus</strong></td>
        <td>: {{ $siswa->kebutuhan_khusus }}</td>
    </tr>
    <tr>
        <td><strong>Tanggal Lahir</strong></td>
        <td>: {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

    <table>
        <thead>
            <tr>
                <th width="8%">Sesi</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Skor</th>
                <th>Hasil Kemajuan</th>
                <th>Rekomendasi Lanjutan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $l)
            <tr>
                <td style="text-align: center;">{{ $l->nomor_sesi }}</td>
                <td>{{ \Carbon\Carbon::parse($l->tanggal_pelaksanaan)->translatedFormat('d M Y') }}</td>
                <td class="skor-box">{{ $l->skor_grafik }}%</td>
                <td>{{ $l->hasil_kemajuan }}</td>
                <td>{{ $l->rekomendasi_lanjutan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Garut, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <div class="signature">
            <p>Kepala Sekolah SLBN B Garut</p>
        </div>
    </div>
</body>
</html>
