<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('instansi_pengajuan');
            $table->string('lokasi');
            $table->date('tanggal_disposisi')->nullable();
            $table->integer('nominal_pengajuan')->nullable();
            $table->string('barang_pengajuan');
            $table->foreignId('tipologi_id')->constrained('tipologi')->onDelete('cascade');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->integer('nominal_disetujui')->nullable();
            $table->string('barang_disetujui')->nullable();
            $table->foreignId('nama_pic_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipe_proses_id')->nullable()->constrained('tipe_proses')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->date('overdue')->nullable();
            $table->integer('progress')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};