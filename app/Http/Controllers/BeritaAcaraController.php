<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class BeritaAcaraController extends Controller
{
    public function index()
    {
        $beritaacara = BeritaAcara::all();

        // Ambil hanya proposal yang belum punya berita acara
        $proposal = Proposal::doesntHave('beritaAcara')->get();

        return view('form.berita-acara.index', compact('beritaacara', 'proposal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposal,id',
            'nama_penerima' => 'required|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        $beritaAcara = BeritaAcara::create([
            'proposal_id' => $request->proposal_id,
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
        ]);

        // Generate PDF berdasarkan view
        $pdf = PDF::loadView('pdf.berita_acara', ['data' => $beritaAcara]);
        $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';

        // Simpan PDF ke storage
        Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

        // Simpan path file ke database
        $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita acara berhasil dibuat dan PDF telah disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
        ]);

        $beritaAcara = BeritaAcara::findOrFail($id);

        // Hapus PDF lama jika ada
        if ($beritaAcara->file_pdf && Storage::exists('public/' . $beritaAcara->file_pdf)) {
            Storage::delete('public/' . $beritaAcara->file_pdf);
        }

        // Update data di database
        $beritaAcara->update([
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
        ]);

        // Generate ulang PDF berdasarkan data terbaru
        $pdf = Pdf::loadView('pdf.berita_acara', ['data' => $beritaAcara]);
        $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';

        // Simpan PDF baru ke storage
        Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

        // Update path file PDF di database
        $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Data berita acara berhasil diperbarui dan PDF telah digenerate ulang.');
    }


    public function destroy($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Hapus file PDF dari storage jika ada
        if ($beritaAcara->file_pdf && Storage::exists('public/' . $beritaAcara->file_pdf)) {
            Storage::delete('public/' . $beritaAcara->file_pdf);
        }

        // Hapus data dari database
        $beritaAcara->delete();

        return redirect()->route('berita-acara.index')
            ->with('success', 'Data Berita acara dan file PDF berhasil dihapus.');
    }
}
