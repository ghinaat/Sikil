<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\PengajuanForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PengajuanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form = PengajuanForm::where('is_deleted', '0')->get();
        // dd($form);
        return view('ajuanform.index', [
            'ajuanform' => $form,
        ]);
        
    }

    public function show($id_pengajuan_form)
    {
        $form = PengajuanForm::findOrFail($id_pengajuan_form);
        
        return view('ajuanform.show', [
            'form' => $form
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
            'jenis_form' => 'required',
            'nama_kegiatan'  => 'required',
            'tgl_digunakan'  => 'required',
            'bahasa'  => 'required',
            'template'  => 'nullable',
            'contoh'  => 'nullable',
            'shortlink'  => 'nullable',
            'kolaborator' => 'nullable',
            'keterangan_pemohon'  => 'nullable',
        ]);
        $form = new PengajuanForm();
        $form->id_users = $request->id_users;
        $form->jenis_form = $request->jenis_form ;
        $form->nama_kegiatan = $request->nama_kegiatan ;
        $form->tgl_digunakan = $request->tgl_digunakan ;
        $form->bahasa = $request->bahasa ;
        $form->contoh = $request->contoh ;
        $form->shortlink = $request->shortlink ;
        $form->kolaborator = $request->kolaborator ;
        $form->keterangan_pemohon = $request->keterangan_pemohon ;

        if($request->hasFile('template')) {
            $file = $request->file('template');
            $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->storeAs('template_form', $fileName, 'public');
            
            $form->template = $fileName;
        }
        $form->save();
        
        $pengguna = User::where('id_users', $request->id_users)->first();        
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Google Form';
        $notifikasi->pesan = 'Pengajuan google form anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'no';
        $notifikasi->link = '/ajuanform';  
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasiKadiv = User::where('id_jabatan', '8')->get();
        foreach($notifikasiKadiv as $nk){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Google Form';
        $notifikasi->pesan =  'Pengajuan google form ' .' dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara membuat google form.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanform';
        $notifikasi->send_email = 'yes';
        $notifikasi->id_users = $nk->id_users;
        $notifikasi->save();
        } 

        $notifikasiAdmin = User::where('level', 'admin')->get();
        foreach($notifikasiAdmin as $na){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Google Form';
        $notifikasi->pesan =  'Pengajuan google form '. ' dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara membuat google form.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanform';
        $notifikasi->send_email = 'no';
        $notifikasi->id_users = $na->id_users;
        $notifikasi->save();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanForm $pengajuanForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pengajuan_form)
    {
        // dd($request);
        if(auth()->user()->level == 'admin' ) {
        $request->validate([
            'jenis_form' => 'required',
            'nama_kegiatan'  => 'required',
            'bahasa'  => 'required',
            'template'  => 'nullable',
            'contoh'  => 'nullable',
            'shortlink'  => 'nullable',
            'kolaborator' => 'nullable',
            'keterangan_pemohon'  => 'nullable',
            'nama_operator'  => 'required',
            'status'  => 'required',
            'tautan_form'  => 'nullable',
        ]);
        $form = PengajuanForm::find($id_pengajuan_form);
        $form->jenis_form = $request->jenis_form ;
        $form->nama_kegiatan = $request->nama_kegiatan ;
        $form->bahasa = $request->bahasa ;
        $form->contoh = $request->contoh ;
        $form->shortlink = $request->shortlink ;
        $form->kolaborator = $request->kolaborator ;
        $form->keterangan_pemohon = $request->keterangan_pemohon ;
        $form->nama_operator = $request->nama_operator ;
        $form->status = $request->status ;
        
            if($request->tautan_form) {
                $form->tautan_form = $request->tautan_form ;
            } else {
                $form->tautan_form = null ;   
            }
        
            if($request->hasFile('template')) {
                if ($form->template) {
                    Storage::disk('public')->delete('template_form/'.$form->template);
                }
                $file = $request->file('template');
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('template_form', $fileName, 'public');
                
                $form->template = $fileName;
            }
            
        if($request->status == 'ready'){
            $pengguna = User::where('id_users', $form->id_users)->first();
            
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Google Form';
            $notifikasi->pesan = 'Pengajuan google form anda sudah dibuat.  Silahkan cek detail pengajuan google form anda.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->send_email = 'yes';
            $notifikasi->link = '/ajuanform';  
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();
            
        }
        $form->save();
        
        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        } else {
            $request->validate([
                'jenis_form' => 'required',
                'nama_kegiatan'  => 'required',
                'bahasa'  => 'required',
                'template'  => 'nullable',
                'contoh'  => 'nullable',
                'shortlink'  => 'nullable',
                'kolaborator' => 'nullable',
                'keterangan_pemohon'  => 'nullable',
            ]);
            $form = PengajuanForm::find($id_pengajuan_form);
            $form->jenis_form = $request->jenis_form ;
            $form->nama_kegiatan = $request->nama_kegiatan ;
            $form->bahasa = $request->bahasa ;
            $form->contoh = $request->contoh ;
            $form->shortlink = $request->shortlink ;
            $form->kolaborator = $request->kolaborator ;
            $form->keterangan_pemohon = $request->keterangan_pemohon ;
            if($request->hasFile('template')) {

                if ($form->template) {
                    Storage::disk('public')->delete('template_form/'.$form->template);
                }
                $file = $request->file('template');
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('template_form', $fileName, 'public');
                
                $form->template = $fileName;
            }
            $form->save();

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanForm $pengajuanForm)
    {
        //
    }
}