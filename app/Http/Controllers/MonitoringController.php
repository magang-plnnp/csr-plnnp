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

    public function updateKeterangan(Request $request)
    {
    $request->validate([
        'proposal_id' => 'required|integer|exists:proposal,id',
        'keterangan' => 'nullable|string|max:255',
    ]);

    Proposal::where('id', $request->proposal_id)
        ->update(['keterangan' => $request->keterangan]);

    session()->flash('success', 'Keterangan berhasil diperbarui.');
    return response()->json(['message' => 'Keterangan berhasil diperbarui']);
}
}
