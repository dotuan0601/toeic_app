<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toeic_classes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->default(null);
            $table->string('level')->nullable()->default('newbie');
            $table->smallInteger('status')->nullable()->default(0);
            $table->date('start_date')->nullable()->default(null);
            $table->integer('number_members')->nullable()->default(0);

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
        Schema::dropIfExists('toeic_classes');
    }
}
