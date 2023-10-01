<?php

namespace App\Http\Controllers;

use App\Models\PengalamanKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengalamanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            // Fetch all work experiences for admin
            $penker = PengalamanKerja::where('is_deleted', '0')->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $penker = $user->pengalamanKerja()->where('is_deleted', '0')->get();
        }

        return view('pengalamankerja.index', [
            'penker' => $penker,
        ]);
    }

    public function showAdmin(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->first();

        $penker = $user->pengalamanKerja()->where('is_deleted', '0')->get();

        return view('pengalamankerja.index', [
            'id_users' => $id_users,
            'penker' => $penker,
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
            'nama_perusahaan' => 'required',
            'masa_kerja' => 'required',
            'file_kerja' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg', // Izinkan file PDF, DOC, DOCX, PNG, dan JPG, maksimal ukuran 2MB.
            'posisi' => 'required',
            'id_users' => 'required',
        ]);

        $penker = new PengalamanKerja();

        $file = $request->file('file_kerja');
        $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->storeAs('pengalaman_kerja', $fileName, 'public');

        $penker->nama_perusahaan = $request->nama_perusahaan;
        $penker->masa_kerja = $request->masa_kerja;
        $penker->posisi = $request->posisi;
        $penker->id_users = $request->id_users;
        $penker->file_kerja = $fileName; // Simpan nama file ke dalam kolom 'file_kerja'

        $penker->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengalamanKerja $pengalamanKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengalamanKerja $pengalamanKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pengalaman_kerja)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'masa_kerja' => 'required',
            'file_kerja' => 'required:|mimes:pdf,doc,docx,png,jpg,jpeg', // Izinkan file PDF, DOC, DOCX, PNG, dan JPG, maksimal ukuran 2MB.
            'posisi' => 'required',
            'id_users' => 'required',
        ]);

        $penker = PengalamanKerja::find($id_pengalaman_kerja);

        // Cek apakah ada file yang diunggah oleh pengguna

        if ($request->hasFile('file_kerja')) {
            // Menghapus file file_kerja sebelumnya
            if ($penker->file_kerja) {
                Storage::disk('public')->delete('pengalaman_kerja/'.$penker->file_kerja);
            }

            // Upload file file_kerja baru
            $file_kerja = $request->file('file_kerja');
            $namafile_kerja = Str::random(20).'.'.$file_kerja->getClientOriginalExtension();
            Storage::disk('public')->put('pengalaman_kerja/'.$namafile_kerja, file_get_contents($file_kerja));
            $penker->file_kerja = $namafile_kerja;
        }

        $penker->nama_perusahaan = $request->nama_perusahaan;
        $penker->masa_kerja = $request->masa_kerja;
        $penker->posisi = $request->posisi;
        $penker->id_users = $request->id_users;

        $penker->save();

        return redirect()->route('penker.index')->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengalaman_kerja)
    {
        $penker = PengalamanKerja::find($id_pengalaman_kerja);
        if ($penker) {
            $penker->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('penker.index')->with('success_message', 'Data telah terhapus');
    }
}