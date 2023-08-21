<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\User;
use App\Exports\CutiExport;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
    public function export(Request $request) 
    {
        // $cutis['data'][] = [
        //     'user' => Cuti::all()->nama_pegawai,
        //     'jabatan' => $jabatan->id_jabatan,
        //     'cutis' => $cuti->jatah_cuti,
        // ];

        $cutis = Cuti::all();

        return Excel::download(new CutiExport($cutis), 'cuti.xlsx');
    }
    public function index()
    {
        $cuti = Cuti::where('is_deleted', '0')->get();

        $cutis = Cuti::all();
        $users = User::all();

        return view('cuti.index', compact('cutis', 'users'));
    }

    public function create()
    {
        $users = User::all();

        return view('cuti.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required',
            'jatah_cuti' => 'required|integer',
        ]);

        Cuti::create($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil ditambahkan');
    }

    public function edit(Cuti $cuti)
    {
        $users = User::all();
        return view('cuti.edit', compact('cuti', 'users'));
    }

    public function update(Request $request,  $id_cuti)
    {
        $validatedData = $request->validate([
            'id_users' => 'required',
            'jatah_cuti' => 'required|integer',
        ]);

        $cuti = Cuti::find($id_cuti);

        $cuti->id_users = $request->id_users;
        $cuti->jatah_cuti = $request->jatah_cuti;

        $cuti->save();

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diperbarui');
    }

    public function destroy(Cuti $cuti)
    {
        $cuti->delete();

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dihapus');
    }
}
