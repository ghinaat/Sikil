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
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);
        
        $perizinan = new Perizinan();   
        if ($request->jenis_perizinan === 'CT') {
            // Menggunakan kode_finger untuk mencari pengguna dalam tabel Perizinan
            $perizinanUser = User::with('cuti')->where('kode_finger', $request->kode_finger)->first();
        
            if ($perizinanUser) {
                if ($perizinanUser->cuti == null) {
                    return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                }
                
                // Hitung jumlah hari pengajuan cuti menggunakan fungsi hitungJumlahHariPengajuan
                $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
                    $request->tgl_absen_awal,
                    $request->tgl_absen_akhir
                );
        
                // Check if the user has enough jatah cuti tahunan
                $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
        
                if ($jatahCutiTahunan < $jumlah_hari_pengajuan) {
                    return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                }
        
                // Update the user's jatah_cuti in the cuti record
                if ($perizinanUser->cuti) {
                    $perizinanUser->cuti->jatah_cuti -= $jumlah_hari_pengajuan;
                    if ($perizinanUser->cuti->save()) {
                        // Proceed with creating Perizinan record
                    } else {
                        return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Tidak ada data cuti yang sesuai.');
                }
            } else {
                return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
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
        $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
            $request->tgl_absen_awal,
            $request->tgl_absen_akhir
        );
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
        'id_atasan' => 'required',
        'keterangan' => 'required',
        'jenis_perizinan' => 'required',
        'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
    ];
    $request->validate($rules);

    $perizinan = Perizinan::find($id_perizinan);

    if (!$perizinan) {
        return redirect()->route('ajuanperizinan.index')->with('error', 'Data tidak ditemukan');
    }

    // Dapatkan jenis perizinan sebelumnya pengguna
    $jenisPerizinanSebelumnya = $perizinan->jenis_perizinan;

    // Update jenis perizinan pada perizinan
    $perizinan->jenis_perizinan = $request->jenis_perizinan;

    // Hitung perbedaan dalam jatah cuti tahunan
    $perbedaanJatahCuti = 0;

    if ($jenisPerizinanSebelumnya === 'CT' && $request->jenis_perizinan !== 'CT') {
        // Jika sebelumnya cuti tahunan dan sekarang bukan cuti tahunan, tambahkan jatah cuti
        $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
            $request->tgl_absen_awal,
            $request->tgl_absen_akhir
        );
        $perbedaanJatahCuti = $jumlah_hari_pengajuan;
    } elseif ($jenisPerizinanSebelumnya !== 'CT' && $request->jenis_perizinan === 'CT') {
        // Jika sebelumnya bukan cuti tahunan dan sekarang cuti tahunan, kurangi jatah cuti
        $jumlah_hari_pengajuan = $perizinan->hitungJumlahHariPengajuan(
            $request->tgl_absen_awal,
            $request->tgl_absen_akhir
        );
        $perbedaanJatahCuti = -$jumlah_hari_pengajuan;
    }

    // Perbarui jatah cuti tahunan pengguna jika perbedaan tidak nol
    if ($perbedaanJatahCuti != 0) {
        // Cek apakah pengguna ditemukan berdasarkan kode finger
        $perizinanUser = User::with('cuti')->where('kode_finger', $request->kode_finger)->first();

        if ($perizinanUser) {
            if (!$perizinanUser->cuti) {
                return redirect()->back()->with('error', 'Pengguna tidak memiliki cuti tahunan.');
            }

            $perizinanUser->cuti->jatah_cuti += $perbedaanJatahCuti;

            // Pastikan jatah cuti tidak kurang dari 0
            if ($perizinanUser->cuti->jatah_cuti < 0) {
                $perizinanUser->cuti->jatah_cuti = 0;
            }

            if (!$perizinanUser->cuti->save()) {
                return redirect()->back()->with('error', 'Gagal mengubah jatah cuti tahunan pengguna.');
            }
        } else {
            return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
        }
    }

    // Lanjutkan dengan menyimpan perubahan perizinan
    $perizinan->kode_finger = $request->kode_finger;
    $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
    $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
    $perizinan->id_atasan = $request->id_atasan;
    $perizinan->keterangan = $request->keterangan;

    // Handle file_perizinan jika ada perubahan
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