<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        // $roles = ['superadmin', 'admin', 'instructor', 'student'];
        // foreach ($roles as $roleName) {
        //     Role::firstOrCreate(['name' => $roleName]);
        // }

        // Data user
        $users = [
            [
                'name' => 'Irfan Mahfudz Guntur',
                'email' => 'tutacare@gmail.com',
                'password' => '123123123',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => '123123123',
                'role' => 'admin',
            ],
            [
                'name' => 'Sarif Hidayat',
                'email' => 'sarifhidayat@gmail.com',
                'password' => '123123123',
                'role' => 'instructor',
            ],
            [
                'name' => 'Hasan Basri',
                'email' => 'hasanbasri@gmail.com',
                'password' => '123123123',
                'role' => 'instructor',
            ],
            [
                'name' => 'Andi Astrid',
                'email' => 'andiastrid@gmail.com',
                'password' => '123123123',
                'role' => 'student',
            ],
            [
                'name' => 'Ahmad Sahdan',
                'email' => 'ahmadsahdan@gmail.com',
                'password' => '123123123',
                'role' => 'student',
            ],
        ];

        // Buat user dan assign role
        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->assignRole($data['role']);
        }
    }
}
