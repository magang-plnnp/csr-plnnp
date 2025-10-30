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
    // Validasi input
    $request->validate([
        'proposal_id' => 'required|exists:proposal,id',
        'nama_penerima' => 'required|string|max:255',
        'jabatan_penerima' => 'required|string|max:255',
        'jenis_bantuan' => 'required|array|min:1',
        'jenis_bantuan.*' => 'required|string|max:255',
        'jumlah_bantuan' => 'required|array|min:1',
        'jumlah_bantuan.*' => 'required|string|max:255',
    ]);

    // Gabungkan jenis dan jumlah jadi array bantuan
    $bantuan = [
        'jenis' => $request->jenis_bantuan,
        'jumlah' => $request->jumlah_bantuan,
    ];

    // Simpan data ke database, simpan bantuan dalam format JSON
    $beritaAcara = BeritaAcara::create([
        'proposal_id' => $request->proposal_id,
        'nama_penerima' => $request->nama_penerima,
        'jabatan_penerima' => $request->jabatan_penerima,
        'bantuan' => json_encode($bantuan),
    ]);

    // Decode bantuan kembali agar siap dikirim ke view PDF
    $bantuanArray = json_decode($beritaAcara->bantuan, true) ?? ['jenis' => [], 'jumlah' => []];

    $proposal = Proposal::find($beritaAcara->proposal_id);

   

    $businessSupport = \App\Models\BusinessSupport::first();
$namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno'; 
    // Generate PDF berdasarkan view 'pdf.berita_acara'
    $pdf = PDF::loadView('pdf.berita_acara', [
        'data'   => $beritaAcara,
        'jenis'  => $bantuanArray['jenis'] ?? [],
        'jumlah' => $bantuanArray['jumlah'] ?? [],
        'namaBisnisSupport' => $namaBisnisSupport, // aktifkan jika ada
        'proposal' => $proposal
    ]);

    // Nama file PDF
    $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';

    // Simpan file PDF ke folder storage/app/public/berita_acara/
    Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

    // Update kolom file_pdf dengan path file
    $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('berita-acara.index')
        ->with('success', 'Berita acara berhasil dibuat dan PDF telah disimpan.');
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

        // Hapus PDF lama jika ada
        if ($beritaAcara->file_pdf && Storage::exists('public/' . $beritaAcara->file_pdf)) {
            Storage::delete('public/' . $beritaAcara->file_pdf);
        }

        // Gabungkan jenis & jumlah
        $bantuan = [
            'jenis' => $request->jenis_bantuan,
            'jumlah' => $request->jumlah_bantuan,
        ];

        // Update data di database
        $beritaAcara->update([
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
            'bantuan' => json_encode($bantuan),
        ]);

        $businessSupport = \App\Models\BusinessSupport::first();
        $namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno';

        $bantuanArray = json_decode($beritaAcara->bantuan, true) ?? ['jenis' => [], 'jumlah' => []];
        $proposal = Proposal::find($beritaAcara->proposal_id);

        // Generate ulang PDF
        $pdf = Pdf::loadView('pdf.berita_acara', [
            'data'   => $beritaAcara,
            'jenis'  => $bantuanArray['jenis'] ?? [],
            'jumlah' => $bantuanArray['jumlah'] ?? [],
            'namaBisnisSupport' => $namaBisnisSupport,
            'proposal' => $proposal,
        ]);

        $pdfName = 'berita_acara_' . $beritaAcara->id . '.pdf';
        Storage::put('public/berita_acara/' . $pdfName, $pdf->output());

        $beritaAcara->update(['file_pdf' => 'berita_acara/' . $pdfName]);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Data berita acara berhasil diperbarui dan PDF telah digenerate ulang.');
    }

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file_upload' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
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
