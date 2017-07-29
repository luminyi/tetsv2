<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('teacher');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('place');
            $table->string('state');
            $table->text('information');
            $table->integer('all_num');
            $table->integer('attend_num');
            $table->integer('remainder_num');
            $table->string('term');
            $table->timestamps();
        });


        Schema::create('activity_user', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('activity_id')->unsigned();
            $table->string('state');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');
            $table->primary(['user_id','activity_id','state']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
