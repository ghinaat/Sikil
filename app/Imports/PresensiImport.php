<?php

namespace App\Imports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PresensiImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Start reading data from row 2 (skipping headers in row 1)
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]));

        return new Presensi([
            'kode_finger' => $row[0],
            'tanggal' => $tanggal->format('Y-m-d'),
            'jam_masuk' => $row[5],
            'jam_pulang' => $row[6],
            'terlambat' => $row[7],
            'pulang_cepat' => $row[8],
            'kehadiran' => $row[12],
        ]);
    }
}