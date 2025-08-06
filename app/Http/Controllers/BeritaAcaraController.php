<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\Proposal;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        return view('form.berita-acara.index', ['beritaacara' => BeritaAcara::all(), 'proposal' => Proposal::all()]);
    }
}
