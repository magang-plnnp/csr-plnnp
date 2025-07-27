<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MasterPosKecamatan;
use App\Models\MasterPosKelurahan;

class WilayahController extends Controller
{
    public function getKecamatan()
    {
        $kecamatan = MasterPosKecamatan::where('kode_kabupaten', '3513')
            ->orderBy('nama_kecamatan')
            ->get(['kode_kecamatan as id', 'nama_kecamatan as name']);

        return response()->json($kecamatan);
    }

    public function getKelurahan($kecamatanId)
{
    $kelurahan = MasterPosKelurahan::where('kode_kecamatan', $kecamatanId)
        ->orderBy('nama_desa_kelurahan')
        ->get(['kode_desa as id', 'nama_desa_kelurahan as name']);

    return response()->json($kelurahan);
}
}
