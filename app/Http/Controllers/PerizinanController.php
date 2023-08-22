<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStaff()
    {
        $user = auth()->user();
        $perizinan =  $user->ajuanperizinans()->get(); // Ensure method name is lowercase 'perizinan'
    
        return view('izin.staff', [
            'perizinan' => $perizinan,
            'users' => User::where('is_deleted', '0')->get(),
            "settingperizinan" => User::with(['setting'])->get(),
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
            'kode_finger' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);
     
        $perizinan = new Perizinan();
        
        $file = $request->file('file_perizinan');
        $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->storeAs('perizinan', $fileName, 'public');
        $perizinan->kode_finger = $request->kode_finger;
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->jenis_perizinan = $request->jenis_perizinan;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->id_atasan = $request->id_atasan;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->file_perizinan = $fileName;
        $perizinan->status_izin_atasan = null;
        $perizinan->status_izin_ppk = null;

        $perizinan->save();   
     
        return redirect()->back()->with('success', 'Data telah tersimpan.');
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