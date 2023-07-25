<?php

namespace App\Http\Controllers;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::where('is_deleted', '0')->get();
    return view('jabatan.index', [
    'jabatan' => $jabatan
    ]);
    }

    public function create()
    { 
    //Menampilkan Form Tambah User
    return view('jabatan.create');
    } 

    public function store(Request $request)
    { 
 //Menyimpan Data User Baru
    $request->validate([
    'nama_jabatan' => 'required', 
    ]);
    $array = $request->only([
    'nama_jabatan'
    ]);
    $jabatan = Jabatan::create($array);
    return redirect()->route('jabatan.index') 
    ->with('success_message', 'Data telah tersimpan');
    } 


public function update(Request $request, $id_jabatan)
{ 
//Mengedit Data Standar Kompetensi
$request->validate([
    'nama_jabatan' =>'required',
    ]);
    $jabatan = Jabatan::find($id_jabatan);
    $jabatan->nama_jabatan = $request->nama_jabatan;
    $jabatan->save();
    return redirect()->route('jabatan.index') ->with('success_message', 'Data telah tersimpan');
    } 

public function destroy($id_jabatan)
{
    $jabatan = Jabatan::find($id_jabatan);
    if ($jabatan) {
        $jabatan->update([
            'is_deleted' => '1',
        ]);
    }
    return redirect()->route('jabatan.index')->with('success_message', 'Data telah terhapus');
}

}