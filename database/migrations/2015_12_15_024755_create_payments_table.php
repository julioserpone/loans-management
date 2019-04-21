<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->enum('status', array_keys(trans('globals.payments_status')))->default('active');
            $table->enum('method', array_keys(trans('globals.payments_methods')))->default('cash');
            $table->enum('type', array_keys(trans('globals.payments_type')))->default('installment');
            $table->enum('concept', array_keys(trans('globals.payments_concepts')))->default('other');
            $table->double('payment', 10, 2);
            $table->double('penalty_amount', 10, 2);
            $table->mediumText('notes');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('loan_id')->references('id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('payments');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
