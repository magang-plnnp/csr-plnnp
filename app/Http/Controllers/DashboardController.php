<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proposal;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $loggedInUser = Auth::user();

        // === FILTER INPUT ===
        $selectedNamaPic = $request->get('nama_pic');
        $tahun = $request->get('tahun');

        // === LIST TAHUN UNTUK DROPDOWN ===
        $tahunList = Proposal::whereNotNull('tanggal_disposisi')
            ->selectRaw('YEAR(tanggal_disposisi) AS tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        // === QUERY PROPOSAL UTAMA ===
        $proposalQuery = Proposal::with('namaPic')
            ->when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
                $query->whereHas('namaPic', fn($q) => $q->where('nama', $selectedNamaPic));
            })
            ->when($tahun, function ($query) use ($tahun) {
                $query->whereYear('tanggal_disposisi', $tahun);
            });

        $proposal = $proposalQuery->get();

        // === LIST SEMUA PIC (untuk dropdown) ===
        $allNamaPics = DB::table('users')->pluck('nama')->toArray();

        // === STATISTIK DASAR ===
        $jumlahPengajuan = $proposal->count();
        $totalPengajuan = $proposal->sum('nominal_pengajuan');
        $totalDisetujui = $proposal->sum('nominal_disetujui');
        $jumlahSetuju = $proposal->where('status', 'setuju')->count();
        $jumlahTolak = $proposal->where('status', 'tolak')->count();
        $jumlahPending = $proposal->where('status', 'pending')->count();

        // === RINCIAN DISETUJUI PER TIPOLOGI ===
        $rincianDisetujui = DB::table('tipologi')
            ->leftJoin('proposal', function ($join) use ($selectedNamaPic, $tahun) {
                $join->on('proposal.tipologi_id', '=', 'tipologi.id')
                    ->where('proposal.status', 'setuju');

                if ($selectedNamaPic) {
                    $join->whereIn('proposal.nama_pic_id', function ($sub) use ($selectedNamaPic) {
                        $sub->select('id')->from('users')->where('nama', $selectedNamaPic);
                    });
                }

                if ($tahun) {
                    $join->whereYear('proposal.tanggal_disposisi', $tahun);
                }
            })
            ->groupBy('tipologi.id', 'tipologi.kode')
            ->select('tipologi.kode as kategori', DB::raw('COALESCE(SUM(proposal.nominal_disetujui), 0) as jumlah'))
            ->get();

        // === LIST TIPOLOGI & PIC ===
        $tipologiList = DB::table('tipologi')->pluck('kode', 'id')->toArray();
        $picList = DB::table('users')->pluck('nama', 'id')->toArray();

        // === TOTAL PER TIPOLOGI ===
        $totalPerTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
                $query->whereHas('namaPic', fn($q) => $q->where('nama', $selectedNamaPic));
            })
            ->when($tahun, fn($q) => $q->whereYear('tanggal_disposisi', $tahun))
            ->select('tipologi_id', DB::raw('COUNT(*) as total'))
            ->groupBy('tipologi_id')
            ->pluck('total', 'tipologi_id');

        // === JUMLAH PROPOSAL PER PIC + TIPOLOGI ===
        $jumlahPerPicTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
                $query->whereHas('namaPic', fn($q) => $q->where('nama', $selectedNamaPic));
            })
            ->when($tahun, fn($q) => $q->whereYear('tanggal_disposisi', $tahun))
            ->select('nama_pic_id', 'tipologi_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_pic_id', 'tipologi_id')
            ->get()
            ->groupBy('nama_pic_id');

        // === PROGRESS RATA-RATA PER PIC + TIPOLOGI ===
        $progressPerPicTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
                $query->whereHas('namaPic', fn($q) => $q->where('nama', $selectedNamaPic));
            })
            ->when($tahun, fn($q) => $q->whereYear('tanggal_disposisi', $tahun))
            ->select('nama_pic_id', 'tipologi_id', DB::raw('AVG(progress) as avg_progress'))
            ->groupBy('nama_pic_id', 'tipologi_id')
            ->get()
            ->groupBy('nama_pic_id');

        // === BANGUN TABEL PERFORMA PIC ===
        $picTable = [];
        foreach ($picList as $picId => $picNama) {
            $row = [
                'nama' => $picNama,
                'jumlah' => [],
                'persen' => [],
                'total' => 0,
            ];

            foreach ($tipologiList as $tipologiId => $kode) {
                $found = isset($jumlahPerPicTipologi[$picId])
                    ? $jumlahPerPicTipologi[$picId]->firstWhere('tipologi_id', $tipologiId)
                    : null;

                $jumlah = $found ? $found->jumlah : 0;

                $foundProgress = isset($progressPerPicTipologi[$picId])
                    ? $progressPerPicTipologi[$picId]->firstWhere('tipologi_id', $tipologiId)
                    : null;

                $persen = $foundProgress ? round($foundProgress->avg_progress) : 0;

                $row['jumlah'][$kode] = $jumlah;
                $row['persen'][$kode] = $persen;
                $row['total'] += $jumlah;
            }

            $picTable[] = $row;
        }

        return view('dashboard.index', [
            'proposal' => $proposal,
            'jumlahPengajuan' => $jumlahPengajuan,
            'totalPengajuan' => $totalPengajuan,
            'totalDisetujui' => $totalDisetujui,
            'jumlahSetuju' => $jumlahSetuju,
            'jumlahTolak' => $jumlahTolak,
            'jumlahPending' => $jumlahPending,
            'rincianDisetujui' => $rincianDisetujui,
            'tipologiList' => $tipologiList,
            'totalPerTipologi' => $totalPerTipologi,
            'picTable' => $picTable,
            'selectedNamaPic' => $selectedNamaPic,
            'allNamaPics' => $allNamaPics,

            // Tambahan untuk filter tahun
            'tahun' => $tahun,
            'tahunList' => $tahunList,
        ]);
    }
}
