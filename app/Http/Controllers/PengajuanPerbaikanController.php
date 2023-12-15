<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPerbaikan;
use App\Models\BarangTik;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class PengajuanPerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $perbaikanBarang = PengajuanPerbaikan::where('is_deleted', '0')->get();

     return view('ajuanperbaikan.index', [
        'perbaikanBarang' => $perbaikanBarang,
        'barang'          => BarangTIK::where('is_deleted', '0')->orderByRaw("LOWER(nama_barang)")->get(),
        'user'            => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
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
    //   dd($request);
        //Menyimpan Data User Baru
        $request->validate([
            'id_users' => 'required',
            'id_barang_tik' => 'required',
            'keterangan_pemohon' => 'required',
        ]);
       
        $perbaikanBarang = new PengajuanPerbaikan();

        $perbaikanBarang->id_users = $request->id_users;
        $perbaikanBarang->id_barang_tik = $request->id_barang_tik;
        $perbaikanBarang->tgl_pengajuan = $request->tgl_pengajuan;
        $perbaikanBarang->keterangan_pemohon = $request->keterangan_pemohon;
        $perbaikanBarang->status = 'diajukan';
        
        $perbaikanBarang->save();
        $pengguna = User::where('id_users', $perbaikanBarang->id_users)->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan = 'Pengajuan Perbaikan Alat TIK anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuan anda.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'yes';
        $notifikasi->link = '/ajuanperbaikan';  
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

           $notifikasiKadiv = User::where('id_jabatan', '8')->get();


        foreach($notifikasiKadiv as $nk){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan =  'Pengajuan Perbaikan Alat TIK dari '.$pengguna->nama_pegawai.'. Dimohon untuk segera memperbaiki Alat TIK.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperbaikan';
        $notifikasi->send_email = 'yes';
        $notifikasi->id_users = $nk->id_users;
        $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->get();
        
        foreach($notifikasiAdmin as $na){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan =  'Pengajuan Perbaikan Alat TIK dari '.$pengguna->nama_pegawai.'. Dimohon untuk segera memperbaiki Alat TIK.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperbaikan';
        $notifikasi->send_email = 'no';
        $notifikasi->id_users = $na->id_users;
        $notifikasi->save();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_pengajuan_perbaikan)
    {
        $ajuanperbaikan = PengajuanPerbaikan::findOrFail($id_pengajuan_perbaikan);
    
        // Mengambil semua data BarangTik yang tersedia
        $users = User::where('is_deleted', '0')->get();
        $barang = BarangTIK::where('is_deleted', '0')->get();
        
        return view('ajuanperbaikan.show', [
            'ajuanperbaikan' => $ajuanperbaikan,
            'users' => $users,
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanPerbaikan $pengajuanPerbaikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id_pengajuan_perbaikan)
    {
        if (auth()->user()->level == 'admin') {
            // dd($request);
        $rules = [
      
            'id_barang_tik' => 'required',
            'keterangan_pemohon' => 'required',
            'tgl_pengecekan' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
            'status' => 'required',
            'nama_operator' => 'required',
            'keterangan_operator' => 'nullable',
        ];
       
        $perbaikanBarang = PengajuanPerbaikan::find($id_pengajuan_perbaikan);
        $request->validate($rules);
        $perbaikanBarang->nama_operator = $request->nama_operator;
        $perbaikanBarang->tgl_pengecekan = $request->tgl_pengecekan;
        $perbaikanBarang->id_barang_tik = $request->id_barang_tik;
        $perbaikanBarang->keterangan_pemohon = $request->keterangan_pemohon;
        $perbaikanBarang->status= $request->status;
        $perbaikanBarang->tgl_selesai= $request->tgl_selesai;
        $perbaikanBarang->keterangan_operator= $request->keterangan_operator;
        
        $perbaikanBarang->save();
        if($perbaikanBarang->status == "diproses"){
            $pengguna = User::where('id_users', $perbaikanBarang->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
            $notifikasi->pesan = 'Permintaan perbaikan perangkat TIK Anda sedang diproses. Harap menunggu pemberitahuan selanjutnya.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->send_email = 'no';
            $notifikasi->link = '/ajuanperbaikan';  
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();
        }elseif($perbaikanBarang->status == "selesai"){
        $pengguna = User::where('id_users', $perbaikanBarang->id_users)->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan = 'Pengajuan Perbaikan Alat TIK anda sudah diperbaiki. Harap menunggu alat segera diantarkan.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'yes';
        $notifikasi->link = '/ajuanperbaikan';  
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

           $notifikasiKadiv = User::where('id_jabatan', '8')->get();


        foreach($notifikasiKadiv as $nk){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan =  'Pengajuan Perbaikan Alat TIK dari '.$pengguna->nama_pegawai.' sudah diperbaiki. Dimohon untuk segera mengantarkan alat.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperbaikan';
        $notifikasi->send_email = 'yes';
        $notifikasi->id_users = $nk->id_users;
        $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->get();
        
        foreach($notifikasiAdmin as $na){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Perbaikan Alat TIK';
        $notifikasi->pesan =  'Pengajuan Perbaikan Alat TIK dari '.$pengguna->nama_pegawai.' sudah diperbaiki. Dimohon untuk segera mengantarkan alat.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperbaikan';
        $notifikasi->send_email = 'no';
        $notifikasi->id_users = $na->id_users;
        $notifikasi->save();
        }

        }
        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }else{
            $rules = [
      
                'id_barang_tik' => 'required',
                'keterangan_pemohon' => 'nullable',
                
            ];

            $perbaikanBarang = PengajuanPerbaikan::find($id_pengajuan_perbaikan);
            $request->validate($rules);
            $perbaikanBarang->id_barang_tik = $request->id_barang_tik;
            $perbaikanBarang->keterangan_pemohon = $request->keterangan_pemohon;
            $perbaikanBarang->save();
          
        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_pengajuan_perbaikan)
    {
        $perbaikanBarang = PengajuanPerbaikan::findOrFail($id_pengajuan_perbaikan);

        if ($perbaikanBarang) {
            $perbaikanBarang->update([
                'is_deleted' => '1',
            ]);
        }
        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}