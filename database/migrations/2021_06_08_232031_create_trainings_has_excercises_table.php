<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsHasExcercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings_has_excercises', function (Blueprint $table) {
            $table->foreignId('schedule_id')->constrained('training_schedules');
            $table->foreignId('excercise_id')->constrained('excercises');
            $table->mediumText('result');
            $table->text('video_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings_has_excercises');
    }
}
