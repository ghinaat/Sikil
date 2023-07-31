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
            'kegiatan' => Kegiatan::all(),
            'peran' => Peran::all(),
        ]);
            
    }

    public function store(Request $request)
    { 
        $request->validate([
        'id_kegiatan' => 'required', 
        'id_users' => 'required', 
        'id_peran' => 'required', 
        ]);
        $array = $request->only([
            'id_kegiatan',
            'id_users' ,
            'id_peran' ,
        
        ]);

        $timkegiatan = TimKegiatan::create($array);
        return redirect()->route('timkegiatan.index') ->with('success_message', 'Data telah tersimpan');
    } 

    public function update(Request $request, $id_tim)
    { 
 
        $request->validate([
            'id_kegiatan' => 'required', 
            'id_users' => 'required', 
            'id_peran' => 'required', 
        ]);
        
        $timkegiatan = TimKegiatan::find($id_tim);
        $timkegiatan->id_kegiatan = $request->id_kegiatan;
        $timkegiatan->id_users = $request->id_users;
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

   


}