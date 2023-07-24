<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Jabatan::create([
            'nama_jabatan' => 'Admin',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Direktur',
        ]);

        User::create([
            'nama_pegawai' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '12345678',
            'level' => 'admin',
            'id_jabatan' => '1',
            'is_deletd' => '0'
        ]);

        User::create([
            'nama_pegawai' => 'ghina',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'level' => 'admin',
            'id_jabatan' => '1',
            'is_deletd' => '1'
        ]);
    }
}