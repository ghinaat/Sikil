<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangan = Ruangan::where('is_deleted', '0')->get();
        return view('ruangan.index', [
            'ruangan' => $ruangan,
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
            'nama_ruangan' => 'required',
        ]);

        $ruangan = new Ruangan();
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruangan $ruangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruangan $ruangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required',
        ]);

        $ruangan = Ruangan::find($id_ruangan);
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_ruangan)
    {
     
        $ruangan = Ruangan::find($id_ruangan);
        if ($ruangan) {
            $ruangan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('ruangan.index')->with('success_message', 'Data telah terhapus');
    }
    
}