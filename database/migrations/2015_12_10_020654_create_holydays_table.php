<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolydaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holydays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsable_id')->unsigned();
            $table->date('holyday');
            $table->timestamps();
            $table->foreign('responsable_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('holydays');
    }
}
