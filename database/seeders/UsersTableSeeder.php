<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2024-04-18 11:21:12',
                'verification_token' => '',
                'two_factor_code'    => '',
                'phone_number'       => '',
                'document_number'    => '',
            ],
        ];

        User::insert($users);
    }
}
