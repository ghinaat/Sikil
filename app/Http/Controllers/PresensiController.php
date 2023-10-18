<?php

namespace App\Http\Controllers;

use App\Exports\PresensiExportFilter;
use App\Imports\PresensiImport;
use App\Models\Presensi;
use App\Models\Perizinan;
use DateTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            // Fetch all work experiences for admin
            $presensi = Presensi::where('is_deleted', '0')->whereMonth('tanggal', '=', date('m'))
                ->whereYear('tanggal', '=', date('Y'))
                ->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $presensi = $user->presensi()->where('is_deleted', '0')->whereMonth('tanggal', '=', date('m'))
                ->whereYear('tanggal', '=', date('Y'))
                ->get();
        }

        return view('presensi.index', [
            'presensi' => $presensi,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

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

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter(Request $request)
    {
        $selectedDate = $request->input('tanggalFilter');
        $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');

        $user = Auth::user();
        if ($user->level == 'admin') {
            $presensi = Presensi::whereDate('tanggal', $selectedDate)->get();
        } else {
            $presensi = $user->presensi()->whereDate('tanggal', $selectedDate)->get();
        }

        return view('presensi.index', [
            'presensi' => $presensi,
        ]);
    }

    public function filteruser(Request $request)
    {
        $user = Auth::user();
        if ($user->level == 'admin') {
            $kode_finger = $request->input('kode_finger');
        } else {
            $kode_finger = $user->kode_finger;
        }
        $tglawal = $request->input('tglawal');
        $tglakhir = date('Y-m-d', strtotime($request->input('tglakhir').' +1 day'));

        $presensi = Presensi::where('kode_finger', $kode_finger)
            ->whereBetween('tanggal', [$tglawal, $tglakhir])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('presensi.index', compact('presensi', 'tglawal', 'tglakhir'));
    }

    // filter data for export
    public function filterDataAdmin(Request $request)
    {

        $users = User::where('is_deleted', '0')->get();

        $presensis = [];

        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        foreach ($users as $user) {
            $kehadiran = 0;
            $terlambat = 0;
    
            $jenis_perizinan = [
                'ijin' => 0,
                'sakit' => 0,
                'cutiSakit' => 0,
                'cutiTahunan' => 0,
                'cutiMelahirkan' => 0,
                'dinasLuar' => 0,
                'alpha' => 0,
                'cap' => 0,
                'cutiBersama' => 0,
                'cutiHaji' => 0,
                'tugasBelajar' => 0,
                'prajab' => 0,
            ];
    
            $presensiData = Presensi::where('kode_finger', $user->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();
    
            $ajuanperizinans = Perizinan::where('kode_finger', $user->kode_finger)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->where(function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('tgl_absen_awal', [$start_date, $end_date])
                            ->orWhereBetween('tgl_absen_akhir', [$start_date, $end_date]);
                    });
                })
                ->get();
    
            foreach ($presensiData as $pd) {
                if ($pd->kehadiran !== null && $pd->kehadiran !== '00:00:00') {
                    $kehadiran++;
                }
    
                if (isset($pd->terlambat)) {
                    if ($pd->kehadiran) {
                        $time = explode(':', $pd->terlambat);
                        if ($time[0] > 0) {
                            $terlambat++;
                        } elseif ($time[1] > 0) {
                            $terlambat++;
                        } elseif ($time[2] > 0) {
                            $terlambat++;
                        }
                    }
                }
            }
    
            foreach ($ajuanperizinans as $ajuanperizinan) {
                $tglAbsenAwal = new DateTime($ajuanperizinan->tgl_absen_awal);
                $tglAbsenAkhir = new DateTime($ajuanperizinan->tgl_absen_akhir);
                $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
            
                // Tentukan rentang tanggal filter
                $tglfilterAwal = new DateTime($start_date);
                $tglfilterAkhir = new DateTime($end_date);
            
                // Hitung jumlah hari izin yang berada dalam rentang tanggal filter
                $tglAwalRelevan = max($tglAbsenAwal, $tglfilterAwal);
                $tglAkhirRelevan = min($tglAbsenAkhir, $tglfilterAkhir);

                if ($tglAbsenAwal <= $tglfilterAkhir && $tglAbsenAkhir >= $tglfilterAwal) {
                    $interval = $tglAkhirRelevan->diff($tglAwalRelevan);
                    $jumlahHariIzin = $interval->days + 1;
            
                    // Update jumlah izin sesuai jenis
                    if ($jenisPerizinan == 'I' && $ajuanperizinan->status_izin_atasan == '1') {
                        $jenis_perizinan['ijin'] += $jumlahHariIzin;
                    } elseif ($jenisPerizinan == 'S' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['sakit'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'A' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['alpha'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CB' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['cutiBersama'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CH' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['cutiHaji'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CM' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['cutiMelahirkan'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'DL' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['dinasLuar'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CT' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['cutiTahunan'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'TB' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['tugasBelajar'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CAP' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['CAP'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'CS' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['cutiSakit'] += $jumlahHariIzin;
                    }elseif ($jenisPerizinan == 'Prajab' && $ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                        $jenis_perizinan['prajab'] += $jumlahHariIzin;
                    }
                }
            }
    
            $presensis['data'][] = [
                'user' => $user->nama_pegawai,
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'ijin' => $jenis_perizinan['ijin'],
                'cap' => $jenis_perizinan['cap'],
                'sakit' => $jenis_perizinan['sakit'],
                'cutiSakit' => $jenis_perizinan['cutiSakit'],
                'cutiTahunan' => $jenis_perizinan['cutiTahunan'],
                'cutiMelahirkan' => $jenis_perizinan['cutiMelahirkan'],
                'dinasLuar' => $jenis_perizinan['dinasLuar'],
                'alpha' => $jenis_perizinan['alpha'],
                'cutiBersama' => $jenis_perizinan['cutiBersama'],
                'cutiHaji' => $jenis_perizinan['cutiHaji'],
                'tugasBelajar' => $jenis_perizinan['tugasBelajar'],
                'prajab' => $jenis_perizinan['prajab'],
            ];

        }

        $presensis['start_date'] = $start_date;
        $presensis['end_date'] = $end_date;

        return Excel::download(new PresensiExportFilter($presensis), 'presensi.xlsx');
    }

    public function filterAdmin(Request $request)
    {
        $users = User::where('is_deleted', '0')->get();
        $presensis = [];
    
        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';
    
        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);
    
        foreach ($users as $user) {
            $kehadiran = 0;
            $terlambat = 0;
    
            $jenis_perizinan = [
                'ijin' => 0,
                'sakit' => 0,
                'cutiSakit' => 0,
                'cutiTahunan' => 0,
                'cutiMelahirkan' => 0,
                'dinasLuar' => 0,
                'alpha' => 0,
                'cap' => 0,
                'cutiBersama' => 0,
                'cutiHaji' => 0,
                'tugasBelajar' => 0,
                'prajab'  => 0,
            ];
    
            $presensiData = Presensi::where('kode_finger', $user->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();
    
            $ajuanperizinans = Perizinan::where('kode_finger', $user->kode_finger)
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->where(function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('tgl_absen_awal', [$start_date, $end_date])
                            ->orWhereBetween('tgl_absen_akhir', [$start_date, $end_date]);
                    });
                })
                ->get();
    
            foreach ($presensiData as $pd) {
                if ($pd->kehadiran !== null && $pd->kehadiran !== '00:00:00') {
                    $kehadiran++;
                }
    
                if (isset($pd->terlambat)) {
                    if ($pd->kehadiran) {
                        $time = explode(':', $pd->terlambat);
                        if ($time[0] > 0) {
                            $terlambat++;
                        } elseif ($time[1] > 0) {
                            $terlambat++;
                        } elseif ($time[2] > 0) {
                            $terlambat++;
                        }
                    }
                }
            }
    
            foreach ($ajuanperizinans as $ajuanperizinan) {
                $tglAbsenAwal = new DateTime($ajuanperizinan->tgl_absen_awal);
                $tglAbsenAkhir = new DateTime($ajuanperizinan->tgl_absen_akhir);
                $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
            
                // Tentukan rentang tanggal filter
                $tglfilterAwal = new DateTime($start_date);
                $tglfilterAkhir = new DateTime($end_date);
            
                // Hitung jumlah hari izin yang berada dalam rentang tanggal filter
                // $tglAwalRelevan = max($tglAbsenAwal, $tglfilterAwal);
                // $tglAkhirRelevan = min($tglAbsenAkhir, $tglfilterAkhir);

                // if ($tglAbsenAwal <= $tglfilterAkhir && $tglAbsenAkhir >= $tglfilterAwal) {
                //     $interval = $tglAkhirRelevan->diff($tglAwalRelevan);
                //     $jumlahHariIzin = $interval->days + 1;
            
                $currentDate = clone $tglfilterAwal;
                while ($currentDate <= $tglfilterAkhir) {
                    // Periksa apakah tanggal ini termasuk dalam izin
                    if ($currentDate >= $tglAbsenAwal && $currentDate <= $tglAbsenAkhir) {
                        // Tambahkan jenis izin yang sesuai ke dalam array jenis_perizinan
                        switch ($jenisPerizinan) {
                            case 'I':
                                if ($ajuanperizinan->status_izin_atasan == '1') {
                                    $jenis_perizinan['ijin']++;
                                }
                                break;
                            case 'S':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['sakit']++;
                                }
                                break;
                            case 'A':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['alpha']++;
                                }
                                break;
                            case 'CB':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['cutiBersama']++;
                                }
                                break;
                            case 'CH':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['cutiHaji']++;
                                }
                                break;
                            case 'CM':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['cutiMelahirkan']++;
                                }
                                break;
                            case 'DL':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['dinasLuar']++;
                                }
                                break;
                            case 'CT':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['cutiTahunan']++;
                                }
                                break;
                            case 'TB':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['tugasBelajar']++;
                                }
                                break;
                            case 'CAP':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['CAP']++;
                                }
                                break;
                            case 'CS':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['cutiSakit']++;
                                }
                                break;
                            case 'Prajab':
                                if ($ajuanperizinan->status_izin_atasan == '1' && $ajuanperizinan->status_izin_ppk == '1') {
                                    $jenis_perizinan['prajab']++;
                                }
                                break;
                        }
                    }
                    // Lanjutkan ke hari berikutnya
                    $currentDate->modify('+1 day');
                }
                            }
            $presensis[] = [
                'user' => $user->nama_pegawai,
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'ijin' => $jenis_perizinan['ijin'],
                'cap' => $jenis_perizinan['cap'],
                'sakit' => $jenis_perizinan['sakit'],
                'cutiSakit' => $jenis_perizinan['cutiSakit'],
                'cutiTahunan' => $jenis_perizinan['cutiTahunan'],
                'cutiMelahirkan' => $jenis_perizinan['cutiMelahirkan'],
                'dinasLuar' => $jenis_perizinan['dinasLuar'],
                'alpha' => $jenis_perizinan['alpha'],
                'cutiBersama' => $jenis_perizinan['cutiBersama'],
                'cutiHaji' => $jenis_perizinan['cutiHaji'],
                'tugasBelajar' => $jenis_perizinan['tugasBelajar'],
                'prajab' => $jenis_perizinan['prajab'] 
            ];
        }
    
        return view('presensi.filter', [
            'presensis' => $presensis,
        ]);
    }
    

    public function import(Request $request)
    {
        
        Excel::import(new PresensiImport, $request->file('file')->store('presensi'));

        return redirect()->back()->with([
            'success_message' => 'Data telah Tersimpan',
        ]);
    }

    // public function filter(Request $request)
    // {
    //     $selectedDate = $request->input('tanggalFilter');
    //     $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');

    //     $presensi = Presensi::whereDate('tanggal', $selectedDate )->get();

    //     return view('presensi.index',  [
    //         'presensi' => $presensi,
    //     ]);
    // }

}