<?php

use App\PaymentFreq;
use Illuminate\Database\Seeder;

class PaymentsFreqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (trans('globals.paymentfrequency') as $key => $value) {
        	PaymentFreq::create([
                'description' => $key,
        		'days' => $value
        	]);
        }
    }
}
