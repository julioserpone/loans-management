<?php

/**
 * Loans system - Companies Seeder
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

use App\Company;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker=Faker::create();

        Company::create([
            'name' => "LoansVel",
            'website_name' => "LoansVel",
            'slogan' => 'Loans System',
            'logo'=> '/img/pt-default/'.$faker->unique()->numberBetween(1, 330).'.jpg',
            'phone_number' => $faker->phoneNumber,
            'cell_phone' => $faker->phoneNumber,
            'address' => $faker->streetAddress,
            'state' => $faker->state,
            'city' => $faker->city,
            'zip_code' => $faker->postcode,
            'facebook' => 'AntVel',
            'facebook_app_id' => $faker->md5,
            'twitter' => 'gocanto',
            'contact_email' => 'contact@g-ocanto.com',
            'sales_email' => 'sales@g-ocanto.com',
            'support_email' => 'support@g-ocanto.com',
            'website'  => 'http://g-ocanto.com',
            'description' => $faker->text(200),
            'keywords'  => implode(",", $faker->words(20)),
            'about_us' => $faker->text(1200),
            'refund_policy' => trans('law.refund'),
            'privacy_policy' => trans('law.privacy'),
            'terms_of_service' => trans('law.terms'),
            'google_maps_key_api' => '',
        ]);
    }
}
