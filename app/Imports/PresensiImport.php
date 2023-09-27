<?php

namespace App\Imports;
use App\Models\User;
use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

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
        $formattedDate = date_create_from_format('m/d/Y', $row[2]);
        $tanggal = date_format($formattedDate, 'Y-m-d');
        $kodeFinger = $row[0];
        $user = User::where('kode_finger', $kodeFinger)->first();

        if ($user) {
            $presensi = new Presensi([
                'kode_finger' => $row[0],
                'tanggal' => $tanggal,
                'jam_masuk' => $row[6],
                'jam_pulang' => $row[7],
                'terlambat' => $row[8],
                'pulang_cepat' => $row[9],
                'kehadiran' => $row[12],
            ]);
            
            // Save the Presensi model to the database
            $presensi->save();
    
            return $presensi;
        }
    }
}