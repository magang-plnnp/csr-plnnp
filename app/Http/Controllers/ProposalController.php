<?php
namespace App\Http\Controllers;

use App\Exports\ProposalExport;
use App\Models\Proposal;
use App\Models\SubProses;
use App\Models\TipeProses;
use App\Models\Tipologi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $proposal = Proposal::with(['beritaAcara', 'kelayakan'])->get();
        return view('proposal.pengajuan.index', compact('proposal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proposal.pengajuan.create', [
            'tipologi' => Tipologi::all(),
            'proses'   => TipeProses::with('subProses')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'instansi_pengajuan' => 'required|string|max:255',
            'kabupaten_id'       => 'required',
            'kabupaten_nama'     => 'required|string',
            'kecamatan_id'       => 'required',
            'kecamatan_nama'     => 'required|string',
            'kelurahan_id'       => 'required',
            'kelurahan_nama'     => 'required|string',
            'tanggal_disposisi'  => 'required|date',
            'nominal_pengajuan'  => 'nullable|string',
            'barang_pengajuan'   => 'nullable|string|max:255',
            'tipologi_id'        => 'required|exists:tipologi,id',
            'status'             => 'required',
            'nominal_disetujui'  => 'nullable',
            'barang_disetujui'   => 'nullable|string|max:255',
            'nama_pic_id'        => 'required|string|max:255',
            'tipe_proses_id'     => 'required|exists:tipe_proses,id',
            'keterangan'         => 'nullable|string|max:1000',
            'overdue'            => 'required|date',
        ]);

        // Bersihkan nilai rupiah menjadi angka
        $validated['nominal_pengajuan'] = $request->nominal_pengajuan
        ? preg_replace('/[^0-9]/', '', $request->nominal_pengajuan)
        : null;

        $validated['nominal_disetujui'] = $request->nominal_disetujui
        ? preg_replace('/[^0-9]/', '', $request->nominal_disetujui)
        : null;

        // Simpan proposal
        $proposal = Proposal::create($validated);

        // Ambil semua sub_proses dari tipe_proses yang dipilih
        $subProsesList = SubProses::where('tipe_proses_id', $proposal->tipe_proses_id)->get();

        // Insert checklist untuk setiap sub proses
        foreach ($subProsesList as $subProses) {
            \App\Models\ProposalProsesChecklist::create([
                'proposal_id'   => $proposal->id,
                'sub_proses_id' => $subProses->id,
                'is_checked'    => false,
                'checked_at'    => null,
            ]);
        }

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
        $proses   = TipeProses::all();

        // Kirim ke view edit
        return view('proposal.pengajuan.edit', compact('proposal', 'tipologi', 'proses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'instansi_pengajuan' => 'required|string|max:255',
            'kabupaten_id'       => 'required',
            'kabupaten_nama'     => 'required|string',
            'kecamatan_id'       => 'required',
            'kecamatan_nama'     => 'required|string',
            'kelurahan_id'       => 'required',
            'kelurahan_nama'     => 'required|string',
            'tanggal_disposisi'  => 'required|date',
            'nominal_pengajuan'  => 'nullable',
            'barang_pengajuan'   => 'nullable|string|max:255',
            'tipologi_id'        => 'required|exists:tipologi,id',
            'status'             => 'required',
            'nominal_disetujui'  => 'nullable',
            'barang_disetujui'   => 'nullable|string|max:255',
            // 'nama_pic_id' => 'required|string|max:255',
            'tipe_proses_id'     => 'required|exists:tipe_proses,id',
            'keterangan'         => 'nullable|string|max:1000',
            'overdue'            => 'nullable|date',
        ]);

        $validated['nominal_pengajuan'] = $request->nominal_pengajuan
        ? preg_replace('/[^0-9]/', '', $request->nominal_pengajuan)
        : null;

        $validated['nominal_disetujui'] = $request->nominal_disetujui
        ? preg_replace('/[^0-9]/', '', $request->nominal_disetujui)
        : null;

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

    public function export(Request $request)
{
    $query = Proposal::with(['tipologi', 'tipeProses.subProses', 'namaPic']);

    if ($request->has('pic') && $request->pic !== null) {
        $query->whereHas('namaPic', function ($q) use ($request) {
            $q->where('nama', $request->pic);
        });
    }

    if ($request->has('tipologi') && $request->tipologi !== null) {
        $query->whereHas('tipologi', function ($q) use ($request) {
            $q->where('kode', $request->tipologi);
        });
    }

    $data = $query->get();

    return Excel::download(new ProposalExport($data), 'data_proposal.xlsx');
}

}
