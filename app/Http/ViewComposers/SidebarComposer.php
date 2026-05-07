<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        
        if ($user && $user->role === 'orangtua') {
            $ortu = $user->profilOrangtua()->with('siswa')->first();
            $daftar_anak = $ortu ? $ortu->siswa : collect([]);
            
            // Ambil anak yang lagi dipilih dari session
            $selectedId = session('selected_anak_id', optional($daftar_anak->first())->id);
            $anakAktif = $daftar_anak->where('id', $selectedId)->first();

            if ($anakAktif) {
                // Logic Format WA (Satu untuk semua halaman)
                $namaGuru = "Terapis";
                $nomorHp = "628123456789"; 

                $latestRekam = $anakAktif->rekamTerapi()->latest()->first();
                if ($latestRekam && $latestRekam->jadwal && $latestRekam->jadwal->guru) {
                    $guru = $latestRekam->jadwal->guru;
                    $namaGuru = $guru->user->name ?? 'Terapis';
                    $hp = preg_replace('/[^0-9]/', '', $guru->nomor_hp);
                    $nomorHp = str_starts_with($hp, '0') ? '62' . substr($hp, 1) : $hp;
                }

                $pesanWA = "Halo Ibu/Bapak $namaGuru, saya orang tua dari murid:\n\n" .
                           "*Nama:* " . $anakAktif->nama_siswa . "\n" .
                           "*Kelas:* " . ($anakAktif->kelas ?? '-') . "\n" .
                           "*Tingkat:* " . ($anakAktif->tingkat ?? '-') . "\n\n" .
                           "(Uraikan kendala ibu/bapa)";

                // Lempar variabel ke sidebar.blade.php
                $view->with([
                    'daftar_anak' => $daftar_anak,
                    'nama_anak' => $anakAktif->nama_siswa,
                    'link_wa' => "https://wa.me/" . $nomorHp . "?text=" . urlencode($pesanWA)
                ]);
            }
        }
    }
}