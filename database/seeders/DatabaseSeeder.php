<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        User::create([
            'nama_pegawai' => 'Admin',
            'email' => 'admin@admin.com',
            // 'email_verified_at' => now(),
            'password' => '12345678',
            'level' => 'admin',
            'is_deletd' => '0'
        ]);

        User::create([
            'nama_pegawai' => 'ghina',
            'email' => 'admin@gmail.com',
            // 'email_verified_at' => now(),
            'password' => '12345678',
            'level' => 'admin',
            'is_deletd' => '1'
        ]);
    }
}