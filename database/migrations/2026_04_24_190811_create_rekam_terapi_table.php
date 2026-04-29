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
    Schema::create('rekam_terapi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_jadwal')->constrained('jadwal_terapi')->onDelete('cascade');
        $table->date('tanggal_pelaksanaan');
        $table->integer('nomor_sesi');

        // Perubahan: Menggunakan ENUM agar data terukur untuk grafik
        $table->enum('hasil_kemajuan', ['Menurun', 'Tetap', 'Meningkat', 'Meningkat Pesat']);

        $table->text('catatan_terapis');
        $table->text('rekomendasi_lanjutan')->nullable();
        $table->integer('skor_grafik'); // 1-100
        $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan']);
        $table->string('file_lampiran')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_terapi');
    }
};
