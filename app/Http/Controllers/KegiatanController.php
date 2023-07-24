<?php

namespace App\Http\Controllers;
use App\Models\Kegiatan;
use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('is_deleted', '0')->get();
        return view('kegiatan.index', [
            'kegiatan' => $kegiatan,
            'timkegiatan' => TimKegiatan::all()
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
    
        // Mengambil semua data user yang belum terkait dengan TimKegiatan
        $users = User::where('is_deletd', '0')->get();

    
        // Mengambil tim kegiatan yang terkait dengan kegiatan tertentu dengan eager loading untuk relasi user
        $timkegiatan = TimKegiatan::with('user')->where('id_kegiatan', $id_kegiatan)->get();
    
        return view('kegiatan.show', [
            'kegiatan' => $kegiatan,
            'users' => $users,
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

    public function storeTimKegiatan(Request $request)
    {
        // Validasi data yang dikirimkan melalui form
        $request->validate([
            'id_kegiatan' => 'required',
            'id_pegawai' => 'required',
            'peran' => 'required',
        ]);

        // Simpan data ke dalam tabel tim_kegiatan
        $timKegiatan = TimKegiatan::create([
            'id_kegiatan' => $request->input('id_kegiatan'),
            'id_pegawai' => $request->input('id_pegawai'),
            'peran' => $request->input('peran'),
        ]);

        // Redirect atau lakukan tindakan lain setelah data berhasil disimpan
        return redirect()->route('kegiatan.index')->with('success_message', 'Berhasil menambah Tim Kegiatan baru');
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

    public function destroyTimKegiatan($id_tim)
    {
        try {
            // Cari TimKegiatan berdasarkan ID
            $timKegiatan = TimKegiatan::findOrFail($id_tim);

            // Hapus TimKegiatan
            $timKegiatan->delete();

            return redirect()->back()->with('success_message', 'Berhasil menghapus Tim Kegiatan');
        } catch (\Exception $e) {
            // Handle jika terjadi error saat menghapus
            return redirect()->back()->with('error_message', 'Gagal menghapus Tim Kegiatan');
        }
    }   
}