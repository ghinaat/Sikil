<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PresensiImport;

use App\Exports\PresensiExport;
use App\Exports\PresensiExportFilter;



class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $presensi = Presensi::all();
        return view('presensi.index', [
            'presensi' => $presensi,
            // 'presensi' => Presensi::all()
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
            $ijin = 0;
            $sakit = 0;
            $cutiSakit = 0;
            $cutiTahunan = 0;
            $cutiMelahirkan = 0;
            $dinasLuar = 0;
            $alpha = 0;
            $cutiBersama = 0;
            $cutiHaji = 0;
            $tugasBelajar = 0;
            

            $presensiData = Presensi::where('kode_finger', $user->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();
            
            foreach ($presensiData as $pd) {
                if($pd->kehadiran === 1){
                    $kehadiran++; 
                }
    
                if(isset($pd->terlambat)){
                    if($pd->kehadiran === 1){
                        $time = explode(":", $pd->terlambat);
                        if($time[0] > 0){
                            $terlambat++;
                        }elseif ($time[1] > 0) {
                            $terlambat++;
                        }elseif ($time[2] > 0) {
                            $terlambat++;
                        }
                    }
                }
                switch ($pd->jenis_perizinan) {
                    case "I":
                        $ijin++;
                        break;
                        
                    case "S":
                        $sakit++;
                        break;
                        
                    case "CS":
                        $cutiSakit++;
                        break;
                        
                    case "CT":
                        $cutiTahunan++;
                        break;
                        
                    case "CM":
                        $cutiMelahirkan++;
                        break;
                        
                    case "DL":
                        $dinasLuar++;
                        break;
                        
                    case "A":
                        $alpha++;
                        break;
                        
                    case "CB":
                        $cutiBersama++;
                        break;
                        
                    case "CH":
                        $cutiHaji++;
                        break;
                        
                    case "TB":
                        $tugasBelajar++;
                        break;

                    default:
                        // Handle any other case not covered above, if necessary.
                        break;
                }
            }

            $presensis[] = [
                'user' => $user->nama_pegawai,
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'ijin' => $ijin,
                'sakit' => $sakit,
                'cutiSakit' => $cutiSakit,
                'cutiTahunan' => $cutiTahunan,
                'cutiMelahirkan' => $cutiMelahirkan,
                'dinasLuar' => $dinasLuar,
                'alpha' => $alpha,
                'cutiBersama' => $cutiBersama,
                'cutiHaji' => $cutiHaji,
                'tugasBelajar' => $tugasBelajar,
            ];
            
        }  
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
            $ijin = 0;
            $sakit = 0;
            $cutiSakit = 0;
            $cutiTahunan = 0;
            $cutiMelahirkan = 0;
            $dinasLuar = 0;
            $alpha = 0;
            $cutiBersama = 0;
            $cutiHaji = 0;
            $tugasBelajar = 0;
            

            $presensiData = Presensi::where('kode_finger', $user->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();
            
            foreach ($presensiData as $pd) {
                if($pd->kehadiran === 1){
                    $kehadiran++; 
                }
    
                if(isset($pd->terlambat)){
                    if($pd->kehadiran === 1){
                        $time = explode(":", $pd->terlambat);
                        if($time[0] > 0){
                            $terlambat++;
                        }elseif ($time[1] > 0) {
                            $terlambat++;
                        }elseif ($time[2] > 0) {
                            $terlambat++;
                        }
                    }
                }
                switch ($pd->jenis_perizinan) {
                    case "I":
                        $ijin++;
                        break;
                        
                    case "S":
                        $sakit++;
                        break;
                        
                    case "CS":
                        $cutiSakit++;
                        break;
                        
                    case "CT":
                        $cutiTahunan++;
                        break;
                        
                    case "CM":
                        $cutiMelahirkan++;
                        break;
                        
                    case "DL":
                        $dinasLuar++;
                        break;
                        
                    case "A":
                        $alpha++;
                        break;
                        
                    case "CB":
                        $cutiBersama++;
                        break;
                        
                    case "CH":
                        $cutiHaji++;
                        break;
                        
                    case "TB":
                        $tugasBelajar++;
                        break;

                    default:
                        // Handle any other case not covered above, if necessary.
                        break;
                }
            }

            $presensis[] = [
                'user' => $user->nama_pegawai,
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'ijin' => $ijin,
                'sakit' => $sakit,
                'cutiSakit' => $cutiSakit,
                'cutiTahunan' => $cutiTahunan,
                'cutiMelahirkan' => $cutiMelahirkan,
                'dinasLuar' => $dinasLuar,
                'alpha' => $alpha,
                'cutiBersama' => $cutiBersama,
                'cutiHaji' => $cutiHaji,
                'tugasBelajar' => $tugasBelajar,
            ];
            
        }  
        
        return view('presensi.filter',  [
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

    public function filter(Request $request)
    {   
        $selectedDate = $request->input('tanggalFilter');
        $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');
        
        $presensi = Presensi::whereDate('tanggal', $selectedDate )->get();

        return view('presensi.index',  [
            'presensi' => $presensi,
        ]);
    }

    
}