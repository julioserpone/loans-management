<?php

/**
 * Loans system - Companies Table
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_email', 100);
            $table->string('sales_email', 100);
            $table->string('support_email', 100);
            $table->string('name', 50);
            $table->string('website_name', 50);
            $table->string('slogan', 150)->nullable();
            $table->string('logo')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('cell_phone', 20)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('state', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->string('facebook', 50)->nullable();
            $table->string('facebook_app_id', 50)->nullable();
            $table->longText('description');
            $table->mediumText('keywords');
            $table->mediumText('about_us');
            $table->mediumText('refund_policy');
            $table->mediumText('privacy_policy');
            $table->mediumText('terms_of_service');
            $table->string('google_maps_key_api', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}
