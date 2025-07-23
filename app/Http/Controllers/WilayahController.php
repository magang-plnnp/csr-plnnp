<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function getKecamatan()
    {
        // 3505 = Kabupaten Probolinggo
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/3513.json');
        return response()->json($response->json());
    }

    public function getKelurahan($kecamatanId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$kecamatanId}.json");
        return response()->json($response->json());
    }
}
