<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Notifikasi;
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
    public function index(Request $request)
    {
        if ($request->input('tgl_absen_awal') == null && $request->input('tgl_absen_akhir') == null) {
            $user = Auth::user();
            if ($user->level == 'admin' or $user->level == 'ppk') {
                $ajuanperizinan = Perizinan::where('is_deleted', '0')->get();
            } elseif ($user->level == 'bod' or $user->level == 'kadiv') {
                $ajuanperizinan = Perizinan::where('is_deleted', '0')->where('id_atasan', auth()->user()->id_users)->get();
            }
        } else {
            $user = Auth::user();
            if ($user->level == 'admin' or $user->level == 'ppk') {
                $ajuanperizinan = Perizinan::where('is_deleted', '0')->where('tgl_absen_awal', '>=', $request->input('tgl_absen_awal'))->where('tgl_absen_akhir', '<=', $request->input('tgl_absen_akhir'))->get();
            } elseif ($user->level == 'bod' or $user->level == 'kadiv') {
                $ajuanperizinan = Perizinan::where('is_deleted', '0')->where('id_atasan', auth()->user()->id_users)->where('tgl_absen_awal', '>=', $request->tgl_absen_awal)->where('tgl_absen_akhir', '<=', $request->tgl_absen_akhir)->get();
            }
        }

        if ($request->input('kode_finger') != null) {
            if ($request->input('kode_finger') != 'all') {
                $ajuanperizinan = $ajuanperizinan->where('kode_finger', '=', $request->input('kode_finger'));
            }
        }

        if ($request->input('jenis_perizinan') != null) {
            if ($request->input('jenis_perizinan') != 'all') {
                $ajuanperizinan = $ajuanperizinan->where('jenis_perizinan', '=', $request->input('jenis_perizinan'));
            }
        }

        return view('izin.index', [
            'ajuanperizinan' => $ajuanperizinan,
            'users' => User::where('is_deleted', '0')->get(),
            'settingperizinan' => User::with(['setting'])->get(),
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
            'jumlah_hari_pengajuan' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'keterangan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $ajuanperizinan = new Perizinan();

        $pengguna = User::where('kode_finger', $request->kode_finger)->first();

        if (! $pengguna) {
            return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
        }

        $jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        // dd($jumlah_hari_pengajuan);

        // Periksa apakah jatah cuti tahunan mencukupi
        if ($request->jenis_perizinan === 'CT' && $pengguna->cuti) {
            if ($pengguna->cuti->jatah_cuti < $jumlah_hari_pengajuan) {
                return redirect()->back()->with('error', 'Jatah cuti tidak mencukupi untuk pengajuan ini.');
            }
        }

        if ($request->hasFile('file_perizinan')) {
            // Upload dan simpan file jika ada
            $file = $request->file('file_perizinan');
            $fileExtension = $file->getClientOriginalExtension();

            $fileName = Str::random(20).'.'.$fileExtension;
            $file->storeAs('file_perizinan', $fileName, 'public');

            // Update the file_perizinan attribute in the $perizinan object
            $ajuanperizinan->file_perizinan = $fileName;
        } else {
            // If no file is uploaded, set the file_perizinan attribute to NULL
            $ajuanperizinan->file_perizinan = null;
        }

        $ajuanperizinan->id_atasan = $request->id_atasan;
        $ajuanperizinan->kode_finger = $request->kode_finger;
        $ajuanperizinan->jenis_perizinan = $request->jenis_perizinan;
        $ajuanperizinan->tgl_ajuan = $request->tgl_ajuan;
        $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $ajuanperizinan->jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        $ajuanperizinan->keterangan = $request->keterangan;
        // $ajuanperizinan->file_perizinan = $fileName;
        $ajuanperizinan->status_izin_atasan = null; // Default menunggu persetujuan
        $ajuanperizinan->status_izin_ppk = null; // Default menunggu persetujuan
        $ajuanperizinan->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin';
        $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu..';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/perizinan';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin ';
        $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperizinan';
        $notifikasi->id_users = $request->id_atasan;
        $notifikasi->save();

        $ppk = GeneralSetting::where('status', '1')->first();
        if ($request->jenis_perizinan !== 'I') {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->id_users = $ppk->id_users;
            $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->first();
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin ';
        $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperizinan';
        $notifikasi->id_users = $notifikasiAdmin->id_users;
        $notifikasi->save();

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
        if (auth()->user()->level === 'bod' || auth()->user()->level === 'kadiv') {
            $rules = [
                'status_izin_atasan' => 'required',
            ];

            $ajuanperizinan = Perizinan::find($id_perizinan);
            $request->validate($rules);
            $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;

            if ($request->status_izin_atasan === '0') {
                $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
            } else {
                $statusPPK = $ajuanperizinan->status_izin_ppk;
                $CutiTahunan = $ajuanperizinan->jenis_perizinan;

                if ($statusPPK === '1' && $CutiTahunan === 'CT') {
                    $kodeFinger = $ajuanperizinan->kode_finger;
                    $perizinanUser = User::with('cuti')->where('kode_finger', $kodeFinger)->first();

                    if ($perizinanUser) {
                        if ($perizinanUser->cuti == null) {
                            return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                        }

                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;

                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }

                        $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;

                        if ($perizinanUser->cuti->save()) {
                            // Logika tambahan setelah mengurangkan jatah cuti.
                        } else {
                            return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                        }

                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }
                }

            }
            // dd($request);
            // dd($statusPPK, $request->jenis_perizinan);
            $ajuanperizinan->save();

            return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
        } elseif (auth()->user()->level === 'ppk') {
            $ajuanperizinan = Perizinan::find($id_perizinan);

            $rules = [
                'status_izin_ppk' => 'required',
            ];

            if ($ajuanperizinan) {
                if ($ajuanperizinan->id_atasan === auth()->user()->id_users) {
                    $rules['status_izin_atasan'] = 'required';
                }
            }

            $request->validate($rules);

            $ajuanperizinan->status_izin_ppk = $request->status_izin_ppk;
            if ($ajuanperizinan) {
                if ($ajuanperizinan->id_atasan === auth()->user()->id_users) {
                    $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;
                }
            }

            $statusAtasan = $ajuanperizinan->status_izin_atasan;

            if ($request->status_izin_ppk === '0') {
                $ajuanperizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
            }
            if ($request->status_izin_atasan === '0') {
                $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
            }

            if ($request->status_izin_ppk === '1' || $request->status_izin_atasan === '1') {
                $statusAtasan = $ajuanperizinan->status_izin_atasan;
                $CutiTahunan = $ajuanperizinan->jenis_perizinan;

                if ($statusAtasan === '1' && $CutiTahunan === 'CT') {
                    $kodeFinger = $ajuanperizinan->kode_finger;
                    $perizinanUser = User::with('cuti')->where('kode_finger', $kodeFinger)->first();

                    if ($perizinanUser) {
                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }
                        if ($perizinanUser->cuti) {
                            $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;
                            if ($perizinanUser->cuti->save()) {

                            } else {
                                return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }

                }
            }
            $ajuanperizinan->status_izin_atasan = $statusAtasan;
            // dd($request);

            $ajuanperizinan->save();

            return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
        } else {
            $rules = [
                'kode_finger' => 'required',
                'id_atasan' => 'required',
                'jenis_perizinan' => 'required',
                // 'tgl_ajuan' => 'required',
                'tgl_absen_awal' => 'required',
                'tgl_absen_akhir' => 'required',
                'keterangan' => 'required',
                // 'status_izin_atasan' => 'required',
                // 'status_izin_ppk' => 'required',
            ];

            if ($request->file('file_perizinan')) {
                $rules['file_perizinan'] = 'required|mimes:pdf,doc,docx,png,jpg,jpeg';
            }

            if (isset($request->status_izin_atasan)) {
                if ($request->status_izin_atasan === '0') {
                    $rules['alasan_ditolak_atasan'] = 'required';
                }
            }

            if (isset($request->status_izin_ppk)) {
                if ($request->status_izin_ppk === '0') {
                    $rules['alasan_ditolak_ppk'] = 'required';
                }
            }

            $request->validate($rules);

            $ajuanperizinan = Perizinan::find($id_perizinan);

            if (! $ajuanperizinan) {
                return redirect()->route('ajuanperizinan.index')->with('error', 'Data tidak ditemukan');
            }
            $ajuanperizinan->id_atasan = $request->id_atasan;
            $ajuanperizinan->kode_finger = $request->kode_finger;
            $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
            $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
            $ajuanperizinan->keterangan = $request->keterangan;

            if (isset($request->status_izin_atasan)) {
                $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;
            }
            if (isset($request->status_izin_ppk)) {
                $ajuanperizinan->status_izin_ppk = $request->status_izin_ppk;
            }

            if (isset($request->status_izin_atasan)) {
                if ($request->status_izin_atasan === '0') {
                    $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
                }
            }
            if (isset($request->status_izin_ppk)) {
                if ($request->status_izin_ppk === '0') {
                    $ajuanperizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
                }
            }

            if ($request->status_izin_ppk && $request->status_izin_atasan) {
                if ($request->jenis_perizinan === 'CT') {
                    $perizinanUser = User::with('cuti')->where('kode_finger', $request->kode_finger)->first();

                    if ($perizinanUser) {
                        if ($perizinanUser->cuti == null) {
                            return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                        }
                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }
                        if ($perizinanUser->cuti) {
                            $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;
                            if ($perizinanUser->cuti->save()) {

                            } else {
                                return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }
                }

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

            $request->validate($rules);

            $ajuanperizinan->save();

            $pengguna = User::where('kode_finger', $request->kode_finger)->first();
            if($ajuanperizinan->jenis_perizinan === 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                } elseif ($ajuanperizinan->status_izin_atasan === '0' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                }

            }
            if ($ajuanperizinan->jenis_perizinan !== 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === '1') {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                } elseif ($ajuanperizinan->status_izin_atasan === '0' && $ajuanperizinan->status_izin_ppk === '0') {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }
            }
            

        }

        return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perizinan $id_perizinan)
    {
        if ($id_perizinan) {
            $id_perizinan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah terhapus');
    }
}
