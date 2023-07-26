<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\PengalamanKerja;
use Illuminate\Http\Request;

class PengalamanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if (Auth::user()->id) {
        $idUsers = Auth::user()->id;
        $penker = PengalamanKerja::where('id_users', $idUsers)->get();
    } else {
        $penker = PengalamanKerja::where('is_deleted', '0')->get();
    }

    return view('pengalamankerja.index', [
        'penker' => $penker,
        'users' => User::all()
    ]);
}
    // public function index()
    // {
    //     if(Auth::user()->id){
    //         $penker = PengalamanKerja::where('id_users', 'id_users')->get();
    //     }else{
    //     $penker = PengalamanKerja::where('is_deleted', '0')->get();
    // }
    //     return view('pengalamankerja.index', [
    //         'penker' => $penker,
    //         'users' => User::all()
    //     ]);
    // }

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
        $fileName = $file->getClientOriginalName();
        $file->storeAs('Pengalaman Kerja', $fileName, 'public'); // Simpan file di dalam folder public/Pengalaman Kerja
    
        $penker->nama_perusahaan = $request->nama_perusahaan;
        $penker->masa_kerja = $request->masa_kerja;
        $penker->posisi = $request->posisi;
        $penker->id_users = $request->id_users;
        $penker->file_kerja = $fileName; // Simpan nama file ke dalam kolom 'file_kerja'
    
        $penker->save();
    
        return redirect()->back()->with('success', 'Data pengalaman kerja berhasil disimpan.');
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
    public function update(Request $request, PengalamanKerja $pengalamanKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengalamanKerja $pengalamanKerja)
    {
        //
    }
}