<?php

namespace App\Http\Controllers;

use App\Models\TingkatPendidikan;
use Illuminate\Http\Request;

class TingkatPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $tingkatPendidikan = TingkatPendidikan::where('is_deleted', '0')->get();
    return view('tingkatpendidikan.index', [
    'tingkatpendidikan' => $tingkatPendidikan
    ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tingkatpendidikan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tingkat_pendidikan' => 'required', 
            ]);
            $array = $request->only([
            'nama_tingkat_pendidikan'
            ]);
            $tingkatPendidikan = TingkatPendidikan::create($array);
            return redirect()->route('tingkatpendidikan.index') 
            ->with('success_message', 'Data telah tersimpan');
            
    }

    public function edit(TingkatPendidikan $tingkatPendidikan)
{
    return view('tingkatpendidikan.edit', compact('tingkatPendidikan'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_tingkat_pendidikan)
{
    $request->validate([
        'nama_tingkat_pendidikan' =>'required',
    ]);
    $tingkatPendidikan = TingkatPendidikan::find($id_tingkat_pendidikan);
    if ($tingkatPendidikan) {
        $tingkatPendidikan->nama_tingkat_pendidikan = $request->nama_tingkat_pendidikan;
        $tingkatPendidikan->save();
        return redirect()->route('tingkatpendidikan.index')->with('success_message', 'Data telah tersimpan');
    }
    // Tambahkan logika untuk penanganan jika data tidak ditemukan
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_tingkat_pendidikan)
    {
        $tingkatPendidikan =  TingkatPendidikan::find($id_tingkat_pendidikan);
        if ($tingkatPendidikan) {
            $tingkatPendidikan->update([
                'is_deleted' => '1',
            ]);
        }
        return redirect()->route('tingkatpendidikan.index')->with('success_message', 'Data telah terhapus');
    }
}
