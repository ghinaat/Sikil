<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Peran;
use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Http\Request;

class TimKegiatanController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('isAdmin', ['except' => ['index']]);
    // }

    public function index()
    {
        $kegiatan = Kegiatan::whereYear('tgl_mulai', '=', now()->year)
        ->orderBy('tgl_mulai', 'desc')
        ->get(); 
    
        $timkegiatan = TimKegiatan::all();

        return view('timkegiatan.index', [
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
            'id_users' => 'required',
            'id_peran' => 'required',
        ]);
        $array = $request->only([
            'id_kegiatan',
            'id_users',
            'id_peran',

        ]);

        $timkegiatan = TimKegiatan::create($array);

        return redirect()->route('timkegiatan.index')->with('success_message', 'Data telah tersimpan');
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

        return redirect()->route('timkegiatan.index')->with('success_message', 'Data telah tersimpan');
    }

    public function destroy(Request $request, $id_tim)
    {

        $timkegiatan = timkegiatan::find($id_tim);
        if ($timkegiatan) {
            $timkegiatan->delete();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus');

    }

    public function laporan(Request $request)
    {

        $pegawai = $request->input('id_users');
        $peran = $request->input('id_peran');

        // Store the selected values in session
        session()->put('selected_id_users', $pegawai);
        session()->put('selected_id_peran', $peran);

        if ($pegawai && $peran && $peran != 0) {
            $timkegiatan = TimKegiatan::whereIn('id_users', [$pegawai])
                ->where('id_peran', $peran)
                ->get();

        } elseif ($pegawai) {
            $timkegiatan = TimKegiatan::where('id_users', $pegawai)
                ->get();
        } elseif ($peran) {
            $timkegiatan = TimKegiatan::where('id_peran', $peran)
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
