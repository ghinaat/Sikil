<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AjuanPerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->level == 'admin') {
            // Fetch the user's own work experiences
            $ajuanperizinan = Perizinan::where('is_deleted', '0')->get();
        }

        return view('perizinan.index', [
            'ajuanperizinan' => $ajuanperizinan,
            'users' => User::all(),
        ]);
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
        $request->validate([
            'id_atasan' => 'required',
            'kode_finger' => 'required',
            'jenis_perizinan' => 'required',
            // 'tgl_ajuan' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'keterangan' => 'required',
            'file_perizinan' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg',
            // 'status_izin_atasan' => 'required',
            // 'status_izin_ppk' => 'required',
        ]);
        
        // dd($request);
        
        $ajuanperizinan = new Perizinan();
        
        $file = $request->file('file_perizinan');
        
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('file_perizinan', $fileName, 'public');
        
        $ajuanperizinan->id_atasan = $request->id_atasan;
        $ajuanperizinan->kode_finger = $request->kode_finger;
        $ajuanperizinan->jenis_perizinan = $request->jenis_perizinan;
        $ajuanperizinan->tgl_ajuan = $request->tgl_ajuan;
        $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $ajuanperizinan->keterangan = $request->keterangan;
        $ajuanperizinan->file_perizinan = $fileName;    
        $ajuanperizinan->status_izin_atasan = null; // Default menunggu persetujuan
        $ajuanperizinan->status_izin_ppk = null; // Default menunggu persetujuan
        $ajuanperizinan->save();
        
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