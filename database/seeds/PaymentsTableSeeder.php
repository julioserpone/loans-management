<?php

/**
 * Loans system - Payments Seeder
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date (Dec 16 - 2015)
 */

use Illuminate\Database\Seeder;
use App\User;
use App\Loan;
use App\Installment;
use App\Payment;
use Faker\Factory as Faker;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $loan = Loan::select(['id'])->orderByRaw("RAND()")->first();

        for ($i=0; $i < 10; $i++)
        {
            $user = User::select(['id'])->orderByRaw("RAND()")->first();
        	$debt_collector = User::select(['id'])->orderByRaw("RAND()")->first();
        	$loan = Loan::select(['id'])->orderByRaw("RAND()")->first();

        	Payment::create([
                'user_id' => $user->id,
        		'debt_collector_id' => $debt_collector->id,
        		'loan_id' => $loan->id,
        		'method' => $faker->randomElement(array_keys(trans('globals.payments_methods'))),
                'type' => $faker->randomElement(array_keys(trans('globals.payments_type'))),
        		'concept' => $faker->randomElement(array_keys(trans('globals.payments_concepts'))),
        		'payment' => $faker->randomFloat(10, 2),
        		'over_due' => $faker->randomElement(['0', '1']),
        		'notes' => $faker->text(500)
        	]);
        }
    }
}
