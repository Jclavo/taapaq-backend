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

            ProjectSeeder::class,

            //
            LocaleSeeder::class,
            CountrySeeder::class,
            ResourceCommonSeeder::class,
            PersonTypeSeeder::class,
            
            //
           

            //seed Universal Person (User/Company)
            UniversalPersonSeeder::class,

            //seed COMPANY
            CompanySeeder::class,
            CompanyProjectSeeder::class,

            //seed PROJECT (assign company) with (MODULES/RESOURCES/PERMISSION)
            // ProjectSeeder::class,
            ModuleSeeder::class,

            //seed ROLES for COMPANY-PROJECT
            SpatieSeeder::class,

            //seed USER for (COMPANY-PROJECT) and its ROLES
            UserSeeder::class,
           
            //seed others
            SystemModelSeeder::class,
            TranslationSeeder::class,

        ]);
    }
}
