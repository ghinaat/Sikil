<?php

namespace App\Http\Controllers;

use App\Models\KodeSurat;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $surat = Surat::where('is_deleted', '0')
            ->whereIn('id_users', $user->surat->pluck('id_users'))->get();

        return view('surat.index', [
            'surat' => $surat,
            'users' => User::where('is_deleted', '0')->get(),
            'kodesurat' => KodeSurat::all(),
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
            'tgl_ajuan' => 'required',
            'tgl_surat' => 'required',
            'id_users' => 'required',
            'jenis_surat' => 'required',
            'id_kode_surat' => 'required',
            'urutan' => 'required',
            'keterangan' => 'required',
            'no_surat' => 'required',
            'status' => 'required',
            'bulan_kegiatan' => 'required',
        ]);
        $surat = new Surat();

        $surat->tgl_ajuan = now();
        $surat->tgl_surat = $request->tgl_surat;
        $surat->id_users = $request->id_users;
        $surat->jenis_surat = $request->jenis_surat;
        $surat->id_kode_surat = $request->id_kode_surat;
        $surat->urutan = $request->urutan;
        $surat->keterangan = $request->keterangan;
        $surat->no_surat = $request->no_surat;
        $surat->status = $request->status;
        $surat->bulan_kegiatan = $request->bulan_kegiatan;
        $surat->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
