<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubProsesSeeder extends Seeder
{
    public function run(): void
    {
        // Sub proses untuk Pembayaran Langsung (tipe_proses_id = 1)
        DB::table('sub_proses')->insert([
            [
                'tipe_proses_id' => 1,
                'nama_sub' => 'Form Kelayakan/Notulen',
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 1,
                'nama_sub' => 'BA / MoU',
                'order_index' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 1,
                'nama_sub' => 'Berkas Pencairan',
                'order_index' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 1,
                'nama_sub' => 'Verol',
                'order_index' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 1,
                'nama_sub' => 'Terbayar',
                'order_index' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sub proses untuk NPO (tipe_proses_id = 2)
        DB::table('sub_proses')->insert([
            [
                'tipe_proses_id' => 2,
                'nama_sub' => 'Form Kelayakan/Notulen',
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 2,
                'nama_sub' => 'BA / MoU',
                'order_index' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 2,
                'nama_sub' => 'RAB',
                'order_index' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 2,
                'nama_sub' => 'Verol',
                'order_index' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 2,
                'nama_sub' => 'Terbayar',
                'order_index' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sub proses untuk PO (tipe_proses_id = 3)
        DB::table('sub_proses')->insert([
            [
                'tipe_proses_id' => 3,
                'nama_sub' => 'MoU',
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 3,
                'nama_sub' => 'TOR',
                'order_index' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 3,
                'nama_sub' => 'RAB',
                'order_index' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 3,
                'nama_sub' => 'Ellipse',
                'order_index' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipe_proses_id' => 3,
                'nama_sub' => 'Terbayar',
                'order_index' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
