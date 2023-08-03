<?php

namespace App\Imports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\ToModel;

class PresensiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Presensi([
            'tanggal'       => $row['tanggal'],
            'kode_finger'   => $row['kode_finger'], 
            'jam_masuk'     => $row['jam_masuk'], 
            'jam_pulang'    => $row['jam_pulang'], 
            'terlambat'     => $row['terlambat'], 
            'pulang_cepat'  => $row['pulang_cepat'], 
            'kehadiran'     => $row['kehadiran'], 
            'jenis_perizinan' => '', 
            'is_deleted'    => '0', 
        ]);
    }
}
