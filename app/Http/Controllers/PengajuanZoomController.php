<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\PengajuanZoom;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class PengajuanZoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (auth()->user()->level == 'kadiv' && auth()->user()->id_jabatan == '8' ) {
            $zoom = PengajuanZoom::where('is_deleted', '0')->get();
        } elseif(auth()->user()->level == 'admin' ) {
            $zoom = PengajuanZoom::where('is_deleted', '0')->get();
        }else{
            $zoom = PengajuanZoom::where('is_deleted', '0')->whereIn('id_users', $user->zoom->pluck('id_users'))->get();
        }

        return view('ajuanzoom.index', [
            'zoom' => $zoom,
            'user' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
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
            'tgl_pelaksanaan' => 'required|date',
            'jam_mulai' => 'required',
            'jenis_zoom' => 'required',
            'jam_selesai' => 'required',
            'nama_kegiatan' => 'required',
            'jumlah_peserta' => 'required',
            'keterangan_pemohon' => 'required',
        ]);
       
        $zoom = new PengajuanZoom();

        $zoom->id_users = $request->id_users;
        $zoom->tgl_pelaksanaan = $request->tgl_pelaksanaan;
        $zoom->jam_mulai = $request->jam_mulai;
        $zoom->jenis_zoom = $request->jenis_zoom;
        $zoom->jam_selesai = $request->jam_selesai;
        $zoom->jumlah_peserta = $request->jumlah_peserta;
        $zoom->nama_kegiatan = $request->nama_kegiatan;
        $zoom->keterangan_pemohon = $request->keterangan_pemohon;
        $zoom->status = 'diajukan';
        
        $zoom->save();
        $pengguna = User::where('id_users', $zoom->id_users)->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Zoom Meeting';
        $notifikasi->pesan = 'Pengajuan Zoom Meeting anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'yes';
        $notifikasi->link = '/ajuanzoom';  
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasiKadiv = User::where('id_jabatan', '8')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Zoom Meeting';
        $notifikasi->pesan =  'Pengajuan Zoom Meeting dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara menyiapkan room zoom meeting.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanzoom';
        $notifikasi->send_email = 'yes';
        $notifikasi->id_users = $notifikasiKadiv->id_users;
        $notifikasi->save();

        $notifikasiAdmin = User::where('level', 'admin')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Zoom Meeting';
        $notifikasi->pesan =  'Pengajuan Zoom Meeting dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara menyiapkan room zoom meeting.'; 
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanzoom';
        $notifikasi->send_email = 'no';
        $notifikasi->id_users = $notifikasiAdmin->id_users;
        $notifikasi->save();
        

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_pengajuan_zoom)
    {
        $zoom = PengajuanZoom::findOrFail($id_pengajuan_zoom);
    
        // Mengambil semua data BarangTik yang tersedia
        $users = User::where('is_deleted', '0')->get();
        
        return view('ajuanzoom.show', [
            'zoom' => $zoom,
            'users' => $users,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanZoom $pengajuanZoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pengajuan_zoom)
    {
        if (auth()->user()->level == 'admin') {
            $rules = [
                'tgl_pelaksanaan' => 'required|date',
                'jam_mulai' => 'required',
                'jenis_zoom' => 'required',
                'jam_selesai' => 'required',
                'nama_kegiatan' => 'required',
                'jumlah_peserta' => 'required',
                'keterangan_pemohon' => 'required',
                'nama_operator' => 'required',
                'akun_zoom' => 'nullable',
                'status' =>'required',
                'tautan_zoom' => 'nullable',
                'keterangan_operator' => 'nullable',
            ];

            $zoom = PengajuanZoom::find($id_pengajuan_zoom);
            $request->validate($rules);
            $zoom->tgl_pelaksanaan = $request->tgl_pelaksanaan;
            $zoom->jam_mulai = $request->jam_mulai;
            $zoom->jenis_zoom = $request->jenis_zoom;
            $zoom->jam_selesai = $request->jam_selesai;
            $zoom->jumlah_peserta = $request->jumlah_peserta;
            $zoom->nama_kegiatan = $request->nama_kegiatan;
            $zoom->keterangan_pemohon = $request->keterangan_pemohon;
            $zoom->nama_operator = $request->nama_operator;
            $zoom->akun_zoom = $request->akun_zoom;
            $zoom->status = $request->status;
            $zoom->tautan_zoom = $request->tautan_zoom;
            $zoom->keterangan_operator = $request->keterangan_operator;
            $zoom->save();
            if($zoom->status == 'ready'){
                $pengguna = User::where('id_users', $zoom->id_users)->first();
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Zoom Meeting';
                $notifikasi->pesan = 'Pengajuan Zoom Meeting anda sudah dibuat. Silahkan cek detail pengajuan zoom anda.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'yes';
                $notifikasi->link = '/ajuanzoom';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();
            }
        

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }else{
            $rules = [
                'tgl_pelaksanaan' => 'required|date',
                'jam_mulai' => 'required',
                'jenis_zoom' => 'required',
                'jam_selesai' => 'required',
                'nama_kegiatan' => 'required',
                'jumlah_peserta' => 'required',
                'keterangan_pemohon' => 'required',
            ];
            $zoom = PengajuanZoom::find($id_pengajuan_zoom);
            $request->validate($rules);
            $zoom->tgl_pelaksanaan = $request->tgl_pelaksanaan;
            $zoom->jam_mulai = $request->jam_mulai;
            $zoom->jenis_zoom = $request->jenis_zoom;
            $zoom->jam_selesai = $request->jam_selesai;
            $zoom->jumlah_peserta = $request->jumlah_peserta;
            $zoom->nama_kegiatan = $request->nama_kegiatan;
            $zoom->keterangan_pemohon = $request->keterangan_pemohon;
            $zoom->save();

            if($zoom->status == 'ready'){
                $pengguna = User::where('id_users', $zoom->id_users)->first();
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Zoom Meeting';
                $notifikasi->pesan = 'Pengajuan Zoom Meeting anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'yes';
                $notifikasi->link = '/ajuanzoom';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();
            }
        

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        }
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengajuan_zoom)
    {
        $zoom = PengajuanZoom::find($id_pengajuan_zoom);

        if ($zoom) {
            $zoom->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}