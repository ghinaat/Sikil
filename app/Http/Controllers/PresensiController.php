<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Imports\PresensiImport;
use Carbon\Carbon;

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
        $selectedDate = $request->input('tanggalFilter');
        $selectedDate = Carbon::parse($selectedDate)->format('Y-m-d');

        $presensi = Presensi::whereDate('tanggal', $selectedDate )->get();
        return view('presensi.index',  [
            'presensi' => $presensi,
        ]);
    }

    public function filteruser(Request $request)
    {
        $tglawal = $request->input('tglawal');
        $tglakhir = date('Y-m-d', strtotime($request->input('tglakhir') . ' +1 day'));
        $presensi = Presensi::whereBetween('tanggal', [$tglawal, $tglakhir])->orderBy('tanggal', 'desc')->get();

        return view('presensi.index', compact('presensi', 'tglawal', 'tglakhir'));
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
}
