<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Exports\LemburExport;
use Maatwebsite\Excel\Facades\Excel;

class LemburController extends Controller
{
    public function export(Request $request) 
    {
        $users = User::where('is_deleted', '0')->get();

        $lemburs = [];

        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $lemburs['data'] = Lembur::whereBetween('tanggal' , [$start_date, $end_date])->get();

        $lemburs['start_date'] = $start_date;       
        $lemburs['end_date'] = $end_date;

        return Excel::download(new LemburExport($lemburs), 'lembur.xlsx');

    }

    public function filterAdmin(Request $request)
    {
        $users = User::where('is_deleted', '0')->get();

        $lembur = [];

        $defaultStartDate = '2023-01-01';
        $defaultEndDate = '2023-12-31';

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $lemburData = Lembur::where('kode_finger', $user->kode_finger)->whereBetween('tanggal', [$start_date, $end_date])->get();

        return view('lembur.filter', [
            'lembur' => $lembur,
        ]);

    }

    public function index()
    {
        $user = auth()->user();
        $lembur = Lembur::where('is_deleted', '0')
        ->whereIn('kode_finger', $user->lembur->pluck('kode_finger'))
        ->get();
    
        return view('lembur.index', [
            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function rekap()
    {
        $lembur = Lembur::where('is_deleted', '0')
        ->get();
    
        return view('lembur.rekap', [
            'lembur' => $lembur,
            'users' => User::where('is_deleted', '0')->get(),
        ]);
    }

    public function filter(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $lembur = Lembur::where('is_deleted', '0')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->get();

    return view('lembur.rekap', [
        'lembur' => $lembur,
        'users' => User::where('is_deleted', '0')->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); // Tambahkan ini untuk melihat data yang dikirimkan dari formulir
        // Validasi data yang diterima dari form
        $request->validate([
            'id_atasan' => 'required',
            'kode_finger' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tugas' => 'required|string',
        ]);

         // Menghitung jam lembur dari jam mulai dan jam selesai
        $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $request->input('jam_mulai'));
        $jamSelesai = \Carbon\Carbon::createFromFormat('H:i', $request->input('jam_selesai'));
        $diffInMinutes = $jamMulai->diffInMinutes($jamSelesai);

        // Membuat objek Lembur baru dan mengisi atributnya
        $lembur = new Lembur();
        $lembur->kode_finger = $request->kode_finger;
        $lembur->id_atasan = $request->id_atasan;
        $lembur->tanggal = $request->input('tanggal');
        $lembur->jam_mulai = $request->input('jam_mulai');
        $lembur->jam_selesai = $request->input('jam_selesai');
        $lembur->jam_lembur = floor($diffInMinutes / 60) . ':' . ($diffInMinutes % 60); // Jam dan menit
        $lembur->tugas = $request->input('tugas');
        $lembur->status_izin_atasan = null;

        // Simpan data lembur ke database
        $lembur->save();


        // Redirect kembali ke halaman list lembur dengan pesan sukses
        return redirect()->route('lembur.index')->with('success', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lembur $lembur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lembur $lembur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lembur $lembur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_lembur)
    {
        $lembur = Lembur::find($id_lembur);
        
        if ($lembur) {
            $lembur->delete();
            return redirect()->route('lembur.index')->with('success_message', 'Data telah terhapus.');
        } else {
            return redirect()->route('lembur.index')->with('error_message', 'Data tidak ditemukan.');
        }
    }
}
