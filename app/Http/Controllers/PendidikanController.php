<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use App\Models\TingkatPendidikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            // Fetch all work experiences for admin
            $pendidikan = Pendidikan::where('is_deleted', '0')->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $pendidikan = $user->pendidikan()->where('is_deleted', '0')->get();
        }

        return view('pendidikan.index', [
            'pendidikan' => $pendidikan,
            'user' => User::where('is_deleted', '0')->get(),
            'tingpen' => TingkatPendidikan::where('is_deleted', '0')->get(),
        ]);
    }

    public function showAdmin(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->first();
        $pendidikan = $user->pendidikan()->where('is_deleted', '0')->get();

        return view('pendidikan.index', [
            'id_users' => $id_users,
            'pendidikan' => $pendidikan,
            'tingpen' => TingkatPendidikan::where('is_deleted', '0')->get(),
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
        $request->validate([
            'nama_sekolah' => 'required',
            'jurusan' => 'required',
            'ijazah' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048', // Izinkan file PDF, DOC, DOCX, PNG, dan JPG, maksimal ukuran 2MB.
            'tahun_lulus' => 'required|digits:4|integer|min:1950',
            'id_users' => 'required',
            'id_tingkat_pendidikan' => 'required',
        ]);

        $pendidikan = new Pendidikan();

        if ($request->hasFile('ijazah')) {
            $file = $request->file('ijazah');
            $fileName = Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pendidikan', $fileName, 'public'); // Simpan file di dalam folder public/ Kerja
    
            $pendidikan->ijazah = $fileName; // Simpan nama file ke dalam kolom 'ijazah'
        }

        $pendidikan->nama_sekolah = $request->nama_sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahun_lulus = $request->tahun_lulus;
        $pendidikan->id_users = $request->id_users;
        $pendidikan->id_tingkat_pendidikan = $request->id_tingkat_pendidikan;

        $pendidikan->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pendidikan)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'jurusan' => 'required',
            'ijazah' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:2048', // Izinkan file PDF, DOC, DOCX, PNG, JPG, dan JPEG, maksimal ukuran 2MB.
            'tahun_lulus' => 'required|digits:4|integer|min:1950',
            'id_users' => 'required',
            'id_tingkat_pendidikan' => 'required',
        ]);

        $pendidikan = Pendidikan::find($id_pendidikan);
        if ($request->hasFile('ijazah')) {
            // Menghapus file ijazah sebelumnya
            if ($pendidikan->ijazah) {
                Storage::disk('public')->delete('pendidikan/'.$pendidikan->ijazah);
            }

            // Upload file ijazah baru
            $ijazah = $request->file('ijazah');
            $fileName = Str::random(5).'.'.$ijazah->getClientOriginalExtension();
            $ijazah->storeAs('pendidikan', $fileName, 'public'); // Simpan file di dalam folder public/ Kerja
            $pendidikan->ijazah = $fileName; // Simpan nama file ke dalam kolom 'file_kerja'
        }

        $pendidikan->nama_sekolah = $request->nama_sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahun_lulus = $request->tahun_lulus;
        $pendidikan->id_users = $request->id_users;
        $pendidikan->id_tingkat_pendidikan = $request->id_tingkat_pendidikan;

        $pendidikan->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pendidikan)
    {
        $pendidikan = Pendidikan::find($id_pendidikan);
        if ($pendidikan) {
            $pendidikan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('pendidikan.index')->with('success_message', 'Data telah terhapus.');
    }
}