<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
Use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'  => 'Admin Test',
            'email'  => 'admin@gmail.com',
            'password'  => Hash::make('password123'),

        ]);

         User::insert([
            [
            'name'  => 'Binette',
            'email'  => 'binette@gmail.com',
            'password'  => Hash::make('binette1234'),
            'created_at'  => now(),
            'updated_at'  => now(),
            ],

            [
            'name'  => 'Sanou',
            'email'  => 'sanou@gmail.com',
            'password'  => Hash::make('sanou1234'),
            'created_at'  => now(),
            'updated_at'  => now(),
            ],
        

        ]);
    }
}
