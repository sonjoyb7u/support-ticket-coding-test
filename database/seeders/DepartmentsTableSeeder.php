<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::insert([
            [
                'name' => 'it',
                'public' => true,
            ],
            [
                'name' => 'software',
                'public' => true,
            ]
        ]);
    }
}
