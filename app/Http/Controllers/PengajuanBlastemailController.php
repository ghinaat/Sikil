<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\PengajuanBlastemail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PengajuanBlastemailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (auth()->user()->level == 'kadiv' && auth()->user()->id_jabatan == '8' ) {
            $BlastEmail = PengajuanBlastemail::where('is_deleted', '0')->get();
        } elseif(auth()->user()->level == 'admin' ) {
            $BlastEmail = PengajuanBlastemail::where('is_deleted', '0')->get();
        }else{
            $BlastEmail = PengajuanBlastemail::where('is_deleted', '0')->whereIn('id_users', $user->pengajualBlastemail->pluck('id_users'))->get();
        }        
        
        return view('ajuanblastemail.index', [
            'BlastEmail' => $BlastEmail
        ]);
    }
    public function show($id_pengajuan_blastemail)
    {
        $BlastEmail = PengajuanBlastemail::findOrFail($id_pengajuan_blastemail);
        
        return view('ajuanblastemail.show', [
            'BlastEmail' => $BlastEmail
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
            'id_users' => 'required',
            'jenis_blast' => 'required',
            'nama_kegiatan' => 'required',
            'keterangan_pemohon' => 'required',
            'lampiran' => 'required|mimes:doc,docx,xlsx,zip',
            
        ]);
        
        $ajuanBlast = new PengajuanBlastemail();
        $ajuanBlast->id_users = $request->id_users;
        $ajuanBlast->jenis_blast = $request->jenis_blast;
        $ajuanBlast->nama_kegiatan = $request->nama_kegiatan;
        $ajuanBlast->keterangan_pemohon = $request->keterangan_pemohon;
        
        if($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->storeAs('lampiran_blast_email', $fileName, 'public');
            
            $ajuanBlast->lampiran = $fileName;
        }
        
        $ajuanBlast->save();


        $pengguna = User::where('id_users', $request->id_users)->first();
        $jenisBlast = $request->input('jenis_blast');
        
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Blast Email';
        $notifikasi->pesan = 'Pengajuan blast email anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'no';
        $notifikasi->link = '/ajuanblastemail';  
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasiKadiv = User::where('id_jabatan', '8')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Blast Email';
        $notifikasi->pesan =  'Pengajuan blast email '.$jenisBlast.' dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara mengirimkan blast email.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanblastemail';
        $notifikasi->send_email = 'yes';
        $notifikasi->id_users = $notifikasiKadiv->id_users;
        $notifikasi->save();

        $notifikasiAdmin = User::where('level', 'admin')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Blast Email';
        $notifikasi->pesan =  'Pengajuan blast email '.$jenisBlast.' dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara mengirimkan blast email.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanblastemail';
        $notifikasi->send_email = 'no';
        $notifikasi->id_users = $notifikasiAdmin->id_users;
        $notifikasi->save();
       

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanBlastemail $pengajuanBlastemail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id_pengajuan_blastemail)
    {
        if(auth()->user()->level == 'admin' ) {
        $request->validate([
            'jenis_blast' => 'required',
            'nama_kegiatan' => 'required',
            'keterangan_pemohon' => 'required',
            'lampiran' => 'nullable|mimes:doc,docx,xlsx,zip',
            'nama_operator' => 'required',
            'status' => 'required',
            'keterangan_operator'=> 'required',
            'tgl_kirim' => 'required|date|after_or_equal:tgl_pengajuan',

        ]);

        $ajuanBlast = PengajuanBlastemail::find($id_pengajuan_blastemail);

        $ajuanBlast->jenis_blast = $request->jenis_blast;
        $ajuanBlast->nama_kegiatan = $request->nama_kegiatan;
        $ajuanBlast->keterangan_pemohon = $request->keterangan_pemohon;
        $ajuanBlast->nama_operator =  $request->nama_operator;
        $ajuanBlast->status =  $request->status;
        $ajuanBlast->keterangan_operator = $request->keterangan_operator;
        $ajuanBlast->tgl_kirim = $request->tgl_kirim;
        
        if($request->hasFile('lampiran')) {

            if ($ajuanBlast->lampiran) {
                Storage::disk('public')->delete('lampiran_blast_email/'.$ajuanBlast->lampiran);
            }
            $file = $request->file('lampiran');
            $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->storeAs('lampiran_blast_email', $fileName, 'public');
            
            $ajuanBlast->lampiran = $fileName;
        }
        // dd($request);
        $ajuanBlast->save();
            if($request->status == 'selesai'){
                $pengguna = User::where('id_users', $ajuanBlast->id_users)->first();
                
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Blast Email';
                $notifikasi->pesan = 'Pengajuan blast email anda sudah dibuat.  Silahkan cek detail pengajuan blast email anda.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'yes';
                $notifikasi->link = '/ajuanblastemail';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();
        
            }
                

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
            
        
        } else {
            $request->validate([
                'jenis_blast' => 'required',
                'nama_kegiatan' => 'required',
                'keterangan_pemohon' => 'required',
                'lampiran' => 'nullable|mimes:docx,xlsx,zip',
    
            ]);
    
            $ajuanBlast = PengajuanBlastemail::find($id_pengajuan_blastemail);
    
            $ajuanBlast->jenis_blast = $request->jenis_blast;
            $ajuanBlast->nama_kegiatan = $request->nama_kegiatan;
            $ajuanBlast->keterangan_pemohon = $request->keterangan_pemohon;
            
            if($request->hasFile('lampiran')) {
    
                // Menghapus file file_sertifikat sebelumnya
                if ($ajuanBlast->lampiran) {
                    Storage::disk('public')->delete('lampiran_blast_email/'.$ajuanBlast->lampiran);
                }
    
                $file = $request->file('lampiran');
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('lampiran_blast_email', $fileName, 'public');
                
                $ajuanBlast->lampiran = $fileName;
            }
            // dd($request);
            $ajuanBlast->save();
            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengajuan_blastemail)
    {
        $ajuanBlast = PengajuanBlastemail::find($id_pengajuan_blastemail);
        if($ajuanBlast){
            $ajuanBlast->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
    
        //
    
}