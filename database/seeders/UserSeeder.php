<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('secret')
            ],
            [
                'name' => 'user',
                'email' => 'user@test.com',
                'password' => Hash::make('secret')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
