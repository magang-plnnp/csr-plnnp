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
    $kecamatan = MasterPosKecamatan::whereIn('kode_kabupaten', ['3513', '3574', '3512'])
        ->orderBy('nama_kecamatan')
        ->get(['kode_kecamatan', 'nama_kecamatan', 'kode_kabupaten']);

    $grouped = collect([
        '3513' => 'Kabupaten Probolinggo',
        '3574' => 'Kota Probolinggo',
        '3512' => 'Kabupaten Situbondo'
    ]);

    $result = $grouped->map(function ($label, $kode) use ($kecamatan) {
        $options = $kecamatan->where('kode_kabupaten', $kode)->map(function ($item) {
            return [
                'id' => $item->kode_kecamatan,
                'name' => $item->nama_kecamatan
            ];
        })->values();

        return [
            'label' => $label,
            'options' => $options
        ];
    })->values();

    return response()->json($result);
}


    public function getKelurahan($kecamatanId)
{
    $kelurahan = MasterPosKelurahan::where('kode_kecamatan', $kecamatanId)
        ->orderBy('nama_desa_kelurahan')
        ->get(['kode_desa as id', 'nama_desa_kelurahan as name']);

    return response()->json($kelurahan);
}
}
