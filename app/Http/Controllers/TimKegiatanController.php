<?php

namespace App\Http\Controllers;
use App\Models\TimKegiatan;
use App\Models\User;
use App\Models\Peran;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class TimKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['except' => ['index']]);
    }
    
    public function index()
    {
       
        $timkegiatan = TimKegiatan::all();
        return view('timkegiatan.index',  [
            'timkegiatan' => $timkegiatan,
            'user' => User::where('is_deleted', '0')->get(),
            'kegiatan' => Kegiatan::where('is_deleted', '0')->get(),
            'peran' => Peran::where('is_deleted', '0')->get(),
        ]);
            
    }

    public function store(Request $request)
    { 
        $request->validate([
        'id_kegiatan' => 'required', 
        'id_pegawai' => 'required', 
        'id_peran' => 'required', 
        ]);
        $array = $request->only([
            'id_kegiatan',
            'id_pegawai' ,
            'id_peran' ,
        
        ]);

        $timkegiatan = TimKegiatan::create($array);
        return redirect()->route('timkegiatan.index') ->with('success_message', 'Data telah tersimpan');
    } 

    public function update(Request $request, $id_tim)
    { 
 
        $request->validate([
            'id_kegiatan' => 'required', 
            'id_pegawai' => 'required', 
            'id_peran' => 'required', 
        ]);
        
        $timkegiatan = TimKegiatan::find($id_tim);
        $timkegiatan->id_kegiatan = $request->id_kegiatan;
        $timkegiatan->id_pegawai = $request->id_pegawai;
        $timkegiatan->id_peran = $request->id_peran;
        $timkegiatan->save();
        return redirect()->route('timkegiatan.index') ->with('success_message', 'Data telah tersimpan');
    } 

    public function destroy(Request $request, $id_tim)
    { 

        $timkegiatan = timkegiatan::find($id_tim);
        if ($timkegiatan) $timkegiatan->delete();
        return redirect()->back()->with('success_message', 'Data telah terhapus');

    }

    public function laporan(Request $request)
{
    $pegawai = $request->input('id_pegawai');
    $peran = $request->input('id_peran');
    if ($pegawai == 0) {
        $timkegiatan = TimKegiatan::get();   
}elseif ($pegawai && $peran && $peran != 0) {
        $timkegiatan = TimKegiatan::whereIn('id_pegawai', [$pegawai])
            ->where('id_peran', $peran)
            ->get();
    } elseif ($pegawai) {
        $timkegiatan = TimKegiatan::where('id_pegawai', $pegawai)
            ->get();
    } elseif ($peran) {
        $timkegiatan = TimKegiatan::where('id_peran', $peran)
            ->get();
    } elseif ($peran == 0) {
    // Jika memilih "All", ambil semua data dengan id_pegawai tertentu tanpa memperdulikan id_peran.
    $timkegiatan = TimKegiatan::where('id_pegawai', $pegawai)
        ->get();
} else {
        $timkegiatan = TimKegiatan::get();
    }

    return view('timkegiatan.laporan', [
        'timkegiatan' => $timkegiatan,
        'user' => User::where('is_deleted', '0')->get(),
        'peran' => Peran::where('is_deleted', '0')->get(),
    ]);
}


}