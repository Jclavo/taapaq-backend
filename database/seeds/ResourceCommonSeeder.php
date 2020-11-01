<?php

use Illuminate\Database\Seeder;
use App\Models\ResourceCommon;

use App\Utils\ResourceUtil;

class ResourceCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ResourceUtil::getResourceCommons() as $resource) {
             ResourceCommon::updateOrCreate(['name' => $resource]);
        }
    }
}
