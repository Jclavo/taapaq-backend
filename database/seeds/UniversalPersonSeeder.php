<?php

use Illuminate\Database\Seeder;
use App\Models\UniversalPerson;

class UniversalPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
        UniversalPerson::updateOrCreate(['identification' => env('USER_COCO_IDENTIFICATION')],
                                   ['email' => 'coco@example.com', 'name' => 'Coco', 
                                   'lastname' => 'The cat', 'address' => 'Chepen', 'phone' => '51942051400']
                                    );

        //Companies
        UniversalPerson::updateOrCreate(['identification' => env('COMPANY_CLEIVOR_IDENTIFICATION')],
                                    ['email' => 'cleivor.sac@example.com', 'name' => 'CLEIVOR SAC', 
                                    'lastname' => '-', 'address' => 'Chepen', 'phone' => '51942051499']
                                        );
    }
}
