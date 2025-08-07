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

    public function update(Request $request, $id)
    {
        $request->validate([
            'dasar_pelaksanaan' => 'required|string|max:255',
            'latar_belakang' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
        ]);

        $kelayakan = Kelayakan::findOrFail($id);

        // Hapus PDF lama jika ada
        if ($kelayakan->file_pdf && Storage::exists('public/' . $kelayakan->file_pdf)) {
            Storage::delete('public/' . $kelayakan->file_pdf);
        }

        // Update data di database
        $kelayakan->update([
            'dasar_pelaksanaan' => $request->dasar_pelaksanaan,
            'latar_belakang' => $request->latar_belakang,
            'tujuan' => $request->tujuan,
        ]);

        // Generate ulang PDF berdasarkan data terbaru
        $pdf = Pdf::loadView('pdf.kelayakan', ['data' => $kelayakan]);
        $pdfName = 'kelayakan_' . $kelayakan->id . '.pdf';

        // Simpan PDF baru ke storage
        Storage::put('public/kelayakan/' . $pdfName, $pdf->output());

        // Update path file PDF di database
        $kelayakan->update(['file_pdf' => 'kelayakan/' . $pdfName]);

        return redirect()->route('kelayakan.index')
            ->with('success', 'Data kelayakan berhasil diperbarui dan PDF telah digenerate ulang.');
    }

    public function destroy($id)
    {
        $kelayakan = Kelayakan::findOrFail($id);

        // Hapus file PDF dari storage jika ada
        if ($kelayakan->file_pdf && Storage::exists('public/' . $kelayakan->file_pdf)) {
            Storage::delete('public/' . $kelayakan->file_pdf);
        }

        // Hapus data dari database
        $kelayakan->delete();

        return redirect()->route('kelayakan.index')
            ->with('success', 'Data kelayakan dan file PDF berhasil dihapus.');
    }
}
