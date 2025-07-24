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
    $selectedNamaPic = $request->get('nama_pic'); 

    
    // Query Proposal dengan eager loading namaPic
    $proposalQuery = Proposal::with('namaPic');

    // Ambil ID dari nama (jika ada filter)
    $selectedUserId = null;
    if ($selectedNamaPic) {
        // $selectedUserId = DB::table('users')->where('nama', $selectedNamaPic)->value('id');
        $proposalQuery->whereHas('namaPic', function ($q) use ($selectedNamaPic) {
        $q->where('nama', $selectedNamaPic);
    });
    }

    if ($selectedUserId) {
        $proposalQuery->where('nama_pic_id', $selectedUserId);
    }

    // Ambil data proposal yang difilter
    $proposal = $proposalQuery->get();

$allNamaPics = DB::table('users')
    ->pluck('nama')
    ->toArray();


    // Statistik
    $jumlahPengajuan = $proposal->count();
    $totalPengajuan = $proposal->sum('nominal_pengajuan');
    $totalDisetujui = $proposal->sum('nominal_disetujui');
    $jumlahSetuju = $proposal->where('status', 'disetujui')->count();
    $jumlahTolak = $proposal->where('status', 'ditolak')->count();
    $jumlahPending = $proposal->where('status', 'pending')->count();

    // Rincian Disetujui per tipologi
    $rincianDisetujui = DB::table('tipologi')
        ->leftJoin('proposal', function ($join) use ($selectedNamaPic) {
            $join->on('proposal.tipologi_id', '=', 'tipologi.id')
                 ->where('proposal.status', '=', 'disetujui');

            if ($selectedNamaPic) {
                $join->whereIn('proposal.nama_pic_id', function ($subquery) use ($selectedNamaPic) {
                    $subquery->select('id')
                        ->from('users')
                        ->where('nama', $selectedNamaPic);
                });
            }
        })
        ->groupBy('tipologi.id', 'tipologi.kode')
        ->select('tipologi.kode as kategori', DB::raw('COALESCE(SUM(proposal.nominal_disetujui), 0) as jumlah'))
        ->get();

    // Tipologi dan user list
    $tipologiList = DB::table('tipologi')->pluck('kode', 'id')->toArray();
    $picList = DB::table('users')->pluck('nama', 'id')->toArray();

    $totalPerTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
        $query->whereHas('namaPic', function ($q) use ($selectedNamaPic) {
            $q->where('nama', $selectedNamaPic);
        });
    })
        ->select('tipologi_id', DB::raw('COUNT(*) as total'))
        ->groupBy('tipologi_id')
        ->pluck('total', 'tipologi_id');

    $jumlahPerPicTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
        $query->whereHas('namaPic', function ($q) use ($selectedNamaPic) {
            $q->where('nama', $selectedNamaPic);
        });
    })
        ->select('nama_pic_id', 'tipologi_id', DB::raw('COUNT(*) as jumlah'))
        ->groupBy('nama_pic_id', 'tipologi_id')
        ->get()
        ->groupBy('nama_pic_id');

$progressPerPicTipologi = Proposal::when($selectedNamaPic, function ($query) use ($selectedNamaPic) {
        $query->whereHas('namaPic', function ($q) use ($selectedNamaPic) {
            $q->where('nama', $selectedNamaPic);
        });
    })
    ->select('nama_pic_id', 'tipologi_id', DB::raw('AVG(progress) as avg_progress'))
    ->groupBy('nama_pic_id', 'tipologi_id')
    ->get()
    ->groupBy('nama_pic_id');

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
            $total = $totalPerTipologi[$tipologiId] ?? 1;
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
    ]);
}

}