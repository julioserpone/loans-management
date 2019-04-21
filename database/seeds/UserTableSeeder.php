<?php

/**
 * Loans system - Users Seeder
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

use App\Banks as Banks;
use App\Cities as Cities;
use App\Customer as Customer;
use App\User as User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create();

        //Admin
        User::create([
            'role' => 'admin',
            'first_name' => 'Gustavo',
            'last_name' => 'Ocanto',
            'username' => 'admin',
            'gender' => 'male',
            'pic_url' => '/img/avatar' . $faker->numberBetween(1, 6) . '.png',
            'identification' => $faker->unique()->numberBetween(1, 99999),
            'birth_date' => $faker->dateTimeBetween('-40 years', '-16 years'),
            'cellphone_number' => '+14056696331',
            'email' => 'gustavoocanto@gmail.com',
            'password' => \Hash::make('gocanto'),
        ]);

        //Employees
        for ($i = 0; $i < 10; $i++) {
            $first_name = $faker->unique()->firstName;
            $last_name = $faker->unique()->lastName;
            User::create([
                'role' => 'adviser',
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => substr($first_name, 1, 1).strtolower($last_name),
                'gender' => $faker->randomElement(['male', 'female']),
                'pic_url' => '/img/avatar' . $faker->numberBetween(1, 6) . '.png',
                'identification_type' => $faker->randomElement(['cc', 'ce']),
                'identification' => $faker->unique()->numberBetween(1, 99999),
                'birth_date' => $faker->dateTimeBetween('-40 years', '-16 years'),
                'cellphone_number' => $faker->phoneNumber,
                'homephone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->email,
                'password' => \Hash::make('123456'),
            ]);

        } //for

        //Customers
        for ($i = 0; $i < 10; $i++) {
            $first_name = $faker->unique()->firstName;
            $last_name = $faker->unique()->lastName;
            $city = Cities::select(['id'])->orderByRaw('RAND()')->first();
            $city_company = Cities::select(['id'])->orderByRaw('RAND()')->first();
            $city_reference = Cities::select(['id'])->orderByRaw('RAND()')->first();
            $bank = Banks::select(['id'])->orderByRaw('RAND()')->first();
            Customer::create([

                //Personal Information Fields
                'bank_id' => $bank->id,
                'card_number' => $faker->unique()->creditCardNumber,
                'city_id' => $city->id,
                'address' => $faker->streetAddress,
                'notes' => $faker->text(200),
                'email' => $faker->unique()->email,

                //Employment Information Fields
                'company' => $faker->company,
                'contract_type' => $faker->randomElement(array_keys(trans('globals.contract_type'))),
                'company_temporal' => $faker->company,
                'company_position' => $faker->text(50),
                'company_salary' => $faker->randomFloat(10, 2),
                'company_time_worked' => $faker->dateTimeBetween('-30 years', '-1 years'),
                'company_eps' => $faker->randomElement(array_keys(trans('globals.eps'))),
                'company_affiliation_type' => $faker->randomElement(array_keys(trans('globals.affiliation_type'))),
                'company_city_id' => $city_company->id,
                'company_address' => $faker->streetAddress,
                'company_cellphone' => $faker->phoneNumber,
                'company_landphone' => $faker->phoneNumber,

                //References Fields
                'reference_type' => $faker->randomElement(array_keys(trans('globals.reference_type'))),
                'reference_relationship' => $faker->randomElement(array_keys(trans('globals.relationship'))),
                'reference_identification_type' => $faker->randomElement(['cc', 'ce']),
                'reference_identification' => $faker->unique()->numberBetween(1, 99999),
                'reference_first_name' => $faker->firstName,
                'reference_last_name' => $faker->lastName,
                'reference_city_id' => $city_reference->id,
                'reference_address' => $faker->streetAddress,
                'reference_cellphone' => $faker->phoneNumber,
                'reference_landphone' => $faker->phoneNumber,
                'reference_email' => $faker->unique()->email,

                //User Fields
                'user' => [
                    'role' => 'customer',
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => substr($first_name, 1, 1).strtolower($last_name),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'pic_url' => '/img/avatar' . $faker->numberBetween(1, 6) . '.png',
                    'identification_type' => $faker->randomElement(['cc', 'ce']),
                    'identification' => $faker->unique()->numberBetween(1, 99999),
                    'birth_date' => $faker->dateTimeBetween('-40 years', '-16 years'),
                    'cellphone_number' => $faker->phoneNumber,
                    'homephone_number' => $faker->phoneNumber,
                    'email' => $faker->unique()->email,
                    'password' => \Hash::make('123456'),
                ],

            ]);

        } //for

    }
}
