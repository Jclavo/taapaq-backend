<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversalPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal_people', function (Blueprint $table) {
            $table->id();
            $table->string('identification', 15)->unique();
            $table->string('email')->unique();
            $table->string('name',45);
            $table->string('lastname',45);
            $table->string('phone', 15)->unique();
            $table->string('address',100);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universal_persons');
    }
}
