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

        $generalsetting = GeneralSetting::where('is_deleted', '0')->get();

        return view('generalsetting.index', [
            'generalsetting' => $generalsetting,
            'user' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
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
            'tahun_aktif' => 'required',
            'id_users' => 'required',
            'status' => 'required',
        ]);

        $generalsetting = new GeneralSetting();

        $generalsetting->tahun_aktif = $request->tahun_aktif;
        $generalsetting->id_users = $request->id_users;
        $generalsetting->status = $request->status;

        $generalsetting->save();

        GeneralSetting::where('id_setting', '!=', $generalsetting->id_setting)
            ->update(['status' => '0']);

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
    public function update(Request $request, $id_setting)
    {
        $request->validate([
            'tahun_aktif' => 'required',
            'id_users' => 'required',
            'status' => 'required',
        ]);

        $generalsetting = GeneralSetting::find($id_setting);

        $generalsetting->tahun_aktif = $request->tahun_aktif;
        $generalsetting->id_users = $request->id_users;
        $generalsetting->status = $request->status;

        $generalsetting->save();

        GeneralSetting::where('id_setting', '!=', $generalsetting->id_setting)
            ->update(['status' => '0']);

        return redirect()->route('generalsetting.index')->with('success_message', 'Data telah tersimpan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_setting)
    {
        $generalsetting = GeneralSetting::find($id_setting);
        if ($generalsetting) {
            $generalsetting->is_deleted = '1';
            $generalsetting->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus');
    }
}