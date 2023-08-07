<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kegiatan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_kegiatan = Kegiatan::all();
        $kegiatans = Kegiatan::whereDate('tgl_mulai', '=', today())
        ->where('tgl_selesai', '>=', today())
        ->get();
        
            return view('home', [
            'kegiatans' => $kegiatans,
            'all_kegiatan' => $all_kegiatan,
        ]);
        return view('home');


        // $now = Carbon::now();

        // $all_kegiatan = Kegiatan::all();
        // $ongoingKegiatans = Kegiatan::where('tgl_mulai', '<=', $now)
        //     ->where('tgl_selesai', '>=', $now)
        //     ->get();

        // $todayKegiatans = Kegiatan::where('tgl_mulai', '=', $now)
        //     ->where('tgl_selesai', '==', $now)
        //     ->get();

        // $ongoingKegiatans->push($todayKegiatans);

        // return view('home', [
        //     'kegiatans' => $ongoingKegiatans,
        //     'all_kegiatan' => $all_kegiatan,
        // ]);
    }
}