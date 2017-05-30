<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('question')->default('');
            $table->string('question_image_url')->nullable()->default(null);
            $table->smallInteger('is_deleted')->default(0);
            $table->double('point')->default(0);
            $table->integer('lession_id')->nullable();
            $table->integer('test_kit_id')->nullable();

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
        Schema::dropIfExists('questions');
    }
}
