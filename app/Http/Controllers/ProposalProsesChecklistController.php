<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalProsesChecklist;
use App\Models\Proposal;

class ProposalProsesChecklistController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|integer',
            'sub_proses_id' => 'required|integer',
            'is_checked' => 'required|boolean',
        ]);

        // Simpan checklist (buat baru jika belum ada)
        $checklist = ProposalProsesChecklist::firstOrNew([
            'proposal_id' => $request->proposal_id,
            'sub_proses_id' => $request->sub_proses_id,
        ]);

        $checklist->is_checked = $request->is_checked;
        $checklist->checked_at = now();
        $checklist->save();

        // === Tambahkan bagian ini untuk menghitung progress ===
        $proposal = Proposal::with('tipeProses.subProses')->find($request->proposal_id);
        $total = $proposal->tipeProses->subProses->count();

        $checked = ProposalProsesChecklist::where('proposal_id', $request->proposal_id)
            ->where('is_checked', 1)
            ->count();

        $progress = $total ? round(($checked / $total) * 100) : 0;

        $proposal->update(['progress' => $progress]);
        // ======================================================

        return response()->json([
            'message' => 'Checklist berhasil diperbarui.',
            'data' => $checklist
        ]);
    }
}
