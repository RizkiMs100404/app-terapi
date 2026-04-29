<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('jadwal_terapi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru_terapis')->onDelete('cascade');
            $table->foreignId('id_tahun_ajaran')->constrained('tahun_ajaran');

            // Disamakan dengan $pilihanKeahlian di Controller
            $table->enum('jenis_terapi', [
                'Wicara',
                'Okupasi',
                'Perilaku',
                'Sensori Integrasi',
                'Fisioterapi',
                'Psikologi'
            ]);

            // Menambahkan hari Minggu
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);

            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->text('keterangan')->nullable();
            $table->string('ruang_terapi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_terapi');
    }
};
