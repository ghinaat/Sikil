<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStaff()
    {
        $user = auth()->user();
        $perizinan = Perizinan::where('is_deleted', '0')
        ->whereIn('kode_finger', $user->ajuanperizinans->pluck('kode_finger'))
        ->get();
    
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
            'jumlah_hari_pengajuan' => 'required',
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);
    
        $perizinan = new Perizinan();
    
        // Temukan pengguna berdasarkan kode finger
        $pengguna = User::where('kode_finger', $request->kode_finger)->first();
    
        if (!$pengguna) {
            return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
        }
    
        // Hitung jumlah hari pengajuan
        $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
            $request->tgl_absen_awal,
            $request->tgl_absen_akhir
        );
    
        // Periksa apakah jatah cuti tahunan mencukupi
        if ($request->jenis_perizinan === 'CT' && $pengguna->cuti) {
            if ($pengguna->cuti->jatah_cuti < $jumlah_hari_pengajuan) {
                return redirect()->back()->with('error', 'Jatah cuti tidak mencukupi untuk pengajuan ini.');
            }
        }
    
        if ($request->hasFile('file_perizinan')) {
            // Upload dan simpan file jika ada
            $file_perizinan = $request->file('file_perizinan');
            $namafile_perizinan = Str::random(10) . '.' . $file_perizinan->getClientOriginalExtension();
            Storage::disk('public')->put('file_perizinan/' . $namafile_perizinan, file_get_contents($file_perizinan));
            $perizinan->file_perizinan = $namafile_perizinan;
        } else {
            $perizinan->file_perizinan = null; // Atur kolom file_perizinan menjadi NULL jika tidak ada file diunggah
        }
    
        $perizinan->kode_finger = $request->kode_finger;
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->jenis_perizinan = $request->jenis_perizinan;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->jumlah_hari_pengajuan = $jumlah_hari_pengajuan;
        $perizinan->id_atasan = $request->id_atasan;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->status_izin_atasan = null;
        $perizinan->status_izin_ppk = null;
    
        $perizinan->save();
    
        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
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
            'kode_finger' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'jumlah_hari_pengajuan' => 'required',
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ];
        $request->validate($rules);
         
        $perizinan = Perizinan::find($id_perizinan);
        // dd($request, $rules, $perizinan);
        
        if ($request->hasFile('file_perizinan')) {
            // Menghapus file file_perizinan sebelumnya
            if ($perizinan->file_perizinan) {
                Storage::disk('public')->delete('file_perizinan/'.$perizinan->file_perizinan);
            }
            
            // Upload file file_perizinan baru
            $file_perizinan = $request->file('file_perizinan');
            $namafile_perizinan = Str::random(10).'.'.$file_perizinan->getClientOriginalExtension();
            Storage::disk('public')->put('file_perizinan/'.$namafile_perizinan, file_get_contents($file_perizinan));
            $perizinan->file_perizinan = $namafile_perizinan;
        }
        $perizinan->kode_finger = $request->kode_finger;
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->jenis_perizinan = $request->jenis_perizinan;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        $perizinan->id_atasan = $request->id_atasan;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->status_izin_atasan = null;
        $perizinan->status_izin_ppk = null;
      
        $perizinan->save();   
     
        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_perizinan)
    {
        $perizinan = Perizinan::find($id_perizinan);
        if ($perizinan) {
            $perizinan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }
}