<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\UniversalPerson;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser = UniversalPerson::updateOrCreate(['identification' => '2045960630']);

        Company::updateOrCreate(['universal_person_id' => $newUser->id, 'country_code' => 55]);
    }
}
