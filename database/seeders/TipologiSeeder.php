<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipologiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipologi')->insert([
            [
                'id' => 1,
                'kode' => 'CRTY',
                'deskripsi' => 'Ceremony, Tradisi, dan Sosial Budaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'kode' => 'KLBS',
                'deskripsi' => 'Kebutuhan Lingkungan dan Bantuan Sosial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'kode' => 'EMPW',
                'deskripsi' => 'Pemberdayaan Ekonomi dan UMKM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'kode' => 'CABD',
                'deskripsi' => 'Capacity Building dan Penguatan SDM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'kode' => 'INFRST',
                'deskripsi' => 'Infrastruktur dan Pengembangan Sarana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
