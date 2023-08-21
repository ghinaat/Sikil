<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CutiExport implements FromView
{
    protected $cutis;

    public function __construct($cutis)
    {
        $this->cutis = $cutis;
    }
    public function view(): View
    {
        return view('cuti.export_file', [
            'cutis' => $this->cutis,
        ]);
    }
}
