<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithFooter;


class PresensiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Presensi::select([
            'id_presensi',
            'kode_finger',
            'tanggal',
            'jam_masuk',
            'jam_pulang',
            'terlambat',
            'pulang_cepat',
            'kehadiran',
            'jenis_perizinan',
        ])->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'kode_finger',
            'tanggal',
            'jam_masuk',
            'jam_pulang',
            'terlambat',
            'pulang_cepat',
            'kehadiran',
            'jenis_perizinan',
        ];
    }
}