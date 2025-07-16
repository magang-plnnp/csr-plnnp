<?php

namespace App\Http\Controllers;

use App\Models\Tipologi;
use Illuminate\Http\Request;

class TipologiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manajemen-data.tipologi.index', ['tipologi' => Tipologi::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manajemen-data.tipologi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:tipologi,kode',
            'deskripsi' => 'required|string',
        ]);

        Tipologi::create([
            'kode' => $request->kode,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Tipologi berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
        ]);

        $tipologi = Tipologi::findOrFail($id);
        $tipologi->update([
            'kode' => $request->kode,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('tipologi.index')->with('success', 'Data tipologi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipologi = Tipologi::findOrFail($id);
        $tipologi->delete();

        return redirect()->route('tipologi.index')->with('success', 'Data tipologi berhasil dihapus.');
    }
}
