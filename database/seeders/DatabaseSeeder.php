<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Naurah Sallsabila',
            'username' => 'naurah',
            'email' => 'naurah@sistemy.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Cahaya Indah',
            'username' => 'cahaya',
            'email' => 'cahaya@sistemy.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Resa Ristiana',
            'username' => 'resa',
            'email' => 'resa@sistemy.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Olip',
            'username' => 'olip',
            'email' => 'olip@sistemy.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Ummul Hamdiyyah',
            'username' => 'ummul',
            'email' => 'ummul@sistemy.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);
    }
}