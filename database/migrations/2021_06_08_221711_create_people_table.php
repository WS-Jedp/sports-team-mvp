<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('last_name', 45);
            $table->string('phone');
            $table->mediumText('biography')->nullable();
            $table->integer('height', false, true)->nullable();
            $table->integer('weight', false, true)->nullable();
            $table->tinyText('position')->nullable();

            $table->foreignId('user_id')->constrained('users');

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
        Schema::dropIfExists('people');
    }
}
