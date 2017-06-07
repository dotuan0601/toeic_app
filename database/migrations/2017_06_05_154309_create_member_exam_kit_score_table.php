<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberExamKitScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_exam_kit_scores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('member_id')->nullable()->default(null);
            $table->integer('exam_kit_id')->nullable()->default(null);
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
        Schema::dropIfExists('member_exam_kit_scores');
    }
}
