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
        return view('form.berita-acara.index', ['beritaacara' => BeritaAcara::all(), 'proposal' => Proposal::all()]);
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

    // Jika kamu ingin menambahkan nama bisnis support yang dinamis,
    // bisa ambil disini (jika ada model BusinessSupport)
    // $businessSupport = \App\Models\BusinessSupport::first();
    // $namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno';

    $businessSupport = \App\Models\BusinessSupport::first();
$namaBisnisSupport = $businessSupport ? $businessSupport->nama : 'Sukarno'; 
    // Generate PDF berdasarkan view 'pdf.berita_acara'
    $pdf = PDF::loadView('pdf.berita_acara', [
        'data'   => $beritaAcara,
        'jenis'  => $bantuanArray['jenis'] ?? [],
        'jumlah' => $bantuanArray['jumlah'] ?? [],
        'namaBisnisSupport' => $namaBisnisSupport, // aktifkan jika ada
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

        return view('pdf.berita_acara', [
            'data'   => $beritaAcara,
            'bantuan'   => $bantuan,
            'jenis'  => $bantuan['jenis'] ?? [],
            'jumlah' => $bantuan['jumlah'] ?? [],
        ]);
    }

}
