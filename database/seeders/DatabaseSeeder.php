<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create();

        User::create([
            'nama' => 'Adi Saputra',
            'email' => 'coba@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'no_hp' => '08127566554',
            'alamat' => 'apa aja',
            'level' => '1',
        ]);
        User::create([
            'nama' => 'Andre Putra',
            'email' => 'test@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'no_hp' => '08127566554',
            'alamat' => 'apa aja',
            'level' => '2',
        ]);
    }
}