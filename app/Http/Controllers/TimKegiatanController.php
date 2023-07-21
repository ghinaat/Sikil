<?php

namespace App\Http\Controllers;
use App\Models\TimKegiatan;
use Illuminate\Http\Request;

class TimKegiatanController extends Controller
{
    public function index()
    {
        $tkgtn = TimKegiatan::all();
        return view('timkegiatan.index', [
            'timkegiatan' => $tkgtn
        ]);
    }
}