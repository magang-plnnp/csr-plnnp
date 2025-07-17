<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPengajuan = DB::table('proposal')->count();
        $totalPengajuan  = DB::table('proposal')->sum('nominal_pengajuan');
        $totalDisetujui  = DB::table('proposal')->sum('nominal_disetujui');

        $jumlahSetuju  = DB::table('proposal')->where('status', 'disetujui')->count();
        $jumlahTolak   = DB::table('proposal')->where('status', 'ditolak')->count();
        $jumlahPending = DB::table('proposal')->where('status', 'pending')->count();

        $rincianDisetujui = DB::table('tipologi')
            ->leftJoin('proposal', function ($join) {
                $join->on('proposal.tipologi_id', '=', 'tipologi.id')
                    ->where('proposal.status', '=', 'disetujui');
            })
            ->groupBy('tipologi.id', 'tipologi.kode')
            ->select('tipologi.kode as kategori', DB::raw('COALESCE(SUM(proposal.nominal_disetujui), 0) as jumlah'))
            ->get();

        $tipologiList = DB::table('tipologi')->pluck('kode', 'id')->toArray();
        $picList      = DB::table('users')->pluck('nama', 'id')->toArray();

        // Total proposal per tipologi (untuk chart)
        $totalPerTipologi = DB::table('proposal')
            ->select('tipologi_id', DB::raw('COUNT(*) as total'))
            ->groupBy('tipologi_id')
            ->pluck('total', 'tipologi_id');

        // Jumlah proposal per PIC & Tipologi
        $jumlahPerPicTipologi = DB::table('proposal')
            ->select('nama_pic_id', 'tipologi_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_pic_id', 'tipologi_id')
            ->get()
            ->groupBy('nama_pic_id');

        // Bangun data tabel PIC
        $picTable = [];
        foreach ($picList as $picId => $picNama) {
            $row = [
                'nama'   => $picNama,
                'jumlah' => [],
                'persen' => [],
                'total'  => 0,
            ];

            foreach ($tipologiList as $tipologiId => $kode) {
                $found = isset($jumlahPerPicTipologi[$picId])
                ? $jumlahPerPicTipologi[$picId]->firstWhere('tipologi_id', $tipologiId)
                : null;

                $jumlah = $found ? $found->jumlah : 0;
                $total  = $totalPerTipologi[$tipologiId] ?? 1;
                $persen = $jumlah > 0 ? round($jumlah / $total * 100) : 0;

                $row['jumlah'][$kode] = $jumlah;
                $row['persen'][$kode] = $persen;
                $row['total'] += $jumlah;
            }

            $picTable[] = $row;
        }

        return view('dashboard.index', compact(
            'jumlahPengajuan', 'totalPengajuan', 'totalDisetujui',
            'jumlahSetuju', 'jumlahTolak', 'jumlahPending',
            'rincianDisetujui', 'picTable', 'tipologiList', 'totalPerTipologi'
        ));
    }
}
