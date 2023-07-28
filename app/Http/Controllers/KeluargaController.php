<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\User;
use App\Models\HubunganKeluarga;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->level == "admin") {
            // Fetch all work experiences for admin
            $keluarga = Keluarga::where('is_deleted', '0')->get();
        } else {
            // Fetch user's own work experiences using the relationship
            $keluarga = $user->keluarga()->where('is_deleted', '0')->get();
        }
    
        return view('keluarga.index', [
            'keluarga' => $keluarga,
            'users' => User::where('is_deleted', '0')->get(),
            'hubkel' => HubunganKeluarga::where('is_deleted', '0')->get()
        ]);
    }

    public function create()
    {
        //Menampilkan Form Tambah Keluarga
        return view(
            'keluarga.create', [
            'users' => User::where('is_deleted', '0')->get(),
            'hubkel' => HubunganKeluarga::where('is_deleted', '0')->get()
        ]);
    }

    public function store(Request $request)
    {
        //Menyimpan Data Keluarga Baru
        $request->validate([
            'id_users' => 'required',
            'id_hubungan'  => 'required',
            'nama'  => 'required',
            'tanggal_lahir'  => 'required',
            'gender'  => 'required',
            'status'  => 'required'            
            ]);

        $array = $request->only([
            'id_users',
            'id_hubungan',
            'nama',
            'tanggal_lahir',
            'gender',
            'status'            
            ]);
        $keluarga = Keluarga::create($array);
        return redirect()->route('keluarga.index')->with('success_message', 'Data telah tersimpan');
    }


    public function edit($id_keluarga){
        //Menampilkan Form Edit
        $keluarga = Keluarga::find($id_keluarga);
        if (!$keluarga) return redirect()->route('keluarga.index')->with('error_message', 'User dengan id'.$id_keluarga.' tidak ditemukan');
        return view('keluarga.edit', [
            'keluarga' => $keluarga,
            'users' => Users::where('is_deleted', '0')->get(),
            'hubkel' => HubunganKeluarga::where('is_deleted', '0')->get()
        ]); 
    }


    public function update(Request $request, $id_keluarga)
    { 
        //Mengedit Data Keluarga
        $request->validate([
            'id_users' => 'required',
            'id_hubungan'  => 'required',
            'nama' => 'required',
            'tanggal_lahir'  => 'required',
            'gender'  => 'required',
            'status'  => 'required'            
            ]);

        $keluarga = Keluarga::find($id_keluarga);
        $keluarga->id_users = $request->id_users;
        $keluarga->id_hubungan = $request->id_hubungan;
        $keluarga->nama = $request->nama;
        $keluarga->tanggal_lahir = $request->tanggal_lahir;
        $keluarga->gender = $request->gender;
        $keluarga->status = $request->id_users;
        $keluarga->save();
        return redirect()->route('keluarga.index') ->with('success_message', 'Data telah tersimpan');
    } 

    public function destroy($id_keluarga)
    {
        $keluarga = Keluarga::find($id_keluarga);
        if ($keluarga) {
            $keluarga->is_deleted = '1';
            $keluarga->save();
        }
        return redirect()->route('keluarga.index')->with('success_message', 'Data telah terhapus');
    }

    

    // public function show(Keluarga $keluarga)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Keluarga $keluarga)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Keluarga $keluarga)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Keluarga $keluarga)
    // {
    //     //
    // }
}