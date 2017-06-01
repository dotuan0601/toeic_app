<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberExerciseScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_exercise_scores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('member_id')->nullable()->default(null);
            $table->integer('class_id')->nullable()->default(null);
            $table->integer('day')->nullable()->default(null);
            $table->float('score')->nullable()->default(null);

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
        Schema::dropIfExists('member_exercise_scores');
    }
}
