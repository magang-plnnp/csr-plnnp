<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalProsesChecklistSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Data proposal_id dan sub_proses_id disesuaikan urutan sub_proses per tipe_proses
        // Asumsi:
        // - Proposal ID 1–6 menggunakan Pembayaran Langsung (sub_proses_id 1–5)
        // - Proposal ID 7–8 menggunakan NPO (sub_proses_id 6–10)
        // - Proposal ID 9–10 menggunakan PO (sub_proses_id 11–15)

        // =======================
        // Pembayaran Langsung
        // =======================

        for ($i = 1; $i <= 6; $i++) {
            for ($subId = 1; $subId <= 5; $subId++) {
                DB::table('proposal_proses_checklist')->insert([
                    'proposal_id' => $i,
                    'sub_proses_id' => $subId,
                    'is_checked' => true,
                    'checked_at' => $now->copy()->addMinutes(rand(1, 100)),
                    'updated_at' => $now,
                ]);
            }
        }

        // =======================
        // NPO
        // =======================

        for ($i = 7; $i <= 8; $i++) {
            for ($subId = 6; $subId <= 10; $subId++) {
                DB::table('proposal_proses_checklist')->insert([
                    'proposal_id' => $i,
                    'sub_proses_id' => $subId,
                    'is_checked' => ($i == 7 ? false : true),
                    'checked_at' => ($i == 7 ? null : $now->copy()->addMinutes(rand(1, 100))),
                    'updated_at' => $now,
                ]);
            }
        }

        // =======================
        // PO
        // =======================

        for ($i = 9; $i <= 10; $i++) {
            for ($subId = 11; $subId <= 15; $subId++) {
                DB::table('proposal_proses_checklist')->insert([
                    'proposal_id' => $i,
                    'sub_proses_id' => $subId,
                    'is_checked' => true,
                    'checked_at' => $now->copy()->addMinutes(rand(1, 100)),
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
