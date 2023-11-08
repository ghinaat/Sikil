<?php

namespace App\Http\Controllers;

use App\Models\BarangTik;
use App\Models\Ruangan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BarangTikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangTik = BarangTik::where('is_deleted', '0')->get();
        $ruangan = Ruangan::where('is_deleted', '0')->get();

        return view('barangtik.index',[
            'barangTik' => $barangTik,
            'ruangan' => $ruangan,
        ]);
    }

    public function show($id_barang_tik)
    {
        $barangTik = BarangTik::findOrFail($id_barang_tik);
        $ruangan = Ruangan::where('is_deleted', '0')->get();

        return view('barangtik.show',[
            'barangTik' => $barangTik,
            'ruangan' => $ruangan,
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
        // dd($request);
        $request->validate([
            'id_ruangan' => 'required',
            'jenis_aset' => 'required',
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'merek' => 'required',
            'kelengkapan' => 'required',
            'tahun_pembelian' => 'required',
            'kondisi' => 'required',
            'status_pinjam' => 'required',
            'keterangan' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        $barangTik = new BarangTik();
        $barangTik->id_ruangan = $request->id_ruangan;
        $barangTik->jenis_aset = $request->jenis_aset;
        $barangTik->kode_barang = $request->kode_barang;
        $barangTik->nama_barang = $request->nama_barang;
        $barangTik->merek = $request->merek;
        $barangTik->kelengkapan = $request->kelengkapan;
        $barangTik->tahun_pembelian = $request->tahun_pembelian;
        $barangTik->kondisi = $request->kondisi;
        $barangTik->status_pinjam = $request->status_pinjam;
        $barangTik->keterangan = $request->keterangan;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->storeAs('imageTIK', $fileName, 'public');
            
            $barangTik->image = $fileName;
        }else{
            $barangTik->image = null;
        }

        $barangTik->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangTik $barangTik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barang_tik)
    {
        $request->validate([
            'id_ruangan' => 'required',
            'jenis_aset' => 'required',
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'merek' => 'required',
            'kelengkapan' => 'required',
            'tahun_pembelian' => 'required',
            'kondisi' => 'required',
            'status_pinjam' => 'required',
            'keterangan' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        $barangTik = BarangTik::find($id_barang_tik);

        $barangTik->id_ruangan = $request->id_ruangan;
        $barangTik->jenis_aset = $request->jenis_aset;
        $barangTik->kode_barang = $request->kode_barang;
        $barangTik->nama_barang = $request->nama_barang;
        $barangTik->merek = $request->merek;
        $barangTik->kelengkapan = $request->kelengkapan;
        $barangTik->tahun_pembelian = $request->tahun_pembelian;
        $barangTik->kondisi = $request->kondisi;
        $barangTik->status_pinjam = $request->status_pinjam;
        $barangTik->keterangan = $request->keterangan;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->storeAs('imageTIK', $fileName, 'public');
            
            $barangTik->image = $fileName;
        }else{
            $barangTik->image = null;
        }

        $barangTik->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_barang_tik)
    {
        $barangTik = BarangTik::find($id_barang_tik);
        if ($barangTik) {
            $barangTik->update([
                'is_deleted' => '1',
            ]);
        }
        return redirect()->route('barangtik.index')->with('success_message', 'Data telah terhapus');
    }
}