<?php

namespace App\Imports;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

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
        $email = Str::slug($nama_pegawai) . '@example.com';
    
        return new User([
            'kode_finger' => $kode_finger,
            'nama_pegawai' => $nama_pegawai,
            'email' => $email,
            'password' => Hash::make('12345678'),
         
           
        ]);
    }
  
}