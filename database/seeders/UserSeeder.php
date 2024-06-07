<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'pseudo'            => 'admin',
            'password'          => Hash::make('Admin2024!'),
            'email'             => 'admin@admin.fr',
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'role_id'           => 2,
        ]);

        User::create([
            'pseudo'            => 'user',
            'password'          => Hash::make('User2024!'),
            'email'             => 'user@user.fr',
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'role_id'           => 1,
        ]);

        User::factory(8)->create();
    }
}
