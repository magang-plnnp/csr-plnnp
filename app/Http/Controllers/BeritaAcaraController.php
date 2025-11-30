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
            'jenis_bantuan' => 'required|array|min:1',
            'jenis_bantuan.*' => 'required|string|max:255',
            'jumlah_bantuan' => 'required|array|min:1',
            'jumlah_bantuan.*' => 'required|string|max:255',
        ]);

        // Gabungkan jenis + jumlah
        $bantuan = [
            'jenis' => $request->jenis_bantuan,
            'jumlah' => $request->jumlah_bantuan,
        ];

        // ======== GENERATE NOMOR SURAT PERMANEN =========

        // Ambil nomor terakhir
        $last = BeritaAcara::orderBy('id', 'desc')->first();
        $nextNumber = $last ? $last->id + 1 : 1;

        // 3 digit nomor
        $no3Digit = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Tahun sekarang (tahun file dibuat)
        $tahun = now()->format('Y');

        // Format nomor surat
        $nomorSurat = "{$no3Digit}.BA.KESP/076/UPPTN/{$tahun}";

        // ------------------------------------------------

        // Simpan DB
        $beritaAcara = BeritaAcara::create([
            'proposal_id' => $request->proposal_id,
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
            'bantuan' => json_encode($bantuan),
            'nomor_surat' => $nomorSurat,  
        ]);

        $bantuanArray = json_decode($beritaAcara->bantuan, true);
        $proposal = Proposal::find($beritaAcara->proposal_id);

        $businessSupport = \App\Models\BusinessSupport::first();
        $namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno';

        // Generate PDF pertama
        $pdf = PDF::loadView('pdf.berita_acara', [
            'data' => $beritaAcara,
            'jenis' => $bantuanArray['jenis'],
            'jumlah' => $bantuanArray['jumlah'],
            'namaBisnisSupport' => $namaBisnisSupport,
            'proposal' => $proposal,
            'nomorBeritaAcara' => $nomorSurat    
        ]);

        $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';
        Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

        $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita acara berhasil dibuat.');
    }

    public function show($id)
    {
        $beritaAcara = \App\Models\BeritaAcara::with('proposal')->findOrFail($id);

        // return view('pdf.berita_acara', compact('data'));
        $bantuan = json_decode($beritaAcara->bantuan, true) ?? ['jenis' => [], 'jumlah' => []];
        $businessSupport = \App\Models\BusinessSupport::first();
        $namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno';

        return view('pdf.berita_acara', [
            'data'   => $beritaAcara,
            'bantuan'   => $bantuan,
            'jenis'  => $bantuan['jenis'] ?? [],
            'jumlah' => $bantuan['jumlah'] ?? [],
            'namaBisnisSupport' => $namaBisnisSupport
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'jabatan_penerima' => 'required|string|max:255',
            'jenis_bantuan' => 'required|array|min:1',
            'jenis_bantuan.*' => 'required|string|max:255',
            'jumlah_bantuan' => 'required|array|min:1',
            'jumlah_bantuan.*' => 'required|string|max:255',
        ]);

        $beritaAcara = BeritaAcara::findOrFail($id);

        // nomor_surat TIDAK DIUBAH
        $nomorSurat = $beritaAcara->nomor_surat;

        // Hapus PDF sebelumnya
        if ($beritaAcara->file_pdf && Storage::exists('public/' . $beritaAcara->file_pdf)) {
            Storage::delete('public/' . $beritaAcara->file_pdf);
        }

        $bantuan = [
            'jenis' => $request->jenis_bantuan,
            'jumlah' => $request->jumlah_bantuan,
        ];

        // Update data biasa
        $beritaAcara->update([
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
            'bantuan' => json_encode($bantuan),
        ]);

        $businessSupport = \App\Models\BusinessSupport::first();
        $namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno';

        $proposal = Proposal::find($beritaAcara->proposal_id);
        $bantuanArray = json_decode($beritaAcara->bantuan, true);

        // Generate ulang PDF (nomor tidak berubah)
        $pdf = Pdf::loadView('pdf.berita_acara', [
            'data' => $beritaAcara,
            'jenis' => $bantuanArray['jenis'],
            'jumlah' => $bantuanArray['jumlah'],
            'namaBisnisSupport' => $namaBisnisSupport,
            'proposal' => $proposal,
            'nomorBeritaAcara' => $nomorSurat
        ]);

        $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';
        Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

        $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita acara berhasil diperbarui.');
    }

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file_upload' => 'required|mimes:jpg,jpeg,png,heic,pdf',
        ]);

        $beritaAcara = BeritaAcara::findOrFail($id);

        // Hapus file lama jika ada
        if ($beritaAcara->file_upload && Storage::exists('public/' . $beritaAcara->file_upload)) {
            Storage::delete('public/' . $beritaAcara->file_upload);
        }

        // Simpan file baru
        $file = $request->file('file_upload');
        $path = $file->store('public/berita_acara_upload');
        $beritaAcara->update(['file_upload' => str_replace('public/', '', $path)]);

        return redirect()->route('berita-acara.index')->with('success', 'File berhasil diupload.');
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

    public function getBantuan($id)
{
    $beritaAcara = BeritaAcara::findOrFail($id);
    $bantuanArray = json_decode($beritaAcara->bantuan, true) ?? ['jenis' => [], 'jumlah' => []];

    $data = [];
    foreach ($bantuanArray['jenis'] as $i => $jenis) {
        $data[] = [
            'jenis_bantuan' => $jenis,
            'jumlah_bantuan' => $bantuanArray['jumlah'][$i] ?? '',
        ];
    }

    return response()->json($data);
}

}
