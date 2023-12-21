<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Surat;
use App\Models\Perizinan;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_kegiatan = Kegiatan::orderBy('tgl_mulai', 'asc')->get();
        $kegiatans = Kegiatan::whereDate('tgl_mulai', '<=', today())
            ->where('tgl_selesai', '>=', today())
            ->get();

        $jenis_perizinan = ['CT', 'Prajab', 'CAP', 'CM', 'CH', 'CB'];

        $staf_ijin = Perizinan::whereDate('tgl_absen_awal', '<=', today())
                ->whereDate('tgl_absen_akhir', '>=', today())
                ->where(function ($query) use ($jenis_perizinan) {
                    $query->where(function ($subquery) {
                        $subquery->where('jenis_perizinan', 'I')
                                ->where('status_izin_atasan', '1');
                    })->orWhere(function ($subquery) use ($jenis_perizinan) {
                        $subquery->whereIn('jenis_perizinan', $jenis_perizinan)
                                ->where('status_izin_ppk', '1')
                                ->where('status_izin_atasan', '1');
                    });
                })
                ->count();
        $staf_dinas_luar = Perizinan::whereDate('tgl_absen_awal', '<=', today())->where('tgl_absen_akhir', '>=', today())->where('jenis_perizinan', 'DL')->where('status_izin_atasan', '1')->where('status_izin_ppk', '1')->count();
      
        $staf_sakit = Perizinan::whereDate('tgl_absen_awal', '<=', today())->where('tgl_absen_akhir', '>=', today())->where('jenis_perizinan', 'S')->where('status_izin_atasan', '1')->where('status_izin_ppk', '1')->count();


        return view('home', [
            'kegiatans' => $kegiatans,
            'all_kegiatan' => $all_kegiatan,
            'staf_ijin' => $staf_ijin,
            'staf_dinas_luar' => $staf_dinas_luar,
            'staf_sakit' => $staf_sakit,
        ]);
    }
    
    public function Pengajuan()
    {
        $surat = Surat::where('is_deleted', '0')->orderBy('id_surat', 'desc')
        ->get();

        return view('pengajuan', [
            'surat' => $surat,
        ]);
    }
}