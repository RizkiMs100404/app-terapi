<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perkembangan - {{ $siswa->nama_siswa }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.2; margin: 0; padding: 0; }
        
        /* Kop Surat Style */
        .kop-surat { position: relative; border-bottom: 4px solid #000; padding-bottom: 2px; margin-bottom: 2px; text-align: center; }
        .kop-surat .line-thin { border-bottom: 1px solid #000; margin-top: 2px; }
        .logo-prov { position: absolute; left: 0; top: 10px; width: 80px; }
        .kop-text { margin-left: 60px; margin-right: 60px; }
        .kop-text h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        .kop-text h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        .kop-text h3 { margin: 0; font-size: 18pt; font-weight: bold; }
        .kop-text p { margin: 2px 0; font-size: 8.5pt; font-style: italic; }
        .kop-text .email { font-style: normal; color: #2563eb; text-decoration: underline; }

        .title-laporan { text-align: center; margin-top: 20px; text-decoration: underline; font-weight: bold; font-size: 12pt; text-transform: uppercase; }

        .info-siswa { width: 100%; margin-top: 20px; margin-bottom: 15px; font-size: 10pt; border: none; }
        .info-siswa td { padding: 2px 0; border: none; vertical-align: top; }

        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 9pt; }
        table.data-table th { background-color: #f1f5f9; border: 1px solid #000; padding: 8px; text-transform: uppercase; }
        table.data-table td { border: 1px solid #000; padding: 8px; vertical-align: top; }

        .skor-box { font-weight: bold; color: #1e40af; text-align: center; }
        
        /* Footer Tanda Tangan */
        .footer-container { margin-top: 40px; width: 100%; }
        .ttd-box { float: right; width: 250px; text-align: left; font-size: 10pt; border: 1px solid #ccc; padding: 10px; border-radius: 15px; }
        .ttd-box p { margin: 2px 0; }
        .qr-placeholder { float: left; width: 50px; height: 50px; margin-right: 10px; border: 1px solid #eee; }
    </style>
</head>
<body>
    <!-- KOP SURAT -->
    <div class="kop-surat">
        <img src="{{ public_path('img/logo.png') }}" class="logo-prov">
        <div class="kop-text">
            <h1>PEMERINTAH DAERAH PROVINSI JAWA BARAT</h1>
            <h2>DINAS PENDIDIKAN</h2>
            <h3>SEKOLAH LUAR BIASA NEGERI B GARUT</h3>
            <p>Alamat : Jalan RSU No. 62 Telp ( 0262 ) 233968 Ds. Sukakarya Kec. Tarogong Kidul</p>
            <p>Email: <span class="email">slbnbgarutkeren@gmail.com</span> / <span class="email">slbnb_garut@yahoo.com</span></p>
        </div>
        <div class="line-thin"></div>
    </div>

    <div class="title-laporan">LAPORAN PERKEMBANGAN TERAPI SISWA</div>

    <table class="info-siswa">
        <tr>
            <td width="18%">Nama Siswa</td>
            <td width="40%">: <strong>{{ $siswa->nama_siswa }}</strong></td>
            <td width="15%">Tingkat</td>
            <td>: {{ $siswa->tingkat }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: {{ $siswa->nis }}</td>
            <td>Kelas</td>
            <td>: {{ $siswa->kelas }}</td>
        </tr>
        <tr>
            <td>Kebutuhan Khusus</td>
            <td>: {{ $siswa->kebutuhan_khusus }}</td>
            <td>Bulan</td>
            <td>: {{ request('bulan') ? \Carbon\Carbon::create(now()->year, request('bulan'), 1)->translatedFormat('F Y') : 'Semua Periode' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Skor</th>
                <th>Hasil Kemajuan</th>
                <th>Rekomendasi Lanjutan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $l)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($l->tanggal_pelaksanaan)->translatedFormat('d M Y') }}</td>
                <td class="skor-box">{{ $l->skor_grafik }}%</td>
                <td>{{ $l->hasil_kemajuan }}</td>
                <td>{{ $l->rekomendasi_lanjutan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Data laporan belum tersedia untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-container">
        <div class="ttd-box">
            <p style="font-size: 8pt;">Ditandatangani secara elektronik oleh :</p>
            <p><strong>KEPALA SEKOLAH</strong></p>
            <br><br>
            <p><strong>Dra. NIASUNIAWATI</strong></p>
            <p>PEMBINA TK.I, IV/b</p>
        </div>
    </div>
</body>
</html>