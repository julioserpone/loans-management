<?php

/**
 * Loans system - Customers Table
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customers', function (Blueprint $table) {

            //Personal Information Fields
            $table->integer('user_id')->unsigned();
            $table->integer('bank_id')->unsigned()->default(1);
            $table->string('card_number',20)->nullable();
            $table->string('card_key', 20)->nullable();
            $table->integer('city_id')->unsigned()->default(3);
            $table->mediumText('address');
            $table->mediumText('notes');
            $table->string('email', 100)->nullable();

            //Employment Information Fields
            $table->string('company', 50);
            $table->enum('contract_type', array_keys(trans('globals.contract_type')))->default('linked');
            $table->string('company_temporal', 50);
            $table->string('company_position', 50);
            $table->double('company_salary', 10, 2);
            $table->date('company_time_worked', 50);
            $table->enum('company_eps', array_keys(trans('globals.eps')))->default('sanitas');
            $table->enum('company_affiliation_type', array_keys(trans('globals.affiliation_type')))->default('contributor');
            $table->integer('company_city_id')->unsigned()->default(1);
            $table->mediumText('company_address');
            $table->string('company_cellphone', 20);
            $table->string('company_landphone', 20)->nullable();

            //References Fields
            $table->enum('reference_type', array_keys(trans('globals.reference_type')))->default('personal');
            $table->enum('reference_relationship', array_keys(trans('globals.relationship')));
            $table->enum('reference_identification_type', array_keys(trans('globals.identification_type')))->default('cc');
            $table->string('reference_identification', 50);
            $table->string('reference_first_name', 50);
            $table->string('reference_last_name', 50);
            $table->integer('reference_city_id')->unsigned()->default(1);
            $table->mediumText('reference_address');
            $table->string('reference_cellphone', 20);
            $table->string('reference_landphone', 20)->nullable();
            $table->string('reference_email', 100);

            //Control Fields
            $table->timestamps();
            $table->timestamp('disabled_at')->nullable();
            $table->softDeletes();

            //Table Relationship
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('company_city_id')->references('id')->on('cities');
            $table->foreign('reference_city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('customers');
    }
}
