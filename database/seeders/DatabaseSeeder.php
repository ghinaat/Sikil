<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Profile;
use App\Models\TingkatPendidikan;
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

        TingkatPendidikan::create([
            'nama_tingkat_pendidikan' => 'Sarjana Terapan'
        ]);

        User::create([
            'nama_pegawai' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'admin',
            'id_jabatan' => '1',
            'is_deleted' => '0'
        ]);

        Profile::create([
            'id_users' => '1',
        ]);

        User::create([
            'nama_pegawai' => 'ghina',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'admin',
            'id_jabatan' => '1',
            'is_deleted' => '1'
        ]);

        Profile::create([
            'id_users' => '2',
        ]);
    }
}