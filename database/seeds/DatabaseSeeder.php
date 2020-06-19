<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SpatieSeeder::class);
        $this->call(ResourceCommonSeeder::class);
        $this->call(UserDetailSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(CompanySeeder::class);
    }
}
