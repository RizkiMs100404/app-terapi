<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .title { font-size: 16pt; font-weight: bold; text-align: center; }
        .school { font-size: 14pt; font-weight: bold; text-align: center; color: #2563eb; }
        .table { border-collapse: collapse; width: 100%; }
        .table th { border: 1px solid #000; background-color: #f2f2f2; font-weight: bold; }
        .table td { border: 1px solid #000; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="5" class="title">SLB NEGERI BAGIAN B GARUT</td>
        </tr>
        <tr>
            <td colspan="5" class="school">LAPORAN PERKEMBANGAN TERAPI SISWA</td>
        </tr>
        <tr><td></td></tr>
        <tr>
            <td><strong>Nama Siswa:</strong></td>
            <td colspan="4">{{ $siswa->nama_siswa }}</td>
        </tr>
        <tr>
            <td><strong>NIS:</strong></td>
            <td colspan="4">{{ $siswa->nis }}</td>
        </tr>
        <tr><td></td></tr>
        <thead>
            <tr class="table">
                <th style="background-color: #d1d5db;">Sesi</th>
                <th style="background-color: #d1d5db;">Tanggal</th>
                <th style="background-color: #d1d5db;">Skor (%)</th>
                <th style="background-color: #d1d5db;">Hasil Kemajuan</th>
                <th style="background-color: #d1d5db;">Rekomendasi Lanjutan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $l)
            <tr>
                <td class="text-center">{{ $l->nomor_sesi }}</td>
                <td>{{ \Carbon\Carbon::parse($l->tanggal_pelaksanaan)->translatedFormat('d-m-Y') }}</td>
                <td class="text-center">{{ $l->skor_grafik }}%</td>
                <td>{{ $l->hasil_kemajuan }}</td>
                <td>{{ $l->rekomendasi_lanjutan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
