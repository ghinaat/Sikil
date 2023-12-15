<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDesain;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengajuanDesainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $ajuandesain = PengajuanDesain::where('is_deleted', '0')->orderByDesc('id_pengajuan_desain')->get();

        return view('ajuandesain.index', [
            'ajuandesain' => $ajuandesain,
            'users' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
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
            'id_users'=> 'required',
            'jenis_desain'=> 'required',
            'nama_kegiatan'=> 'required',
            'tempat_kegiatan'=> 'required',
            'tgl_kegiatan'=> 'required',
            'tgl_digunakan'=> 'required',
            'ukuran'=> 'nullable',
            'no_sertifikat'=> 'nullable',
            'lampiran_pendukung'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,zip,xlsx',
            'lampiran_qrcode'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,zip,xlsx',
            'keterangan_pemohon'=> 'nullable',
        ]);

        $ajuandesain = new PengajuanDesain();
    
            $ajuandesain->id_users = $request->id_users;
            $ajuandesain->jenis_desain = $request->jenis_desain;
            $ajuandesain->nama_kegiatan = $request->nama_kegiatan;
            $ajuandesain->tempat_kegiatan = $request->tempat_kegiatan;
            $ajuandesain->tgl_kegiatan = $request->tgl_kegiatan;
            $ajuandesain->tgl_digunakan = $request->tgl_digunakan;
            $ajuandesain->ukuran = $request->ukuran;
            $ajuandesain->no_sertifikat = $request->no_sertifikat;
            $ajuandesain->keterangan_pemohon = $request->keterangan_pemohon;

            if($request->hasFile('lampiran_pendukung')) {
                $file = $request->file('lampiran_pendukung');
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('lampiran_pendukung_desain', $fileName, 'public');
                
                $ajuandesain->lampiran_pendukung = $fileName;
            }

            if($request->hasFile('lampiran_qrcode')) {
                $file = $request->file('lampiran_qrcode');
                $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->storeAs('lampiran_qrcode_desain', $fileName, 'public');
                
                $ajuandesain->lampiran_qrcode = $fileName;
            }

            $ajuandesain->save();

            $pengguna = User::where('id_users', $request->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Desain';
            $notifikasi->pesan = 'Pengajuan Desain anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuandesain';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            $notifikasiKadiv = User::where('id_jabatan', '9 ')->get();
            foreach($notifikasiKadiv as $nk){
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Desain';
            $notifikasi->pesan =  'Pengajuan Desain dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; 
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuandesain';
            $notifikasi->send_email = 'yes';
            $notifikasi->id_users = $nk->id_users;
            $notifikasi->save();
            }
    
            $notifikasiAdmin = User::where('level', 'admin')->get();
            foreach($notifikasiAdmin as $na){
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Desain';
            $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuandesain';
            $notifikasi->id_users = $na->id_users;
            $notifikasi->save();
            }
    
            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_pengajuan_desain)
    {
        $ajuandesain = PengajuanDesain::findOrFail($id_pengajuan_desain);
        $users = User::where('is_deleted', '0')->get();

        return view('ajuandesain.show', [
            'ajuandesain' => $ajuandesain,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanDesain $pengajuanDesain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id_pengajuan_desain)
    {
        if(auth()->user()->level == 'admin' || auth()->user()->level == 'kadiv') {
            $request->validate([
                'jenis_desain'=> 'required',
                'nama_kegiatan'=> 'required',
                'tempat_kegiatan'=> 'required',
                'tgl_kegiatan'=> 'required',
                'tgl_digunakan'=> 'required',
                'ukuran'=> 'nullable',
                'no_sertifikat'=> 'nullable',
                'lampiran_pendukung'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,zip,xlsx',
                'lampiran_qrcode'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,zip,xlsx',
                'keterangan_pemohon'=> 'required',
                'lampiran_desain'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,zip,xlsx',
                'keterangan'=> 'required',
                'status'=> 'required'
                ]);

                $ajuandesain = PengajuanDesain::find($id_pengajuan_desain);
    
                $ajuandesain->jenis_desain = $request->jenis_desain;
                $ajuandesain->nama_kegiatan = $request->nama_kegiatan;
                $ajuandesain->tempat_kegiatan = $request->tempat_kegiatan;
                $ajuandesain->tgl_kegiatan = $request->tgl_kegiatan;
                // Menggunakan Carbon untuk menangani format tanggal
                $tgl_digunakan = Carbon::createFromFormat('d M Y', $request->tgl_digunakan);
                $ajuandesain->tgl_digunakan = $tgl_digunakan->toDateString();
                $ajuandesain->ukuran = $request->ukuran;
                $ajuandesain->no_sertifikat = $request->no_sertifikat;
                $ajuandesain->keterangan_pemohon = $request->keterangan_pemohon;
                $ajuandesain->keterangan = $request->keterangan;
                $ajuandesain->status = $request->status;

                if($request->hasFile('lampiran_desain')) {
                    if ($ajuandesain->lampiran_desain) {
                        Storage::disk('public')->delete('lampiran_desain/'.$ajuandesain->lampiran_desain);}
                    $file = $request->file('lampiran_desain');
                    $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->storeAs('lampiran_desain', $fileName, 'public');
                    
                    $ajuandesain->lampiran_desain = $fileName;
                }

                if($request->hasFile('lampiran_pendukung')) {
                    if ($ajuandesain->lampiran_pendukung) {
                        Storage::disk('public')->delete('lampiran_pendukung_desain/'.$ajuandesain->lampiran_pendukung);}
                    $file = $request->file('lampiran_pendukung');
                    $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->storeAs('lampiran_pendukung_desain', $fileName, 'public');
                    
                    $ajuandesain->lampiran_pendukung = $fileName;
                }
    
                if($request->hasFile('lampiran_qrcode')) {
                    if ($ajuandesain->lampiran_qrcode) {
                        Storage::disk('public')->delete('lampiran_qrcode_desain/'.$ajuandesain->lampiran_qrcode);}
                    $file = $request->file('lampiran_qrcode');
                    $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->storeAs('lampiran_qrcode_desain', $fileName, 'public');
                    
                    $ajuandesain->lampiran_qrcode = $fileName;
                }

                $ajuandesain->save();

                if($ajuandesain->status == 'diproses'){
                    $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Pengajuan Desain';
                    $notifikasi->pesan = 'Pengajuan Desain anda sedang dalam proses pengerjaan. Silahkan cek detail pengajuan desain anda.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->send_email = 'no';
                    $notifikasi->link = '/ajuandesain';  
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();
                }

                if($ajuandesain->status == 'dicek_kadiv'){
                $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                $notifikasiKadiv = User::where('id_jabatan', '9')->get();
                foreach($notifikasiKadiv as $nk) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Pengajuan Desain';
                    $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; 
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/ajuandesain';
                    $notifikasi->send_email = 'no';
                    $notifikasi->id_users = $nk->id_users;
                    $notifikasi->save();
                }
            }

            if($ajuandesain->status == 'disetujui_kadiv'){
                $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Desain';
                $notifikasi->pesan = 'Pengajuan Desain anda telah disetujui. Silahkan cek detail pengajuan desain anda.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'yes';
                $notifikasi->link = '/ajuandesain';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();

                $notifikasiAdmin = User::where('level', 'admin')->get();
                foreach($notifikasiAdmin as $na){
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Desain';
                $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.' telah disetujui. Silahkan cek detail pengajuan desain pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->send_email = 'no';
                $notifikasi->label = 'info';
                $notifikasi->link = '/ajuandesain';
                $notifikasi->id_users = $na->id_users;
                $notifikasi->save();
                }    
            }

            if($ajuandesain->status == 'revisi'){
                $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                $notifikasiAdmin = User::where('level', 'admin')->get();
                foreach($notifikasiAdmin as $na){
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Desain';
                $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.' perlu direvisi. Silahkan cek detail pengajuan desain pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->send_email = 'no';
                $notifikasi->label = 'info';
                $notifikasi->link = '/ajuandesain';
                $notifikasi->id_users = $na->id_users;
                $notifikasi->save();
                }    
            }

            if($ajuandesain->status == 'selesai'){
                $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Desain';
                $notifikasi->pesan = 'Pengajuan Desain anda sudah dibuat. Silahkan cek detail pengajuan desain anda.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'no';
                $notifikasi->link = '/ajuandesain';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();
            }

            if($ajuandesain->status == 'selesai'){
                $notifikasiAdmin = User::where('level', 'admin')->get();
                foreach($notifikasiAdmin as $na){
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Desain';
                $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.' telah dibuat. Silahkan cek detail pengajuan desain pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->send_email = 'no';
                $notifikasi->label = 'info';
                $notifikasi->link = '/ajuandesain';
                $notifikasi->id_users = $na->id_users;
                $notifikasi->save();
                }    
            }

            if($ajuandesain->status == 'selesai'){
                $notifikasiKadiv = User::where('id_jabatan', '9')->get();
                $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                foreach($notifikasiKadiv as $nk) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Pengajuan Desain';
                    $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.' telah dibuat. Silahkan cek detail pengajuan desain pemohon.'; 
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/ajuandesain';
                    $notifikasi->send_email = 'no';
                    $notifikasi->id_users = $nk->id_users;
                    $notifikasi->save();
                }
            }



                return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    
            } else {
                $request->validate([
                    'jenis_desain'=> 'required',
                    'nama_kegiatan'=> 'required',
                    'tempat_kegiatan'=> 'required',
                    'tgl_kegiatan'=> 'required',
                    'tgl_digunakan'=> 'required',
                    'ukuran'=> 'nullable',
                    'no_sertifikat'=> 'nullable',
                    'lampiran_pendukung'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,zip',
                    'lampiran_qrcode'=> 'nullable|mimes:jpeg,jpg,png,pdf,doc,zip',
                    'keterangan_pemohon'=> 'nullable',
                    'status'=> 'required'
                    ]);
        
                $ajuandesain = PengajuanDesain::find($id_pengajuan_desain);
    
                $ajuandesain->jenis_desain = $request->jenis_desain;
                $ajuandesain->nama_kegiatan = $request->nama_kegiatan;
                $ajuandesain->tempat_kegiatan = $request->tempat_kegiatan;
                $ajuandesain->tgl_kegiatan = $request->tgl_kegiatan;
               // Menggunakan Carbon untuk menangani format tanggal
                $tgl_digunakan = Carbon::createFromFormat('d M Y', $request->tgl_digunakan);
                $ajuandesain->tgl_digunakan = $tgl_digunakan->toDateString();
                $ajuandesain->ukuran = $request->ukuran;
                $ajuandesain->no_sertifikat = $request->no_sertifikat;
                $ajuandesain->keterangan_pemohon = $request->keterangan_pemohon;
                $ajuandesain->status = $request->status;


                if($request->hasFile('lampiran_pendukung')) {
                    if ($ajuandesain->lampiran_pendukung) {
                        Storage::disk('public')->delete('lampiran_pendukung_desain/'.$ajuandesain->lampiran_pendukung);}
                    $file = $request->file('lampiran_pendukung');
                    $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->storeAs('lampiran_pendukung_desain', $fileName, 'public');
                    
                    $ajuandesain->lampiran_pendukung = $fileName;
                }
    
                if($request->hasFile('lampiran_qrcode')) {
                    if ($ajuandesain->lampiran_qrcode) {
                        Storage::disk('public')->delete('lampiran_qrcode_desain/'.$ajuandesain->lampiran_qrcode);}
                    $file = $request->file('lampiran_qrcode');
                    $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->storeAs('lampiran_qrcode_desain', $fileName, 'public');
                    
                    $ajuandesain->lampiran_qrcode = $fileName;
                }

                $ajuandesain->save();
    
                if($ajuandesain->status == 'selesai'){
                    $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Pengajuan Ajuan Desain';
                    $notifikasi->pesan = 'Pengajuan Ajuan Desain anda sudah dibuat. Silahkan cek detail pengajuan desain anda.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->link = '/ajuandesain';  
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();
                }

                if($ajuandesain->status == 'revisi'){
                    $pengguna = User::where('id_users', $ajuandesain->id_users)->first();
                    $notifikasiAdmin = User::where('level', 'admin')->get();
                    foreach($notifikasiAdmin as $na){
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Pengajuan Desain';
                    $notifikasi->pesan = 'Pengajuan Desain dari '.$pengguna->nama_pegawai.' perlu direvisi. Silahkan cek detail pengajuan desain pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'no';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/ajuandesain';
                    $notifikasi->id_users = $na->id_users;
                    $notifikasi->save();
                    }    
                }
                            
                return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengajuan_desain)
    {
        $ajuandesain = PengajuanDesain::find($id_pengajuan_desain);
        if ($ajuandesain) {
            $ajuandesain->is_deleted = '1';
            $ajuandesain->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}
