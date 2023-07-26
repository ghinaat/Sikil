<?php

namespace App\Http\Controllers;

use App\Models\JenisDiklat;
use Illuminate\Http\Request;

class JenisDiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisdiklat = JenisDiklat::where('is_deleted', '0')->get();
        return view('jenisdiklat.index', [
        'jenisdiklat' => $jenisdiklat
        ]);
    }
        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_diklat' => 'required', 
            ]);
            $array = $request->only([
            'nama_jenis_diklat'
            ]);
            $jenisdiklat = JenisDiklat::create($array);
            return redirect()->route('jenisdiklat.index') 
            ->with('success_message', 'Data telah tersimpan');
    }


    public function update(Request $request, $id_jenis_diklat)
    {
        $request->validate([
            'nama_jenis_diklat' =>'required',
            ]);
            $jenisdiklat = JenisDiklat::find($id_jenis_diklat);
            $jenisdiklat->nama_jenis_diklat = $request->nama_jenis_diklat;
            $jenisdiklat->save();
            return redirect()->route('jenisdiklat.index') ->with('success_message', 'Data telah tersimpan');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_jenis_diklat)
{
    $jenisdiklat = JenisDiklat::find($id_jenis_diklat);
    if ($jenisdiklat) {
        $jenisdiklat->update([
            'is_deleted' => '1',
        ]);
    }
    return redirect()->route('jenisdiklat.index')->with('success_message', 'Data telah terhapus');
}

}