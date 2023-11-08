<?php

namespace App\Http\Controllers;

use App\Models\SirkulasiBarang;
use App\Models\BarangPpr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SirkulasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = auth()->user();
        $sirkulasibarang = SirkulasiBarang::where('is_deleted', '0')->get();

        return view('sirkulasibarang.index', [
            'sirkulasibarang' => $sirkulasibarang,
            'barangppr' => BarangPpr::where('is_deleted', '0')->get(),
            'users' => User::where('is_deleted', '0')->get(),
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
        'id_barang_ppr'=> 'required',
        'id_users'=> 'required',
        'jumlah'=> 'required',
        'jenis_sirkulasi'=> 'required',
        'keterangan' => 'required',
    ]);

    $barangppr = BarangPpr::find($request->id_barang_ppr);
    $jumlahSirkulasi = $request->jumlah;

    // Validasi tambahan untuk pengurangan
    if ($request->jenis_sirkulasi === 'Pengurangan') {
        // Periksa apakah jumlah sirkulasi lebih besar dari jumlah yang ada di BarangPpr
        if ($jumlahSirkulasi > $barangppr->jumlah) {
            return redirect()->back()->with('error', 'Jumlah pengurangan melebihi stok yang tersedia.');
        }
        
        // Update data di tabel BarangPpr
        $barangppr->jumlah -= $jumlahSirkulasi;
        $barangppr->save();
    } elseif ($request->jenis_sirkulasi === 'Penambahan') {
        // Update data di tabel BarangPpr
        $barangppr->jumlah += $jumlahSirkulasi;
        $barangppr->save();
    }

        $sirkulasibarang = new SirkulasiBarang();

        $sirkulasibarang->id_barang_ppr = $request->id_barang_ppr;
        $sirkulasibarang->id_users = $request->id_users;
        $sirkulasibarang->jumlah = $request->jumlah;
        $sirkulasibarang->jenis_sirkulasi = $request->jenis_sirkulasi;
        $sirkulasibarang->keterangan = $request->keterangan;
        $sirkulasibarang->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SirkulasiBarang $sirkulasiBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SirkulasiBarang $sirkulasiBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SirkulasiBarang $sirkulasiBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SirkulasiBarang $sirkulasiBarang)
    {
        //
    }
}
