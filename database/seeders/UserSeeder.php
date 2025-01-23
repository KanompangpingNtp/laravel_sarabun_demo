<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
                'agencie_id' => 1,
                'full_name' => 'ธีรภัทร วงศ์วิชัย',
                'nickname' => 'Tee',
                'phone' => '0812345678',
                'name_account' => 'sarabun01',
                'password' => Hash::make('1234'),
            ],

            [
                'agencie_id' => 2,
                'full_name' => 'สุภาวดี ชลศรี',
                'nickname' => 'May',
                'phone' => '0898765432',
                'name_account' => 'sarabun02',
                'password' => Hash::make('1234'),
            ],

            [
                'agencie_id' => 3,
                'full_name' => 'อัครพล ชัยมงคล',
                'nickname' => 'Boss',
                'phone' => '0898765432',
                'name_account' => 'sarabun03',
                'password' => Hash::make('1234'),
            ],
        ];

        foreach ($users as $item) {
            User::create($item);
        }
    }
}
