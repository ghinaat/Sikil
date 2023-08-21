<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $generalsetting = GeneralSetting::all();

        return view('generalsetting.index', [
            'generalsetting' => $generalsetting,
            'user' => User::where('is_deleted', '0')->get(),
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
          //Menyimpan Data User Baru
        $request->validate([
            'tahun_aktif' => 'required',
            'id_users' => 'required',
            'status' => 'required',
        ]);

        $generalsetting = new GeneralSetting();

        $generalsetting->tahun_aktif = $request->tahun_aktif;
        $generalsetting->id_users = $request->id_users;
        $generalsetting->status = $request->status;

        $generalsetting->save();

        return redirect()->route('generalsetting.index')->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralSetting $generalSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralSetting $generalSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralSetting $generalSetting)
    {
        $request->validate([
            'tahun_aktif' => 'required',
            'id_users' => 'required',
            'status' => 'required',
        ]);
        $array = $request->only([
            'tahun_aktif',
            'id_users',
            'status',
        ]);
        $array['id_users'] = auth()->user()->id_users;

        GeneralSetting::where('id_users', auth()->user()->id_users)->update($array);

        return redirect()->route('generalsetting.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneralSetting $generalSetting)
    {
        //
    }
}