<?php

/**
 * Loans system - Loans Seeder
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date (Dec 01 - 2015)
 */

use App\User as User;
use App\Customer as Customer;
use App\Cities as Cities;
use App\Banks as Banks;
use App\Loan as Loan;
use App\PaymentFreq;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i<15; $i++) {

            $user = User::orderByRaw('RAND()')->first();
        	$payment_freq = PaymentFreq::orderByRaw('RAND()')->first();
            $date = Carbon::now()->addDays($payment_freq->days);
        	$loan = new Loan();
        	$loan->user_id = $user->id;
        	$loan->status = $faker->randomElement(array_keys(trans('globals.loans_payment_status')));
        	$loan->amount = $faker->randomFloat(10, 2);
        	$loan->interest_rate = $faker->randomFloat(2, 1, 35);
        	$loan->payment_freq_id = $payment_freq->id;
        	$loan->installments = $faker->numberBetween(1,10);
        	$loan->first_payment = $date;
        	$loan->penalty_rate = mt_rand(1,10);
        	$loan->created_at = Carbon::now();
        	//$loan->updated_at = $faker->dateTime();
        	//$loan->disabled_at = $faker->dateTime();
        	$loan->save();


        }
    }
}
