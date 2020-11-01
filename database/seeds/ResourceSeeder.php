<?php

use Illuminate\Database\Seeder;

use App\Utils\ResourceUtil;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResourceUtil::createFromProjectCodeModule('A1','Companies','read');
    }
}
