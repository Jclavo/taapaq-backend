<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $projects = [
            'Taapaq',
            'Store',
            'Map',
            'Corso'
        ];

        foreach ($projects as $project) {
            factory(Project::class)->create(['name' => $project]);
        }    
    }
}
