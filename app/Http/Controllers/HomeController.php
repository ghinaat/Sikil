<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Carbon\Carbon;

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
    }
}