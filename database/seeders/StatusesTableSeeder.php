<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = Status::insert([
            [
                'name' => 'open'
            ],
            [
                'name' => 'processing'
            ],
            [
                'name' => 'pending'
            ],
            [
                'name' => 'resloved'
            ],
            [
                'name' => 'closed'
            ],
        ]);
    }
}
