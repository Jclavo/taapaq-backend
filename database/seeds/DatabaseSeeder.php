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
        $this->call([
            //
            LocaleSeeder::class,
            CountrySeeder::class,
            ResourceCommonSeeder::class,

            //seed Universal Person (User/Company)
            UniversalPersonSeeder::class,

            //seed PROJECT with (MODULES/RESOURCES/PERMISSION)
            ProjectSeeder::class,
            ModuleSeeder::class,

            //seed COMPANY
            CompanySeeder::class,

            //seed ROLES for COMPANY-PROJECT
            SpatieSeeder::class,

            //seed USER for (COMPANY-PROJECT) and its ROLES
            UserSeeder::class,
           
            //seed others
            SystemModelSeeder::class,
            //translation 

        ]);
    }
}
