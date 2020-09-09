<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalesToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('countries', function (Blueprint $table) {
        //     $table->string('locale')->nullable();
        // });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('locale')->references('locale')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('countries', 'name'))
        // {
        //     Schema::table('users', function (Blueprint $table)
        //     {
                
        //     });
        // }
        // Schema::table('countries', function (Blueprint $table) {
        //     $table->dropColumn('locale');
        // });
    }
}
