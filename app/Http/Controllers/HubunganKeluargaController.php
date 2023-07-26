<?php

namespace App\Http\Controllers;

use App\Models\HubunganKeluarga;
use Illuminate\Http\Request;

class HubunganKeluargaController extends Controller
{
    public function index()
    {
        //Menampilkan data Hubungan Keluarga
        $hubkel = HubunganKeluarga::where('is_deleted', '0')->get();
        return view('hubungankeluarga.index', [
            'hubkel' => $hubkel,
        ]);
    }

    public function create()
    {
        //Menampilkan Form Tambah Hubungan Keluarga
        return view('hubkel.create');
    }

    public function store(Request $request)
    {
        //Menyimpan Data Hubungan Keluarga Baru
        $request->validate([
            'urutan' => 'required', 
            'nama' => 'required', 
            ]);

            $array = $request->only([
            'urutan',
            'nama'
            ]);
            
            $hubkel = HubunganKeluarga::create($array);
            return redirect()->route('hubkel.index')->with('success_message', 'Data telah tersimpan');
    }

    public function update(Request $request, $id_hubungan)
    { 
        //Mengedit Data Hubungan Keluarga
        $request->validate([
            'urutan' => 'required', 
            'nama' => 'required', 
            ]);

            $hubkel = HubunganKeluarga::find($id_hubungan);
            $hubkel->urutan = $request->urutan;
            $hubkel->nama = $request->nama;
            $hubkel->save();
            return redirect()->route('hubkel.index')->with('success_message', 'Data telah tersimpan');
    } 

    public function destroy($id_hubungan)
    {
        $hubkel = HubunganKeluarga::find($id_hubungan);
        if ($hubkel) {
            $hubkel->is_deleted = '1';
            $hubkel->save();
        }
        return redirect()->route('hubkel.index')->with('success_message', 'Data telah terhapus');
    }


    // public function show(HubunganKeluarga $hubunganKeluarga)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(HubunganKeluarga $hubunganKeluarga)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, HubunganKeluarga $hubunganKeluarga)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(HubunganKeluarga $hubunganKeluarga)
    // {
    //     //
    // }
}
