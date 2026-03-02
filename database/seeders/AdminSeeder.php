<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On cr\u00e9e ou on r\u00e9cup\u00e8re l'utilisateur avec cet email pour \u00e9viter les doublons
        User::firstOrCreate(
        ['email' => 'admin@defitech.tg'],
        [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]
        );
    }
}