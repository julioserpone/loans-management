<?php

use database\seeds\ContactsTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CitiesTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(PaymentsFreqTableSeeder::class);
        // $this->call(LoansTableSeeder::class);
        // $this->call(InstallmentsTableSeeder::class);
        // $this->call(PaymentsTableSeeder::class);

        Model::reguard();
    }
}
