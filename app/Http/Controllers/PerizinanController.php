<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStaff()
    {
        $user = Auth::user();
        $perizinan = $user->perizinan()->with('user.setting')->get(); // Gunakan '()' setelah perizinan
        return view('izin.staff', [
            'perizinan' => $perizinan,
            'user' => User::where('is_deleted', '0')->get(),
        ]);
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function Pengajuan(Request $request)
    {
          //Menyimpan Data User Baru
        $request->validate([
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'file_perizinan' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $perizinan = new Perizinan();
        
        $file = $request->file('file_perizinan');
        $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->storeAs('perizinan', $fileName, 'public');
        
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->id_atasan = $request->id_atasan;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->file_perizinan = $fileName;

        $perizinan->save();

        return redirect()->route('izin.index')->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perizinan $perizinan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perizinan $perizinan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perizinan $perizinan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perizinan $perizinan)
    {
        //
    }
}