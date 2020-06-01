<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            'restaurant R',
            'pharmacy P',
            'Shoes S',
            'Store S'
        ];

        foreach ($companies as $company) {
            factory(Company::class)->create(['name' => $company]);
        }     
    }
}
