<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;

class MonitoringController extends Controller
{
    public function index()
    {
        // Ambil semua proposal beserta relasinya
        $proposals = Proposal::with([
            'namaPic:id,nama',
            'tipeProses.subProses:id,tipe_proses_id,nama_sub',
            'checklist'  // nanti kita cek sub_proses_id–nya
        ])->get();

        return view('proposal.monitoring.index', compact('proposals'));
    }
}
