<?php

namespace App\Http\Controllers;

use App\Models\BusinessSupport;
use Illuminate\Http\Request;

class BusinessSupportController extends Controller
{
    public function index()
    {
        // Ambil data nama bisnis support (anggap hanya 1 record)
        $support = BusinessSupport::first();
        return view('manajemen-data.business_support.index', compact('support'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $support = BusinessSupport::first();

        if (!$support) {
            $support = BusinessSupport::create(['nama' => $request->nama]);
        } else {
            $support->update(['nama' => $request->nama]);
        }

        return redirect()->route('business-support.index')->with('success', 'Nama bisnis support berhasil diperbarui');
    }
}
