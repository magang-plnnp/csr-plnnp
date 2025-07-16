<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_proses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipe_proses_id')->constrained('tipe_proses')->onDelete('cascade');
            $table->string('nama_sub');
            $table->integer('order_index');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_proses');
    }
};