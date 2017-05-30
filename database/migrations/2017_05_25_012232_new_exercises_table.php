<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('lession_id')->nullable()->default(0);
            $table->string('introduce')->nullable();
            $table->text('content_text')->default('');
            $table->text('content_image')->default('');
            $table->text('content_audio')->default('');
            $table->string('question_ids')->nullable()->default(null);
            $table->text('note')->nullable()->default('');

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
        Schema::dropIfExists('exercises');
    }
}
