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
        $resources = [
            'create',
            'update',
            'read',
            'delete',
            'pagination',
            'show'
        ];

        foreach ($resources as $resource) {
            factory(ResourceCommon::class)->create(['name' => $resource]);
        }
    }
}
