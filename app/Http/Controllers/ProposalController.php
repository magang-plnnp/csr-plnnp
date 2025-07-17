<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\TipeProses;
use App\Models\Tipologi;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('proposal.pengajuan.index', ['proposal' => Proposal::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proposal.pengajuan.create', [
            'tipologi' => Tipologi::all(),
            'proses' => TipeProses::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'instansi_pengajuan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_disposisi' => 'required|date',
            'nominal_pengajuan' => 'nullable|numeric',
            'barang_pengajuan' => 'nullable|string|max:255',
            'tipologi_id' => 'required|exists:tipologi,id',
            'status' => 'required',
            'nominal_disetujui' => 'nullable|numeric',
            'barang_disetujui' => 'nullable|string|max:255',
            'nama_pic_id' => 'required|string|max:255',
            'tipe_proses_id' => 'required|exists:tipe_proses,id',
            'keterangan' => 'nullable|string|max:1000',
            'overdue' => 'nullable|date',
        ]);

        // Simpan data ke dalam tabel proposal
        Proposal::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('proposal.index')->with('success', 'Data proposal berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proposal = Proposal::findOrFail($id); // Ambil data proposal berdasarkan ID

        // Ambil data relasi yang dibutuhkan untuk dropdown
        $tipologi = Tipologi::all();
        $proses = TipeProses::all();

        // Kirim ke view edit
        return view('proposal.pengajuan.edit', compact('proposal', 'tipologi', 'proses'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'instansi_pengajuan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_disposisi' => 'required|date',
            'nominal_pengajuan' => 'nullable|numeric',
            'barang_pengajuan' => 'nullable|string|max:255',
            'tipologi_id' => 'required|exists:tipologi,id',
            'status' => 'required',
            'nominal_disetujui' => 'nullable|numeric',
            'barang_disetujui' => 'nullable|string|max:255',
            'nama_pic_id' => 'required|string|max:255',
            'tipe_proses_id' => 'required|exists:tipe_proses,id',
            'keterangan' => 'nullable|string|max:1000',
            'overdue' => 'nullable|date',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update($validated);

        return redirect()->route('proposal.index')->with('success', 'Data proposal berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'Data proposal berhasil dihapus.');
    }
}
