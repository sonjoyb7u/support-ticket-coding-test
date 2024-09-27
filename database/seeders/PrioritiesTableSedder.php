<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritiesTableSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = Priority::insert([
            [
                'name' => 'low'
            ],
            [
                'name' => 'medium'
            ],
            [
                'name' => 'high'
            ],
            [
                'name' => 'urgent'
            ],
        ]);
    }
}
