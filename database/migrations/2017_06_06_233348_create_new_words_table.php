<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_words', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('new_words_packs_id')->nullable()->default(null);
            $table->string('name')->default('');
            $table->string('spelling')->nullable()->default(null);
            $table->text('meaning')->nullable()->default(null);
            $table->text('content_image')->nullable()->default(null);
            $table->text('content_audio')->nullable()->default(null);

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
        Schema::dropIfExists('new_words');
    }
}
