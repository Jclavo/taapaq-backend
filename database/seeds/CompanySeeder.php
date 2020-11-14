<?php

use Illuminate\Database\Seeder;
use App\Utils\CompanyUtil;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyUtil::createFromIdentification(env('COMPANY_CLEIVOR_IDENTIFICATION'));   
    }
}
