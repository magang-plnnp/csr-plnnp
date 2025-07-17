<?php

namespace App\Http\Controllers;

use App\Models\SubProses;
use Illuminate\Http\Request;

class SubProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'tipe_proses_id' => 'required|exists:tipe_proses,id',
            'nama_sub' => 'required|string|max:255',
        ]);

        $maxOrder = SubProses::where('tipe_proses_id', $request->tipe_proses_id)->max('order_index') ?? 0;

        SubProses::create([
            'tipe_proses_id' => $request->tipe_proses_id,
            'nama_sub' => $request->nama_sub,
            'order_index' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Sub proses berhasil ditambahkan.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'tipe_proses_id' => 'required|exists:tipe_proses,id',
            'urutan' => 'required|array',
        ]);

        foreach ($request->urutan as $index => $id) {
            SubProses::where('id', $id)
                ->where('tipe_proses_id', $request->tipe_proses_id)
                ->update(['order_index' => $index + 1]);
        }

        return response()->json(['success' => true]);
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
            'nama_sub' => 'required|string|max:255',
            'order_index' => 'required|integer',
        ]);

        $subProses = SubProses::findOrFail($id);
        $subProses->update([
            'nama_sub' => $request->nama_sub,
            'order_index' => $request->order_index,
        ]);

        return redirect()->back()->with('success', 'Sub Proses berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subProses = SubProses::findOrFail($id);
        $subProses->delete();

        return redirect()->back()->with('success', 'Sub Proses berhasil dihapus.');
    }
}
