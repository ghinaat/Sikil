<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\ToModel;

class PresensiImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Start reading data from row 2 (skipping headers in row 1)
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $formattedDate = date_create_from_format('m/d/Y', $row[2]);
        $tanggal = date_format($formattedDate, 'Y-m-d');
        $isPresent = !empty($row[5]) && !empty($row[6]); // Check if jam_masuk and jam_pulang are not empty
        return new Presensi([
            'kode_finger'   => $row[0], 
            'tanggal'       => $tanggal,
            'jam_masuk'     => $row[5], 
            'jam_pulang'    => $row[6], 
            'terlambat'     => $row[7], 
            'pulang_cepat'  => $row[8], 
            'kehadiran'     => $isPresent,
        ]);
    }
}