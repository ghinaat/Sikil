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
        if (strtotime($row[12]) === false) {
            $kehadiran = null;
        } else {
            $kehadiran = $row[12];
        }
        if (strtotime($row[8]) === false) {
            $terlambat = null; // Data tidak valid, set NULL
        } else {
            $terlambat = $row[8];
        }
          if (strtotime($row[9]) === false) {
            $pulangCepat = null; // Data tidak valid, set NULL
        } else {
            $pulangCepat = $row[9];
        }
         if (strtotime($row[6]) === false) {
            $jamMasuk = null; // Data tidak valid, set NULL
        } else {
            $jamMasuk = $row[6];
        }
         if (strtotime($row[7]) === false) {
            $jamPulang = null; // Data tidak valid, set NULL
        } else {
            $jamPulang = $row[7];
        }


        if ($user) {
            $presensi = new Presensi([
                'kode_finger' => $row[0],
                'tanggal' => $tanggal,
                'jam_masuk' => $jamMasuk,
                'jam_pulang' => $jamPulang,
                'terlambat' => $terlambat,
                'pulang_cepat' => $pulangCepat,
                'kehadiran' => $kehadiran,
            ]);
            // Save the Presensi model to the database
            $presensi->save();

            return $presensi;
        }
    }
}