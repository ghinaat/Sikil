<?php

namespace App\Http\Controllers;
use App\Models\JenisDiklat;
use App\Models\Diklat;
use App\Models\User;
use Illuminate\Http\Request;

class DiklatController extends Controller
{

    public function index()
    {
        $diklat = Diklat::where('is_deleted', '0')->get();
        return view('diklat.index', [
            'diklat' => $diklat,
            'jenisdiklat' => JenisDiklat::all(),
            'user' => User::all(),
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required', 
            'id_jenis_diklat' => 'required', 
            'nama_diklat' => 'required', 
            'penyelenggara' => 'required', 
            'tanggal_diklat' => 'required', 
            'jp' => 'required', 
            'file_sertifikat' => 'required', 
        ]);


        $array = $request->only([
            'id_users', 'id_jenis_diklat', 'nama_diklat', 'penyelenggara', 'tanggal_diklat', 'jp', 'file_sertifikat'
        ]);

        // Periksa apakah ada file yang diunggah
        if ($request->hasFile('file_sertifikat')) {

            $file = $request->file('file_sertifikat');
        
            // Buat nama unik untuk file
            $nama_file = 'FT' . date('Ymdhis') . '.' . $file->getClientOriginalExtension();
        
            // Pindahkan file ke folder tujuan
            $file->move('dokumen/', $nama_file);
        
            // Simpan nama file ke dalam array
            $array['file_sertifikat'] = $nama_file;
        }

        // Buat data Diklat baru dan simpan ke dalam database
        $diklat = Diklat::create($array);

        return redirect()->route('diklat.index')
            ->with('success_message', 'Data telah tersimpan');
    }

    public function update(Request $request, Diklat $diklat)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diklat $diklat)
    {
        //
    }
}