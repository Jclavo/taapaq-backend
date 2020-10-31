<?php

use Illuminate\Database\Seeder;
use App\Models\UserDetail;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
        UserDetail::updateOrCreate(['identification' => '45960630'],
                                   ['email' => 'coco@example.com', 'name' => 'Coco', 
                                   'lastname' => 'The cat', 'address' => 'Chepen', 'phone' => '51942051400']
                                    );

        //Companies
        UserDetail::updateOrCreate(['identification' => '1145960630'],
                                    ['email' => 'cleivor.sac@example.com', 'name' => 'CLEIVOR SAC', 
                                    'lastname' => '-', 'address' => 'Chepen', 'phone' => '51942051499']
                                        );
    }
}
