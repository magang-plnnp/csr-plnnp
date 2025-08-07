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
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.kelayakan', ['data' => $kelayakan]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->render();

        // Tambahkan nomor halaman otomatis di header kanan atas
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $fontBold = $fontMetrics->getFont('Arial', 'bold');
            $fontNormal = $fontMetrics->getFont('Arial', 'normal');
            $size = 6.5;

            $x1 = 396; // posisi awal "Halaman:"
            $x2 = 426; // posisi "2 dari 3", atur agar tidak menimpa
            $y = 135;   // posisi vertikal tetap sama

            $canvas->text($x1, $y, "Halaman:", $fontBold, $size);
            $canvas->text($x1 + 0.2, $y, "Halaman:", $fontBold, $size);
            $canvas->text($x2, $y, "$pageNumber dari $pageCount", $fontNormal, $size);
        });

        $pdfName = 'kelayakan_' . $kelayakan->id . '.pdf';

        // Simpan PDF ke storage
        Storage::put('public/kelayakan/' . $pdfName, $pdf->output());

        // Simpan path file ke database
        $kelayakan->update(['file_pdf' => 'kelayakan/' . $pdfName]);

        return redirect()->route('kelayakan.index')
            ->with('success', 'Berita acara berhasil dibuat dan PDF telah disimpan.');
    }
}
