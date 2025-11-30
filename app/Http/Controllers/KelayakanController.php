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
        $kelayakan = Kelayakan::all();

        // Ambil hanya proposal yang belum memiliki kelayakan
        $proposal = Proposal::doesntHave('kelayakan')->get();

        return view('form.kelayakan.index', compact('kelayakan', 'proposal'));
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
        'data_terdahulu' => 'nullable|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'catatan_khusus' => 'nullable|string|max:255',
        'prioritas' => 'required|in:1,2,3,4,5',
        'dampak' => 'required|in:1,2,3,4,5',
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
        'pejabat_instansi' => $request->pejabat_instansi, 
        'data_terdahulu' => $request->data_terdahulu,
        'contact_person' => $request->contact_person,
        'catatan_khusus' => $request->catatan_khusus,
        'prioritas' => $request->prioritas,
        'dampak' => $request->dampak,
        ]);

        // Generate PDF berdasarkan view
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.kelayakan', ['data' => $kelayakan]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->render();

        $prioritas = $request->prioritas;
        $dampak = $request->dampak;

        // di dalam page_script
$pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($prioritas, $dampak) {
    $fontBold = $fontMetrics->getFont('Arial', 'bold');
    $fontNormal = $fontMetrics->getFont('Arial', 'normal');
    $size = 6.5;

    $x1 = 396; // posisi awal "Halaman:"
    $x2 = 426; // posisi "2 dari 3"
    $y = 127;

    $canvas->text($x1, $y, "Halaman:", $fontBold, $size);
    $canvas->text($x1 + 0.2, $y, "Halaman:", $fontBold, $size);
    $canvas->text($x2, $y, "$pageNumber dari $pageCount", $fontNormal, $size);

    $canvas->line(50, 770, 550, 770, [0, 0, 0], 0.5);

    $key = "{$prioritas}-{$dampak}";

    if ($pageNumber == 2) {
    $koordinatMatriks = [
        '1-1' => [205, 186],
        '1-2' => [265, 186],
        '1-3' => [326, 186],
        '1-4' => [390, 186],
        '1-5' => [466, 186],

        '2-1' => [205,206],
        '2-2' => [268, 206],
        '2-3' => [328, 206],
        '2-4' => [390, 206],
        '2-5' => [466, 206],

        '3-1' => [205,226],
        '3-2' => [269, 226],
        '3-3' => [328, 226],
        '3-4' => [395, 226],
        '3-5' => [461, 226],

        '4-1' => [205, 246],
        '4-2' => [265, 246],
        '4-3' => [326, 246],
        '4-4' => [389, 246],
        '4-5' => [460, 246],

        '5-1' => [205, 266],
        '5-2' => [265, 266],
        '5-3' => [326, 266],
        '5-4' => [393, 266],
        '5-5' => [462, 266],
    ];
    }

    if (isset($koordinatMatriks[$key])) {
    [$cx, $cy] = $koordinatMatriks[$key];
    $radiusX = 20;  // radius horizontal (lebar)
    $radiusY = 7;  // radius vertikal (tinggi)
    $segments = 100; // banyak garis untuk elips

    $angleStep = 2 * pi() / $segments;

    $prevX = $cx + $radiusX * cos(0);
    $prevY = $cy + $radiusY * sin(0);

    for ($i = 1; $i <= $segments; $i++) {
        $angle = $i * $angleStep;
        $x = $cx + $radiusX * cos($angle);
        $y = $cy + $radiusY * sin($angle);

        // Garis hitam dengan ketebalan 1.5
        $canvas->line($prevX, $prevY, $x, $y, [0, 0, 0], 1.5);

        $prevX = $x;
        $prevY = $y;
    }
} else {
    logger()->warning("Koordinat tidak ditemukan untuk key {$key}");
}
});


        $pdfName = 'kelayakan_' . $kelayakan->id . '.pdf';

        // Simpan PDF ke storage
        Storage::put('public/kelayakan/' . $pdfName, $pdf->output());

        // Simpan path file ke database
        $kelayakan->update(['file_pdf' => 'kelayakan/' . $pdfName]);

        return redirect()->route('kelayakan.index')
            ->with('success', 'Form Analisis Kelayakan berhasil dibuat dan PDF telah disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dasar_pelaksanaan' => 'required|string|max:255',
            'latar_belakang' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'prioritas' => 'required|in:1,2,3,4,5',
            'dampak' => 'required|in:1,2,3,4,5',
        ]);

        $kelayakan = Kelayakan::findOrFail($id);

        // Hapus PDF lama jika ada
        if ($kelayakan->file_pdf && Storage::exists('public/' . $kelayakan->file_pdf)) {
            Storage::delete('public/' . $kelayakan->file_pdf);
        }

        // $currentRevisi = (int) $kelayakan->revisi;
        // $newRevisi = str_pad($currentRevisi + 1, 2, '0', STR_PAD_LEFT);
        $kelayakan->increment('revisi');
        // $kelayakan->refresh();

        // Update data di database
        $kelayakan->update([
            'dasar_pelaksanaan' => $request->dasar_pelaksanaan,
            'latar_belakang' => $request->latar_belakang,
            'tujuan' => $request->tujuan,
            'prioritas' => $request->prioritas,
            'dampak' => $request->dampak,
            // 'revisi' => $newRevisi,
        ]);

        $kelayakan->revisi = str_pad($kelayakan->revisi, 2, '0', STR_PAD_LEFT);
        $kelayakan->save();

        // Generate ulang PDF berdasarkan data terbaru
        $pdf = Pdf::loadView('pdf.kelayakan', ['data' => $kelayakan]);

        $prioritas = $request->prioritas;
        $dampak = $request->dampak;

        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->render();

        // Tambahkan page_script seperti di store() untuk matrik
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($prioritas, $dampak) {
            $fontBold = $fontMetrics->getFont('Arial', 'bold');
            $fontNormal = $fontMetrics->getFont('Arial', 'normal');
            $size = 6.5;

            $x1 = 396; // posisi awal "Halaman:"
            $x2 = 426; // posisi "2 dari 3"
            $y = 129;

            $canvas->text($x1, $y, "Halaman:", $fontBold, $size);
            $canvas->text($x1 + 0.2, $y, "Halaman:", $fontBold, $size);
            $canvas->text($x2, $y, "$pageNumber dari $pageCount", $fontNormal, $size);

            $canvas->line(50, 770, 550, 770, [0, 0, 0], 0.5);

            $key = "{$prioritas}-{$dampak}";

            if ($pageNumber == 2) {
                $koordinatMatriks = [
                    '1-1' => [205, 186],
                    '1-2' => [265, 186],
                    '1-3' => [326, 186],
                    '1-4' => [390, 186],
                    '1-5' => [466, 186],

                    '2-1' => [205,206],
                    '2-2' => [268, 206],
                    '2-3' => [328, 206],
                    '2-4' => [390, 206],
                    '2-5' => [466, 206],

                    '3-1' => [205,226],
                    '3-2' => [269, 226],
                    '3-3' => [328, 226],
                    '3-4' => [395, 226],
                    '3-5' => [461, 226],

                    '4-1' => [205, 246],
                    '4-2' => [265, 246],
                    '4-3' => [326, 246],
                    '4-4' => [389, 246],
                    '4-5' => [460, 246],

                    '5-1' => [205, 266],
                    '5-2' => [265, 266],
                    '5-3' => [326, 266],
                    '5-4' => [393, 266],
                    '5-5' => [462, 266],
                ];
            }

            if (isset($koordinatMatriks[$key])) {
                [$cx, $cy] = $koordinatMatriks[$key];
                $radiusX = 20;  // radius horizontal (lebar)
                $radiusY = 7;  // radius vertikal (tinggi)
                $segments = 100; // banyak garis untuk elips

                $angleStep = 2 * pi() / $segments;

                $prevX = $cx + $radiusX * cos(0);
                $prevY = $cy + $radiusY * sin(0);

                for ($i = 1; $i <= $segments; $i++) {
                    $angle = $i * $angleStep;
                    $x = $cx + $radiusX * cos($angle);
                    $y = $cy + $radiusY * sin($angle);

                    // Garis hitam dengan ketebalan 1.5
                    $canvas->line($prevX, $prevY, $x, $y, [0, 0, 0], 1.5);

                    $prevX = $x;
                    $prevY = $y;
                }
            } else {
                logger()->warning("Koordinat tidak ditemukan untuk key {$key}");
            }
        });

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
