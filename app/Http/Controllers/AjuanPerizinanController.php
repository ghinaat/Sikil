<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        // dd($request);
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
    public function update(Request $request, $id_perizinan)
    {
        $rules = [
            'id_atasan' => 'required',
            'jenis_perizinan' => 'required',
            // 'tgl_ajuan' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'keterangan' => 'required',
            'status_izin_atasan' => 'required',
            'status_izin_ppk' => 'required',
        ];

        if($request->file('file_perizinan')){
            $rules['file_perizinan'] = 'required|mimes:pdf,doc,docx,png,jpg,jpeg'; 
        }

        if($request->status_izin_atasan === '0'){
            $rules['alasan_ditolak_atasan'] = 'required'; 
        }

        if($request->status_ditolak_ppk === '0'){
            $rules['alasan_ditolak_ppk'] = 'required'; 
        }
        $request->validate($rules);
        
        $ajuanperizinan = Perizinan::find($id_perizinan);
        
        if (! $ajuanperizinan) {
            return redirect()->route('ajuanperizinan.index')->with('error_message', 'Data tidak ditemukan');
        }
        // dd($ajuanperizinan);
        
        $ajuanperizinan->id_atasan = $request->id_atasan;
        $ajuanperizinan->jenis_perizinan = $request->jenis_perizinan;
        $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $ajuanperizinan->keterangan = $request->keterangan;
        $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;
        $ajuanperizinan->status_izin_ppk = $request->status_izin_ppk;
        
        if($request->status_izin_atasan === '0'){
            $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
        }
        
        if($request->status_izin_ppk === '0'){
            $ajuanperizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
        }
        // dd($request, $ajuanperizinan);
        
        if ($request->hasFile('file_perizinan')) {
            // Menghapus file file_perizinan sebelumnya
            if ($ajuanperizinan->file_perizinan) {
                Storage::disk('public')->delete('file_perizinan/'.$ajuanperizinan->file_perizinan);
            }
            
            // Upload file file_perizinan baru
            $file_perizinan = $request->file('file_perizinan');
            $namafile_perizinan = time().'.'.$file_perizinan->getClientOriginalExtension();
            Storage::disk('public')->put('file_perizinan/'.$namafile_perizinan, file_get_contents($file_perizinan));
            $ajuanperizinan->file_perizinan = $namafile_perizinan;
        }
        
        $ajuanperizinan->save();
        
        return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perizinan $perizinan)
    {
        //
    }
}