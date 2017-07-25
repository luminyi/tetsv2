<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consults_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });


        Schema::create('consult_user', function (Blueprint $table) {
            $table->increments('consult_id');
            $table->integer('user_id');
            $table->integer('consults_type_id')->unsigned();
            $table->dateTime('submit_time');
            $table->string('term');
            $table->string('state');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('consults_type_id')
                ->references('id')
                ->on('consults_type')
                ->onDelete('cascade');
        });

        Schema::create('consults', function (Blueprint $table) {
            $table->increments('consult_id');
            $table->integer('floor_id');
            $table->integer('comment_user_id');
            $table->text('content');

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
