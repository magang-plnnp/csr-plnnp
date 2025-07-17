<?php

namespace App\Http\Controllers;

use App\Models\TipeProses;
use Illuminate\Http\Request;

class TipeProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipeProses = TipeProses::with('subProses')->get();
        return view('manajemen-data.tipe_proses.index', compact('tipeProses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        TipeProses::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Tipe Proses berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
