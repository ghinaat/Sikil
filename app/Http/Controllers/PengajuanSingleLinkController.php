<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSingleLink;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Str;

class PengajuanSingleLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (auth()->user()->level == 'kadiv' && auth()->user()->id_jabatan == '8' ) {
            $ajuansinglelink = PengajuanSingleLink::where('is_deleted', '0')
            ->orderByDesc('id_pengajuan_singlelink')
            ->get();

        } elseif(auth()->user()->level == 'admin' ) {
            $ajuansinglelink = PengajuanSingleLink::where('is_deleted', '0')
            ->orderByDesc('id_pengajuan_singlelink')
            ->get();

        }else{
            $ajuansinglelink = PengajuanSingleLink::where('is_deleted', '0')
            ->whereIn('id_users', $user->ajuansinglelink->pluck('id_users'))
            ->orderByDesc('id_pengajuan_singlelink')
            ->get();        
        }

        return view('ajuansinglelink.index', [
            'ajuansinglelink' => $ajuansinglelink,
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
            'nama_kegiatan'=> 'required',
            'nama_shortlink'=> 'required',
            'keterangan_pemohon'=> 'required',
        ]);
    

        $ajuansinglelink = new PengajuanSingleLink();
    
            $ajuansinglelink->id_users = $request->id_users;
            $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
            $ajuansinglelink->nama_shortlink = $request->nama_shortlink;
            $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
            $ajuansinglelink->save();

            $pengguna = User::where('id_users', $request->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan = 'Pengajuan Single link anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            $notifikasiKadiv = User::where('id_jabatan', '8')->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan =  'Pengajuan Single Link dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara menyiapkan barang peminjaman.'; 
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->send_email = 'yes';
            $notifikasi->id_users = $notifikasiKadiv->id_users;
            $notifikasi->save();
    
    
            $notifikasiAdmin = User::where('level', 'admin')->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link ';
            $notifikasi->pesan = 'Pengajuan Single Link dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->id_users = $notifikasiAdmin->id_users;
            $notifikasi->save();
    
            return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_pengajuan_singlelink)
    {
        $ajuansinglelink = PengajuanSingleLink::findOrFail($id_pengajuan_singlelink);
        $users = User::where('is_deleted', '0')->get();

        return view('ajuansinglelink.show', [
            'ajuansinglelink' => $ajuansinglelink,
            'users' => $users,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSingleLink $pengajuanSingleLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id_pengajuan_singlelink)
    {
        if(auth()->user()->level == 'admin' ) {
        $request->validate([
            'nama_kegiatan'=> 'required',
            'nama_shortlink'=> 'required',
            'keterangan_pemohon'=> 'required',
            'keterangan_operator'=> 'required',
            'status'=> 'required',
        ]);

        $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);

        $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
        $ajuansinglelink->nama_shortlink =  $request->nama_shortlink;
        $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
        $ajuansinglelink->keterangan_operator = $request->keterangan_operator;
        $ajuansinglelink->status =  $request->status;
        $ajuansinglelink->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        } else {
            $request->validate([
                'nama_kegiatan'=> 'required',
                'nama_shortlink'=> 'required',
                'keterangan_pemohon'=> 'required',
            ]);
    
            $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);

            $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
            $ajuansinglelink->nama_shortlink = $request->nama_shortlink;
            $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
            $ajuansinglelink->save();

            $pengguna = User::where('id_users', $request->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan = 'Pengajuan Single link anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'yes';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengajuan_singlelink)
    {
        $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);
        if ($ajuansinglelink) {
            $ajuansinglelink->is_deleted = '1';
            $ajuansinglelink->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus');
    }
}
