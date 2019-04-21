<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surcharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->enum('status', array_keys(trans('globals.installments_status')))->default('pending');
            $table->string('concept', 100);
            $table->double('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('loan_id')->references('id')->on('loans');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('surcharges');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
