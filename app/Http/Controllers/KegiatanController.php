<?php

namespace App\Http\Controllers;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('is_deleted', '0')->get();
    return view('kegiatan.index', [
    'kegiatan' => $kegiatan
    ]);
    }

    public function create()
    { 
    //Menampilkan Form Tambah User
    return view('kegiatan.create');
    } 

    public function show($id_kegiatan)
{
    // Mengambil kegiatan berdasarkan id_kegiatan
    $kegiatan = Kegiatan::findOrFail($id_kegiatan);

    return view('kegiatan.show', [
        'kegiatan' => $kegiatan
    ]);
}

    public function store(Request $request)
    { 
 //Menyimpan Data User Baru
    $request->validate([
    'nama_kegiatan' => 'required', 
    'tgl_mulai' => 'required', 
    'tgl_selesai' => 'required', 
    'lokasi' => 'required', 
    'peserta' => 'required', 
    ]);
    $array = $request->only([
    'nama_kegiatan',
    'tgl_mulai', 
    'tgl_selesai', 
    'lokasi' ,
    'peserta' 
    ]);
    $kegiatan = Kegiatan::create($array);
    return redirect()->route('kegiatan.index') 
    ->with('success_message', 'Berhasil menambah kegiatan baru');
    } 
    
    public function edit($id_kegiatan)
    {
    //Menampilkan Form Edit
    $kegiatan = Kegiatan::find($id_kegiatan);
    if (!$kegiatan) return redirect()->route('kegiatan.index')
    ->with('error_message', 'kategori wisata dengan id_kegiatan = '.$id_kegiatan.' tidak
    ditemukan');
    return view('kegiatan.edit', [
    'kegiatan' => $kegiatan
    ]);
    }   

    public function update(Request $request, $id_kegiatan)
    {
    //Mengedit Data Kategori Wisata
    $request->validate([
        'nama_kegiatan' => 'required', 
        'tgl_mulai' => 'required', 
        'tgl_selesai' => 'required', 
        'lokasi' => 'required', 
        'peserta' => 'required', 
    ]);
    $kegiatan = Kegiatan::find($id_kegiatan);
    
    $kegiatan->nama_kegiatan = $request->nama_kegiatan;
    $kegiatan->tgl_mulai = $request->tgl_mulai;
    $kegiatan->tgl_selesai = $request->tgl_selesai;
    $kegiatan->lokasi = $request->lokasi;
    $kegiatan->peserta = $request->peserta;
    $kegiatan->save();
    return redirect()->route('kegiatan.index')
    ->with('success_message', 'Berhasil mengubah kategori wisata');
    } 

    public function destroy($id_kegiatan)
{
    $kegiatan = Kegiatan::find($id_kegiatan);
    if ($kegiatan) {
        $kegiatan->update([
            'is_deleted' => '1',
        ]);
    }
    return redirect()->route('kegiatan.index')->with('success_message', 'Berhasil menghapus kategori wisata');
}
}