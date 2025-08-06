<?php

namespace App\Http\Controllers;

use App\Models\Kelayakan;
use App\Models\Proposal;
use Illuminate\Http\Request;

class KelayakanController extends Controller
{
    public function index()
    {
        return view('form.kelayakan.index', ['kelayakan' => Kelayakan::all(), 'proposal' => Proposal::all()]);
    }
}
