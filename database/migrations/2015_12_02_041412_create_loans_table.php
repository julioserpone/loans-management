<?php

/**
 * Loans system - Loans Table
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Dec 01 - 2015)
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //either customers or employees
            $table->enum('status', array_keys(trans('globals.loans_payment_status')))->default('pending');
            $table->double('amount', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->integer('installments')->unsigned();
            $table->date('first_payment');
            $table->smallInteger('penalty_rate')->unsigned();
            $table->timestamps();
            $table->timestamp('disabled_at')->nullable();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('loans');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
