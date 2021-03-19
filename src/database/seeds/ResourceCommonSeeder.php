<?php

use Illuminate\Database\Seeder;
use App\Models\ResourceCommon;

class ResourceCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ResourceSeeder::getResourceCommons() as $resource) {
             ResourceCommon::updateOrCreate(['name' => $resource]);
        }
    }
}
