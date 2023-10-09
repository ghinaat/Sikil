<?php

namespace App\Http\Controllers;

use App\Exports\LemburExport;
use App\Models\Lembur;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LemburController extends Controller
{
    public function export(Request $request)
    {
        $users = User::where('is_deleted', '0')->get();

        $lemburs = [];

        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $lemburs['data'] = Lembur::whereBetween('tanggal', [$start_date, $end_date])->get();

        $lemburs['start_date'] = $start_date;
        $lemburs['end_date'] = $end_date;

        return Excel::download(new LemburExport($lemburs), 'lembur.xlsx');

    }

    public function filterAdmin(Request $request)
    {
        $users = User::where('is_deleted', '0')->get();

        $lembur = [];

        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $lemburData = Lembur::where('kode_finger', $users->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();

        return view('lembur.filter', [
            'lembur' => $lembur,
        ]);

    }

    public function index()
    {
        $user = auth()->user();
        $lembur = Lembur::where('is_deleted', '0')
            ->whereIn('kode_finger', $user->lembur->pluck('kode_finger'))
            ->get();

        return view('lembur.index', [
            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function atasan()
    {
        $user = auth()->user();
        if (auth()->user()->level == 'admin') {
            $lembur = Lembur::where('is_deleted', '0')->get();
        } else {
            $lembur = Lembur::where('is_deleted', '0')->whereIn('id_atasan', $user->lemburs->pluck('id_atasan'))->get();
        }

        return view('lembur.atasan', [
            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);

    }

    public function rekap()
    {
        $lembur = Lembur::where('is_deleted', '0')
            ->get();

        return view('lembur.rekap', [

            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function status(Request $request, $id_lembur)
    {
        $rules = [
            'status_izin_atasan' => 'required',
        ];

        $request->validate($rules);
        $lembur = Lembur::find($id_lembur);

        $lembur->status_izin_atasan = $request->status_izin_atasan;
        if ($request->status_izin_atasan === '0') {
            $lembur->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
        }

        $lembur->save();
        
        // dd($lembur);
        $pengguna = User::where('kode_finger', $lembur->kode_finger)->first();
        if ($lembur->status_izin_atasan === '1') {

            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Persetujuan Lembur';
            $notifikasi->pesan = 'Pengajuan Lembur anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/lembur';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        } elseif($lembur->status_izin_atasan === '0') {

            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Persetujuan Lembur ';
            $notifikasi->pesan = 'Pengajuan lembur anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/lembur';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    public function filter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $lembur = Lembur::where('is_deleted', '0')
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->get();

        return view('lembur.rekap', [
            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); // Tambahkan ini untuk melihat data yang dikirimkan dari formulir
        // Validasi data yang diterima dari form
        $request->validate([
            'id_atasan' => 'required',
            'kode_finger' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tugas' => 'required|string',
        ]);

        // Menghitung jam lembur dari jam mulai dan jam selesai
        $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $request->input('jam_mulai'));
        $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $request->input('jam_selesai'));
        $diffInMinutes = $jamMulai->diffInMinutes($jamSelesai);

        // Validasi: Jam selesai harus lebih besar dari jam mulai
        if ($request->jam_mulai >= $request->jam_selesai) {
            return redirect()->back()->with('error', 'Harap periksa kembali waktu selesai Anda.');
        }

        // Membuat objek Lembur baru dan mengisi atributnya
        $lembur = new Lembur();

        $lembur->kode_finger = $request->kode_finger;
        $lembur->id_atasan = $request->id_atasan;
        $lembur->tanggal = $request->input('tanggal');
        $lembur->jam_mulai = $request->input('jam_mulai');
        $lembur->jam_selesai = $request->input('jam_selesai');
        $lembur->jam_lembur = floor($diffInMinutes / 60).':'.($diffInMinutes % 60); // Jam dan menit
        $lembur->tugas = $request->input('tugas');
        $lembur->status_izin_atasan = null;

        $lembur->save();

        $pengguna = User::where('kode_finger', $request->kode_finger)->first();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur';
        $notifikasi->pesan = 'Pengajuan Lembur anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/lembur';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur ';
        $notifikasi->pesan = 'Pengajuan Lembur dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanlembur';
        $notifikasi->id_users = $request->id_atasan;
        $notifikasi->save();

        $notifikasiAdmin = User::where('level', 'admin')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur ';
        $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanlembur';
        $notifikasi->id_users = $notifikasiAdmin->id_users;
        $notifikasi->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lembur $lembur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lembur $lembur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_lembur)
    {
        $rules = [
            'id_atasan' => 'required',
            'kode_finger' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tugas' => 'required|string',
        ];
        // dd($request->all());

        $request->validate($rules);
        $lembur = Lembur::find($id_lembur);

        // Ubah format jam_mulai dan jam_selesai dari 'H:i:s' menjadi 'H:i'
        $lembur->jam_mulai = date('H:i', strtotime($request->input('jam_mulai')));
        $lembur->jam_selesai = date('H:i', strtotime($request->input('jam_selesai')));

        // Validasi: Jam selesai harus lebih besar dari jam mulai
        if ($lembur->jam_mulai >= $lembur->jam_selesai) {
            return redirect()->back()->with('error', 'Harap periksa kembali waktu selesai Anda.');
        }

        // Hitung jumlah jam lembur secara otomatis
        $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $lembur->jam_mulai);
        $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $lembur->jam_selesai);
        $diffInMinutes = $jamMulai->diffInMinutes($jamSelesai);
        $lembur->jam_lembur = floor($diffInMinutes / 60).':'.($diffInMinutes % 60);

        $lembur->kode_finger = $request->kode_finger;
        $lembur->id_atasan = $request->id_atasan;
        $lembur->tanggal = $request->input('tanggal');
        $lembur->jam_mulai = $request->input('jam_mulai');
        $lembur->jam_selesai = $request->input('jam_selesai');

        $lembur->tugas = $request->input('tugas');
        $lembur->status_izin_atasan = $request->status_izin_atasan;

        $lembur->save();

        $pengguna = User::where('kode_finger', $request->kode_finger)->first();
       

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur';
        $notifikasi->pesan = 'Pengajuan Lembur anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/lembur';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur ';
        $notifikasi->pesan = 'Pengajuan Lembur dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanlembur';
        $notifikasi->id_users = $request->id_atasan;
        $notifikasi->save();

        $notifikasiAdmin = User::where('level', 'admin')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Lembur ';
        $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanlembur';
        $notifikasi->id_users = $notifikasiAdmin->id_users;
        $notifikasi->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_lembur)
    {
        $lembur = Lembur::find($id_lembur);
        if ($lembur) {
            $lembur->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }
}