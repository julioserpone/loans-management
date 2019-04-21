<?php

/**
 * Loans system - Loans Seeder
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date (Dec 01 - 2015)
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Installment;
use App\Loan as Loan;
use App\PaymentFreq;

class InstallmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$loans = Loan::get();
    	$loans->each(function ($loan, $key){
    		$amount = ceil( $loan->amount / $loan->installments );
        	$interest = (ceil( ($loan->amount * $loan->interest_rate) / 100 )) / $loan->installments;
        	$payment_freq = PaymentFreq::orderByRaw('RAND()')->first();
        	for ($i=0; $i < $loan->installments; $i++){
	        	Installment::create([
	                'loan_id' => $loan->id,
	                'installment_num' => ($i+1),
	                'status' => 'pending',
	                'expired_date' => Carbon::now()->addDays($payment_freq->days),
	                'amount' => $amount,
	                'interest_amount' => $interest,
	                'total_amount' => ($amount + $interest)
	            ]);
        	}
    	});
    }
}
