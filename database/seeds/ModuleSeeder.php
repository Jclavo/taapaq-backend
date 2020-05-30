<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Module::class,5)->create(['project_id' => '1']);
        factory(Module::class,5)->create();
    }
}
