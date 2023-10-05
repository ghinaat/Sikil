<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            // Fetch all work experiences for admin
            $arsip = Arsip::where('is_deleted', '0')->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $arsip = $user->arsip()->where('is_deleted', '0')->get();
        }

        return view('arsip.index', [
            'arsip' => $arsip,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function showAdmin(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->first();
        $arsip = Arsip::where('id_users', $user->id_users)->where('is_deleted', '0')->get();

        return view('arsip.index', [
            'id_users' => $id_users,
            'arsip' => $arsip,
            'users' => User::where('is_deleted', '0')->get(), // Tambahkan ini untuk data pegawai
        ]);
    }

    public function create()
    {
        //Menampilkan Form Tambah Arsip
        // return view(
        //     'arsip.create', [
        //     'users' => User::where('is_deleted', '0')->get(),
        // ]);

    }

    public function store(Request $request)
    {
        //Menyimpan Data Arsip
        $request->validate([
            'id_users' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $arsip = new Arsip();
        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = Str::random(20).'.'.$fileExtension; // Nama file acak dengan ekstensi asli
        $file->storeAs('arsip', $fileName, 'public'); // Simpan file di dalam folder public/arsip

        $arsip->id_users = $request->id_users;
        $arsip->jenis = $request->jenis;
        $arsip->keterangan = $request->keterangan;
        $arsip->file = $fileName; // Simpan nama file ke dalam kolom 'file_kerja'

        $arsip->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    public function edit($id_arsip)
    {
        //Menampilkan Form Edit
        $arsip = Arsip::find($id_arsip);
        if (! $arsip) {
            return redirect()->route('arsip.index')->with('error_message', 'User dengan id'.$id_arsip.' tidak ditemukan');
        }

        return view('arsip.edit', [
            'arsip' => $arsip,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function update(Request $request, $id_arsip)
    {
        //Mengedit Data Arsip
        $request->validate([
            'id_users' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
            'file' => 'mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $arsip = Arsip::find($id_arsip);
        if (! $arsip) {
            return redirect()->back()->with('error_message', 'Data tidak ditemukan.');
        }

        $arsip->id_users = $request->id_users;
        $arsip->jenis = $request->jenis;
        $arsip->keterangan = $request->keterangan;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = Str::random(5).'.'.$fileExtension; // Nama file acak dengan ekstensi asli
            $file->storeAs('arsip', $fileName, 'public'); // Simpan file di dalam folder public/arsip
            $arsip->file = $fileName; // Simpan nama file ke dalam kolom 'file'
        }
        $arsip->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    public function destroy($id_arsip)
    {
        $arsip = Arsip::find($id_arsip);
        if ($arsip) {
            $arsip->is_deleted = '1';
            $arsip->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
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
