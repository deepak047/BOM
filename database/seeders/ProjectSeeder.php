<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::create([
            'name'        => 'High-Pressure Steam Turbine Assembly',
            'code'        => 'HPST-2026',
            'priority'        => 'Medium',
        ]);
    }
}
