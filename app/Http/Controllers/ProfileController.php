<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\TingkatPendidikan;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class ProfileController extends Controller
{
    public function createPdf()
    {
        $main_user = User::where('id_users', auth()->user()->id_users)->first();
        $user = Profile::where('id_users', auth()->user()->id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        $pdf = PDF::loadView('layouts.cv', [
            'main_user' => $main_user,
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
        // download PDF file with download method
        return $pdf->download($main_user->nama_pegawai.'\'s cv.pdf');
    }

    public function createPdfAdmin(Request $request, $id_users)
    {
        $main_user = User::where('id_users', $id_users)->first();
        $user = Profile::where('id_users', $id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        $pdf = PDF::loadView('layouts.cv', [
            'main_user' => $main_user,
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
        // download PDF file with download method
        return $pdf->download($main_user->nama_pegawai.'\'s cv.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('id_users', auth()->user()->id_users)->first();
        $user_profile = Profile::where('id_users', auth()->user()->id_users)->first();
        $jabatan = Jabatan::all();

        $tingkat_pendidikan = TingkatPendidikan::all();

        return view('profile.index', [
            'main_user' => $user,
            'user' => $user_profile,
            'jabatan' => $jabatan,
            'tingkat_pendidikans' => $tingkat_pendidikan,
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

    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('profile.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_users)
    {
        $rules = [
            'nama_pegawai' => 'required',
            'email' =>  'required',
            'id_jabatan' => 'required',
            'nip' => 'nullable',
            'nik' => 'nullable',
            'kk' => 'nullable',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'alamat' => 'nullable',
            'no_hp' => 'nullable',
            'agama' => 'nullable',
            'gender' => 'nullable',
            'pendidikan' => 'nullable',
            'tmt' => 'nullable',
            'status_kawin' => 'nullable',
            'bpjs' => 'nullable',
            'id_tingkat_pendidikan' => 'required',
        ];


        if ($request->file('photo')) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg';
        }


        $user = User::find($id_users);

        $user->update([
            'nama_pegawai' => $request->input('nama_pegawai'),
            'email' => $request->input('email'),
            'id_jabatan' => $request->input('id_jabatan'),
        ]);

        $validatedData = $request->validate($rules);

        $lastProfile = Profile::where('id_users', $id_users)->first();

        // if ($request->file('photo')) {
        //     if ($lastProfile->photo) {
        //         Storage::delete($lastProfile->photo);
        //     }

        //     $validatedData['photo'] = str_replace('public/profile/', '', $request->file('photo')->store('public/profile'));

        // }

        $profile = Profile::where('id_users', $id_users)->first();


        $profile->update([
            'nip' => $request->input('nip'),
            'nik' => $request->input('nik'),
            'kk' => $request->input('kk'),
            'gelar_depan' => $request->input('gelar_depan'),
            'gelar_belakang' => $request->input('gelar_belakang'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'no_hp' => $request->input('no_hp'),
            'agama' => $request->input('agama'),
            'gender' => $request->input('gender'),
            'pendidikan' => $request->input('pendidikan'),
            'tmt' => $request->input('tmt'),
            'status_kawin' => $request->input('status_kawin'),
            'bpjs' => $request->input('bpjs'),
            'id_tingkat_pendidikan' => $request->input('id_tingkat_pendidikan'),
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($profile->photo) {
                Storage::delete('public/profile/' . $profile->photo);
            }
    
            // Simpan foto baru dan simpan nama file di database
            $photoPath = $request->file('photo')->store('public/profile');
            $profile->update([
                'photo' => str_replace('public/profile/', '', $photoPath)
            ]);
        }

        return redirect()->back()->with('success_message', 'Profile berhasil diubah!.');
    }

    public function arrayExclude($array, Array $excludeKeys){
        foreach($excludeKeys as $key){
            unset($array[$key]);
        }
        return $array;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}