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
    ->with('success_message', 'Berhasil menambah jabatan baru');
    } 

    public function edit($id_jabatan)
{
    $jabatan = Jabatan::find($id_jabatan);
    if (!$jabatan) {
        return redirect()->route('jabatan.index')->with('error_message', 'Jabatan dengan id = '.$id_jabatan.' tidak ditemukan');
    }
    return view('jabatan.edit', [
        'jabatan' => $jabatan
    ]);
}

public function destroy($id_jabatan)
{
    $jabatan = Jabatan::find($id_jabatan);
    if ($jabatan) {
        $jabatan->update([
            'is_deleted' => '1',
        ]);
    }
    return redirect()->route('jabatan.index')->with('success_message', 'Berhasil menghapus kategori wisata');
}

}