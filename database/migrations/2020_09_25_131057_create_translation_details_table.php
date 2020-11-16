<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translation_details', function (Blueprint $table) {
            $table->id();
            $table->string('value');

            //FK for locales
            $table->string('locale',5);
            // $table->foreign('locale')->references('code')->on('locales');

            $table->unsignedBigInteger('translation_id');
            $table->foreign('translation_id')->references('id')->on('translations')->onDelete('cascade');

            // $table->unique( array('email','name') );
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
        Schema::dropIfExists('translation_details');
    }
}
