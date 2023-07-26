<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        //Menampilkan Data Arsip
        $arsip = Arsip::where('is_deleted', '0')->get();
        return view('arsip.index', [
            'arsip' => $arsip,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function create()
    {
        //Menampilkan Form Tambah Arsip
        return view(
            'arsip.create', [
            'users' => User::where('is_deleted', '0')->get(),
        ]);

    }

    public function store(Request $request)
    {
        //Menyimpan Data Keluarga Baru
        $request->validate([
            'id_users' => 'required',
            'jenis'  => 'required',
            'keterangan'  => 'required',
            'file'  => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
            ]);

        $array = $request->only([
            'id_users',
            'jenis',
            'keterangan',
            'file'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('storage', $filename, 'public');
                $ap->file = $filePath;
            }   
        
        $arsip = Arsip::create($array);
        return redirect()->route('arsip.index')->with('success_message', 'Data telah tersimpan');
    }


    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Arsip $arsip)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Arsip $arsip)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Arsip $arsip)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Arsip $arsip)
    // {
    //     //
    // }
}
