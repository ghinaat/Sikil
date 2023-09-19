<?php

namespace App\Http\Controllers;

use App\Models\KodeSurat;
use Illuminate\Http\Request;

class KodeSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodesurat = KodeSurat::where('is_deleted', '0')->get();

        return view('kodesurat.index', [
            'kodesurat' => $kodesurat,
        ]);
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
            'divisi' => 'required',
            'kode_surat' => 'required',
        ]);

        KodeSurat::create($request->all());

        return redirect()->route('kodesurat.index')->with('success', 'Kode Surat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeSurat $kodeSurat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KodeSurat $kodeSurat)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kode_surat)
    {
        // dd($request);
        $request->validate([
            'divisi' => 'required',
            'kode_surat' => 'required',
        ]);
        $kodesurat = KodeSurat::find($id_kode_surat);
        $kodesurat->divisi = $request->divisi;
        $kodesurat->kode_surat = $request->kode_surat;
        $kodesurat->save();

        return redirect()->route('kodesurat.index')->with('success_message', 'Data telah tersimpan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kode_surat)
    {
        $kodesurat = KodeSurat::find($id_kode_surat);

        if ($kodesurat) {
            $kodesurat->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('kodesurat.index')->with('success_message', 'Data telah terhapus');
    }
}
