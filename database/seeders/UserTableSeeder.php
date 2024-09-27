<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $users = User::insert([
            [
                'name' => 'Admin', 
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'is_admin' => 1,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            ],
            [
                'name' => 'Customer', 
                'email' => 'customer@gmail.com',
                'password' => Hash::make('123456'),
                'is_admin' => 0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]
        ]);
    }
}
