<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleHasExcersicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_has_excersices', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained('people');
            $table->foreignId('excercise_id')->constrained('excercises');
            $table->mediumText('result');
            $table->text('video')->nullable();
            $table->dateTime('datetime')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_has_excersices');
    }
}
