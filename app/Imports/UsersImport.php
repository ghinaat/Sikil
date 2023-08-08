<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Start reading data from row 2 (skipping headers in row 1)
    }

    public function model(array $row)
    {
        $kode_finger = $row[0];
        $nama_pegawai = $row[1];

        if (empty($nama_pegawai)) {
            return null; // Or handle the empty value as needed, like skipping the User creation
        }

        // Use the email from the imported data if available, otherwise create a unique one
        $email = Str::slug($nama_pegawai).'@example.com';

        return new User([
            'kode_finger' => $kode_finger,
            'nama_pegawai' => $nama_pegawai,
            'email' => $email,
            'password' => Hash::make('12345678'),

        ]);
    }
}
