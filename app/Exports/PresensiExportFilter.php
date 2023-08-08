<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiExportFilter implements FromView
{
    protected $presensis;

    public function __construct($presensis)
    {
        $this->presensis = $presensis;
    }

    public function view(): View
    {
        return view('presensi.export_filter', [
            'presensis' => $this->presensis,
        ]);
    }
}
