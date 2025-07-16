<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeProsesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipe_proses')->insert([
            [
                'id' => 1,
                'nama' => 'Pembayaran Langsung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama' => 'NPO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama' => 'PO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
