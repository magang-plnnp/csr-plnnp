<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TipologiSeeder::class,
            TipeProsesSeeder::class,
            SubProsesSeeder::class,
            ProposalSeeder::class,
            ProposalProsesChecklistSeeder::class,
        ]);
    }
}