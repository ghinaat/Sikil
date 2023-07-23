<?php

namespace App\Http\Controllers;
use App\Models\Kegiatan;
use App\Models\TimKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    
        // Mengambil tim kegiatan yang memiliki id_kegiatan yang sama dengan $id_kegiatan
        $timkegiatan = TimKegiatan::where('id_kegiatan', $id_kegiatan)->get();
    
        return view('kegiatan.show', [
            'kegiatan' => $kegiatan,
            'timkegiatan' => $timkegiatan
        ]);
    }

    public function store(Request $request)
    { 
        //Menyimpan Data User Baru
        $request->validate([
            'nama_kegiatan' => 'required', 
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'lokasi' => 'required', 
            'peserta' => 'required', 
        ]);
        
        $kegiatan = new Kegiatan();

        $kegiatan->nama_kegiatan = $request->nama_kegiatan;
        $kegiatan->tgl_mulai = $request->tgl_mulai;
        $kegiatan->tgl_selesai = $request->tgl_selesai;
        $kegiatan->lokasi = $request->lokasi;
        $kegiatan->peserta = $request->peserta;

        $kegiatan->save();
        return redirect()->route('kegiatan.index') ->with('success_message', 'Berhasil menambah kegiatan baru');
    } 
    
    public function edit($id_kegiatan)
    {
        //Menampilkan Form Edit
        $kegiatan = Kegiatan::find($id_kegiatan);
        if (!$kegiatan) return redirect()->route('kegiatan.index')->with('error_message', 'kegiatan dengan id_kegiatan = '.$id_kegiatan.' tidak ditemukan');
        return view('kegiatan.edit', [
            'kegiatan' => $kegiatan
        ]);
    }   

    public function update(Request $request, $id_kegiatan)
    {
        //Mengedit Data Kegiatan
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
        return redirect()->route('kegiatan.index')->with('success_message', 'Berhasil mengubah Kegiatan');
    } 

    public function destroy($id_kegiatan)
    {
        $kegiatan = Kegiatan::find($id_kegiatan);
        if ($kegiatan) {
            $kegiatan->update([
                'is_deleted' => '1',
            ]);
        }
        return redirect()->route('kegiatan.index')->with('success_message', 'Berhasil menghapus Kegiatan');
    }
}