<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\TingkatPendidikan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class ProfileController extends Controller
{
    public function createPdf(){
        $main_user = User::where('id_users', auth()->user()->id_users)->first();
        $user = Profile::where('id_users', auth()->user()->id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        $pdf = PDF::loadView('layouts.cv',  [
            'main_user' => $main_user,
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
        // download PDF file with download method
        return $pdf->download($main_user->nama_pegawai . '\'s cv.pdf');
    }

    public function createPdfAdmin(Request $request, $id_users){
        $main_user = User::where('id_users', $id_users)->first();
        $user = Profile::where('id_users', $id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        $pdf = PDF::loadView('layouts.cv',  [
            'main_user' => $main_user,
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
        // download PDF file with download method
        return $pdf->download($main_user->nama_pegawai . '\'s cv.pdf');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('id_users', auth()->user()->id_users)->first();
        $user_profile = Profile::where('id_users', auth()->user()->id_users)->first();

        $tingkat_pendidikan = TingkatPendidikan::all();
        
        return view('profile.index', [
            'main_user' => $user,
            'user' => $user_profile,
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
    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'nip' => 'required',
            'nik' => 'required',
            'kk' => 'required',
            'gelar_depan' => 'required',
            'gelar_belakang' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'agama' => 'required',
            'gender' => 'required',
            'pendidikan' => 'required',
            'tmt' => 'required',
            'status_kawin' => 'required',
            'bpjs' => 'required',
            'id_tingkat_pendidikan' => 'required',
        ]);

        $array = $request->only([
            'nip',
            'nik', 
            'kk',
            'gelar_depan',
            'gelar_belakang',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'no_hp',
            'agama',
            'gender',
            'pendidikan',
            'tmt',
            'status_kawin',
            'bpjs',
            'id_tingkat_pendidikan',
        ]);

        if($request->file('photo')){
            if($profile->photo){
                Storage::delete($profile->photo);
            }
            
            $array['photo'] =  str_replace("public/profile/", "",$request->file('photo')->store('public/profile'));
        }

        $array['id_users'] = auth()->user()->id_users;

        Profile::where('id_users', auth()->user()->id_users)->update($array);

        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}