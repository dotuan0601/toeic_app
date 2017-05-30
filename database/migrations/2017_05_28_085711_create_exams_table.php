<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('content_text')->nullable()->default(null);
            $table->string('content_image')->nullable()->default(null);
            $table->string('content_audio')->nullable()->default(null);
            $table->integer('exam_kit_id')->default(1);

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
        Schema::dropIfExists('exams');
    }
}
