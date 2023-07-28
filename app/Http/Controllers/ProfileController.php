<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\TingkatPendidikan;
use PDF;

class ProfileController extends Controller
{
    public function createPdf(){
        $user = Profile::where('id_users', auth()->user()->id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        $pdf = PDF::loadView('layouts.cv',  [
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Profile::where('id_users', auth()->user()->id_users)->first();

        $tingkat_pendidikan = TingkatPendidikan::all();
        
        return view('profile.index', [
            'user' => $user,
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
        $user = Profile::where('id_users', auth()->user()->id_users)->first();
        $tingkat_pendidikan = TingkatPendidikan::all();

        return view('layouts.cv',  [
            'user' => $user,
            'tingkat_pendidikans' => $tingkat_pendidikan,
        ]);
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

        $test = Profile::where('id_users', auth()->user()->id_users)->update($array);

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