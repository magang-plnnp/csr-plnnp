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
            'indikator_lingkungan' => 'nullable|string',
            'indikator_sosial' => 'nullable|string',
            'jumlah_penerima_manfaat' => 'nullable|string|max:255',
            'jenis_stakeholder' => 'nullable|string|max:255',
            'pejabat_instansi' => 'nullable|string|max:255',
            'bantuan_diajukan' => 'nullable|string',
            'data_terdahulu' => 'nullable|string|max:255',
            'catatan_khusus' => 'nullable|string|max:255',
        ]);

        // Simpan data ke database
        $kelayakan = Kelayakan::create([
            'proposal_id' => $request->proposal_id,
            'dasar_pelaksanaan' => $request->dasar_pelaksanaan,
            'latar_belakang' => $request->latar_belakang,
            'tujuan' => $request->tujuan,
            'indikator_lingkungan' => $request->indikator_lingkungan,
            'indikator_sosial' => $request->indikator_sosial,
            'jumlah_penerima_manfaat' => $request->jumlah_penerima_manfaat,
            'jenis_stakeholder' => $request->jenis_stakeholder,
            'pejabat_instansi' => $request->jenis_stakeholder,
            'bantuan_diajukan' => $request->bantuan_diajukan,
            'data_terdahulu' => $request->data_terdahulu,
            'catatan_khusus' => $request->catatan_khusus,
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
            ->with('success', 'Form Analisis Kelayakan berhasil dibuat dan PDF telah disimpan.');
    }
}
