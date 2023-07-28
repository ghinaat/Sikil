<?php

namespace App\Http\Controllers;

use App\Models\peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $peran = Peran::where('is_deleted', '0')->get();
    return view('peran.index', [
    'peran' => $peran
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
            'nama_peran' => 'required', 
            ]);
            $array = $request->only([
            'nama_peran'
            ]);
            $peran = Peran::create($array);
            return redirect()->route('peran.index') 
            ->with('success_message', 'Data telah tersimpan');
            
    }


    /**
     * Display the specified resource.
     */
    public function show(peran $peran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(peran $peran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_peran)
{
    $request->validate([
        'nama_peran' =>'required',
    ]);
    $peran = Peran::find($id_peran);
    if ($peran) {
        $peran->nama_peran = $request->nama_peran;
        $peran->save();
        return redirect()->route('peran.index')->with('success_message', 'Data telah tersimpan');
    }
    // Tambahkan logika untuk penanganan jika data tidak ditemukan
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_peran)
    {
        $peran =  Peran::find($id_peran);
        if ($peran) {
            $peran->update([
                'is_deleted' => '1',
            ]);
        }
        return redirect()->route('peran.index')->with('success_message', 'Data telah terhapus');
    }
}