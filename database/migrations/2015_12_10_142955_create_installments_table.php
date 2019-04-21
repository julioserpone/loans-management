<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id')->unsigned();
            $table->integer('holyday_id')->unsigned();
            $table->integer('installment_num')->unsigned();
            $table->enum('status', array_keys(trans('globals.installments_status')))->default('pending');
            $table->date('expired_date');
            $table->double('amount', 10, 2);
            $table->double('interest_amount', 10, 2);
            $table->double('total_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('loan_id')->references('id')->on('loans');
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
        Schema::drop('installments');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
