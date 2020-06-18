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
        factory(UserDetail::class)->create(['identification' => '12345678','email' => 'coco@example.com',
                                      'name' => 'Coco', 'lastname' => 'the cat']);
        factory(UserDetail::class,5)->create();

    }
}
