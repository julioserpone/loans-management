<?php

/**
 * Loans system - Users Table
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role', array_keys(trans('globals.roles')))->default('adviser');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username')->unique();
            $table->string('pic_url', 150);
            $table->enum('gender', array_keys(trans('globals.gender')))->default('male');
            $table->enum('identification_type', array_keys(trans('globals.identification_type')))->default('cc');
            $table->string('identification', 50)->unique();
            $table->date('birth_date', 50)->nullable();
            $table->string('cellphone_number', 20)->nullable();
            $table->string('homephone_number', 20)->nullable();
            $table->string('email', '100')->unique();
            $table->string('password', 60);
            $table->enum('verified', array_keys(trans('globals.verification')))->default('yes');
            $table->enum('status', array_keys(trans('globals.type_status')))->default('active');
            $table->string('language', 5)->default('en');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('disabled_at')->nullable();
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
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('users');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
