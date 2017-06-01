<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_exam_kits', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('member_id')->nullable()->default(null);
            $table->integer('exam_kit_id')->nullable()->default(null);
            $table->integer('number_receive')->nullable()->default(0);

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
        Schema::dropIfExists('member_exam_kits');
    }
}
