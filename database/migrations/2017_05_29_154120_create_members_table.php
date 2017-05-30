<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('nickname')->nullable()->default(null);
            $table->string('full_name')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('id_fb')->nullable()->default(null);
            $table->string('id_gplus')->nullable()->default(null);
            $table->dateTime('register_date')->nullable()->default(null);
            $table->dateTime('last_login_time')->nullable()->default(null);
            $table->smallInteger('banned')->nullable()->default(0);
            $table->string('level')->nullable()->default(null);

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
        Schema::dropIfExists('members');
    }
}
