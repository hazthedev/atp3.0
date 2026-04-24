<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_code' => 'admin',
                'name' => 'System Administrator',
                'email' => 'admin@weststar.com.my',
                'is_superuser' => true,
                'branch' => 'Main',
                'department' => 'IT',
                'change_password_next_logon' => false,
                'password' => Hash::make('password'),
            ],
            [
                'user_code' => 'fauzan.ab',
                'name' => 'AB Fauzan',
                'email' => 'fauzan.ab@weststar.com.my',
                'is_superuser' => false,
                'branch' => 'KUL',
                'department' => 'Engineering',
                'mobile_phone' => '+60 12 345 6789',
                'change_password_next_logon' => false,
                'password' => Hash::make('password'),
            ],
            [
                'user_code' => 'aina.noor',
                'name' => 'Aina Mohd Noor',
                'email' => 'aina.noor@weststar.com.my',
                'is_superuser' => false,
                'branch' => 'KUL',
                'department' => 'Planning',
                'mobile_phone' => '+60 17 833 2900',
                'change_password_next_logon' => false,
                'password' => Hash::make('password'),
            ],
            [
                'user_code' => 'shahrul.a',
                'name' => 'Ahmad Shahrul',
                'email' => 'shahrul.a@weststar.com.my',
                'is_superuser' => false,
                'branch' => 'SUBANG',
                'department' => 'Tech Service',
                'mobile_phone' => '+60 19 772 4012',
                'change_password_next_logon' => false,
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $row) {
            User::updateOrCreate(
                ['email' => $row['email']],
                $row,
            );
        }
    }
}
