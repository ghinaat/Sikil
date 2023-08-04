<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;    
use Illuminate\Http\Request;
use App\Imports\PresensiImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->level == "admin") {
            // Fetch all work experiences for admin
            $presensi = Presensi::where('is_deleted', '0')->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $presensi = $user->presensi()->where('is_deleted', '0')->get();
        }
    
        return view('presensi.index', [
            'presensi' => $presensi,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }
    
    public function filter(Request $request)
    {        
        $selectedDate = $request->input('tanggalFilter');
        $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');
    
        $user = Auth::user();
        if ($user->level == "admin") {
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
        if ($user->level == "admin") {
            $kode_finger = $request->input('kode_finger');
        } else {
            $kode_finger = $user->kode_finger;
        }
        $tglawal = $request->input('tglawal');
        $tglakhir = date('Y-m-d', strtotime($request->input('tglakhir') . ' +1 day'));
    
        $presensi = Presensi::where('kode_finger', $kode_finger)
                            ->whereBetween('tanggal', [$tglawal, $tglakhir])
                            ->orderBy('tanggal', 'desc')
                            ->get();
    
        return view('presensi.index', compact('presensi', 'tglawal', 'tglakhir'));
    }

    public function create()
    {
        return view(
            'presensi.create', [
            'presensi' => Presensi::all()
        ]);
    }

    public function export(){
        return Excel::download(new PresensiExport, 'presensi_pegawai.xlsx');
    }

    public function showImportForm(Request $request)
    {
        $presensi = Presensi::where('is_deleted', '0')->get();

        return view('presensi.import', [
            'presensi' => $presensi,
            
        ]);
    }

    public function import(Request $request)
    {
        Excel::import(new PresensiImport, $request->file('file')->store('presensi'));

        return redirect()->back()->with([
            'success_message' => 'Data telah Tersimpan',
        ]);
    }

    // public function store(Request $request)
    // {
        
    // }

    // public function show(Presensi $presensi)
    // {
        
    // }

    // public function edit(Presensi $presensi)
    // {
        
    // }

    // public function update(Request $request, Presensi $presensi)
    // {
        
    // }

    // public function destroy(Presensi $presensi)
    // {
        
    // }
}