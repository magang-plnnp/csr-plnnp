<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('nama_penerima');
            $table->string('jabatan_penerima');
            $table->string('file_pdf')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
