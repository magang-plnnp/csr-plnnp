<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;

class MonitoringController extends Controller
{
    public function index()
    {
        // Ambil semua proposal dengan relasi yang dibutuhkan untuk ditampilkan di tabel monitoring
        $proposals = Proposal::with([
            'tipologi:id,kode',
            'namaPic:id,nama',
            'tipeProses:id,nama',
            'tipeProses.subProses:id,tipe_proses_id,nama_sub',
            'checklist' // untuk mengetahui progress berdasarkan checklist
        ])->get();

        return view('proposal.monitoring.index', [
            'proposals' => $proposals
        ]);
    }
}
