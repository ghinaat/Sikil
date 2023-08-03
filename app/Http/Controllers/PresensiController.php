<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Imports\PresensiImport;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('presensi.users');
    }
    

    public function presensi(Request $request)
    {
        $tglawal = $request->input('tglawal');
        $tglakhir = date('Y-m-d', strtotime($request->input('tglakhir') . ' +1 day'));
        $presensi = Presensi::whereBetween('tanggal', [$tglawal, $tglakhir])->orderBy('tanggal', 'desc')->get();

        return view('presensi.users', compact('presensi', 'tglawal', 'tglakhir'));
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
}
