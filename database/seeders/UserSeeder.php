<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                // 'role' => 'admin'
            ],
            [
                'email' => 'user@user.com',
                'password' => Hash::make('123456'),
                // 'role' => 'user'
            ]
        ];

        foreach ($users as $user) {
            $user = User::factory()->create([
                'email' => $user['email'],
                'password' => $user['password']
            ]);

            $user->assignRole($user['role']);
        }
    }
}

