<?php

namespace App\Http\Controllers;

use App\Models\BarangPpr;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BarangPprController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangppr = BarangPpr::where('is_deleted', '0')->get();

        return view('barangppr.index', [
            'barangppr' => $barangppr,
            'ruangan' => Ruangan::where('is_deleted', '0')->get(),
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
            'id_ruangan' => 'required',
            'nama_barang' => 'required',
            'tahun_pembuatan' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'image' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $barangppr = new BarangPpr();

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->storeAs('image_barangppr', $fileName, 'public');
            
            $barangppr->image = $fileName;
        }

        $barangppr->id_ruangan = $request->id_ruangan;
        $barangppr->nama_barang = $request->nama_barang;
        $barangppr->tahun_pembuatan = $request->tahun_pembuatan;
        $barangppr->jumlah = $request->jumlah;
        $barangppr->keterangan = $request->keterangan;

        $barangppr->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_barang_ppr)
    {
        $barangppr = BarangPpr::where('id_barang_ppr', $id_barang_ppr)->where('is_deleted', '0')->get()[0];

        return view('barangppr.show', [
            'barangppr' => $barangppr,
            'ruangan' => Ruangan::where('is_deleted', '0')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangPpr $barangPpr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barang_ppr)
    {
        $request->validate([
            'id_ruangan' => 'required',
            'nama_barang' => 'required',
            'tahun_pembuatan' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'image' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $barangppr = BarangPpr::find($id_barang_ppr);

        if (! $barangppr) {
            return redirect()->back()->with('error_message', 'Data tidak ditemukan');
        }

        $barangppr->id_ruangan = $request->id_ruangan;
        $barangppr->nama_barang = $request->nama_barang;
        $barangppr->tahun_pembuatan = $request->tahun_pembuatan;
        $barangppr->jumlah = $request->jumlah;
        $barangppr->keterangan = $request->keterangan;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = Str::random(10).'.'.$fileExtension; 
            $file->storeAs('image_barangppr', $fileName, 'public'); 
            $barangppr->image = $fileName;
        }

        $barangppr->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_barang_ppr)
    {
        $barangppr = BarangPpr::find($id_barang_ppr);
        if ($barangppr) {
            $barangppr->is_deleted = '1';
            $barangppr->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus');
    }
}
