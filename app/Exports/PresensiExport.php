<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithFooter;
use Maatwebsite\Excel\Concerns\FromView;



class PresensiExport implements FromView
{
    public function view(): View
    {
        return view('layouts.excel', [
            'presensis' => Presensi::all()
        ]);
    }
}