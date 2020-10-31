<?php

use Illuminate\Database\Seeder;
use App\Models\User;

use App\Utils\UserUtil;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserUtil::createFromCompanyProject(2045960630,'A1',45960630);   
    }
}
