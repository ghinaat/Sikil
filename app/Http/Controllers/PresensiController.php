<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PresensiImport;

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

    public function filter(Request $request)
    {
        // $all_kegiatan = Kegiatan::all();
        // $kegiatans = Kegiatan::where('tgl_mulai', '<=', now())->where('tgl_selesai', '>=', now())->get();
        // return view('home', [
        //     'kegiatans' => $kegiatans,
        //     'all_kegiatan' => $all_kegiatan,
        // ]);
        // return view('home');
        
        $selectedDate = $request->input('tanggalFilter');
        $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');
        // $presensi = Presensi::whereDate('tanggal', $selectedDate)->get();
        $presensi = Presensi::whereDate('tanggal', $selectedDate )->get();
        // $presensi = Presensi::where('tanggal', '20');
        // dd($presensi);

        return view('presensi.index',  [
            'presensi' => $presensi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'presensi.create', [
            'presensi' => Presensi::all()
        ]);
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


}