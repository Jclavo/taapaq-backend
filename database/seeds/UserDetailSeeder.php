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
        UserDetail::updateOrCreate(['identification' => '45960630'],
                                   ['email' => 'coco@example.com', 'name' => 'Coco', 
                                   'lastname' => 'The cat', 'address' => 'Chepen', 'phone' => '51942051400']
                                );
    }
}
