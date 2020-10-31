<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\UserDetail;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser = UserDetail::updateOrCreate(['identification' => '1145960630']);

        Company::updateOrCreate(['user_detail_id' => $newUser->id, 'country_code' => 55]);
    }
}
