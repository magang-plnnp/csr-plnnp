<?php

namespace App\Http\Controllers;

use App\Models\Kelayakan;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KelayakanController extends Controller
{
    public function index()
    {
        return view('form.kelayakan.index', ['kelayakan' => Kelayakan::all(), 'proposal' => Proposal::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposal,id',
            'dasar_pelaksanaan' => 'required|string|max:255',
            'latar_belakang' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        $kelayakan = Kelayakan::create([
            'proposal_id' => $request->proposal_id,
            'dasar_pelaksanaan' => $request->dasar_pelaksanaan,
            'latar_belakang' => $request->latar_belakang,
            'tujuan' => $request->tujuan,
        ]);

        // Generate PDF berdasarkan view
        $pdf = PDF::loadView('pdf.kelayakan', ['data' => $kelayakan]);
        $pdfName = 'kelayakan_' . $kelayakan->id . '.pdf';

        // Simpan PDF ke storage
        Storage::put('public/kelayakan/' . $pdfName, $pdf->output());

        // Simpan path file ke database
        $kelayakan->update(['file_pdf' => 'kelayakan/' . $pdfName]);

        return redirect()->route('kelayakan.index')
            ->with('success', 'Berita acara berhasil dibuat dan PDF telah disimpan.');
    }
}
