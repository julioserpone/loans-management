<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentIdToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('payments', function (Blueprint $table) {
            $table->integer('installment_id')->unsigned()->after('loan_id')->nullable();
            $table->integer('surcharge_id')->unsigned()->after('installment_id')->nullable();
            $table->integer('debt_collector_id')->unsigned()->after('user_id')->nullable();
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
