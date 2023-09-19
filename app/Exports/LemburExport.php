<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LemburExport implements FromView
{
    protected $lemburs;

    public function __construct($lemburs)
    {
        $this->lemburs = $lemburs;
    }

    public function view(): View
    {
        // dd($this->lemburs['data']);

        return view('lembur.export_file', [
            'lemburs' => $this->lemburs,
        ]);
    }
}
