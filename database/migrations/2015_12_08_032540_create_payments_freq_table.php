<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsFreqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_freq', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', array_keys(trans('globals.type_status')))->default('active');
            $table->string('description', 50);
            $table->integer('days')->unsigned();
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
        Schema::drop('payments_freq');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
