<?php

use App\Models\PersonType;
use Illuminate\Database\Seeder;

class PersonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PersonType::updateOrCreate(['code' => '1'],['name' => 'Natural']);
        PersonType::updateOrCreate(['code' => '2'],['name' => 'Juridical']);
    }
}
