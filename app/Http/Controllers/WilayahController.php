<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPosKabkota;
use App\Models\MasterPosKecamatan;
use App\Models\MasterPosKelurahan;

class WilayahController extends Controller
{
    // Ambil data kabupaten/kota
    public function getKabupaten()
    {
        $kabupaten = MasterPosKabkota::whereIn('kode_kabupaten', ['3513', '3574', '3512'])
            ->orderBy('nama_kabupaten')
            ->get(['kode_kabupaten as id', 'nama_kabupaten as name']);

        return response()->json($kabupaten);
    }

    // Ambil kecamatan berdasarkan kode kabupaten
    public function getKecamatan($kabupatenId)
    {
        $kecamatan = MasterPosKecamatan::where('kode_kabupaten', $kabupatenId)
            ->orderBy('nama_kecamatan')
            ->get(['kode_kecamatan as id', 'nama_kecamatan as name']);

        return response()->json($kecamatan);
    }

    // Ambil kelurahan berdasarkan kode kecamatan
    public function getKelurahan($kecamatanId)
    {
        $kelurahan = MasterPosKelurahan::where('kode_kecamatan', $kecamatanId)
            ->orderBy('nama_desa_kelurahan')
            ->get(['kode_desa as id', 'nama_desa_kelurahan as name']);

        return response()->json($kelurahan);
    }
}
