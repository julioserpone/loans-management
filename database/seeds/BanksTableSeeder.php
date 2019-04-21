<?php

/**
 * Loans system - Companies Seeder
 *
 * @author Julio Hernandez <juliohernandezs@gmail.com>
 *
 * @date(Nov 25 - 2015)
 */

use App\Banks;
use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = array(
            'BANCO COOPERATIVO COOPCENTRAL',
            'BANCO SANTANDER DE NEGOCIOS COLOMBIA S.A. - BANCO SANTANDER',
            'BANCO FINANDINA S.A.',
            'BANCO FALABELLA S.A.',
            'BANCOOMEVA',
            'BANCO PICHINCHA S.A.',
            'BANCAMIA',
            'BANCO PROCREDIT',
            'BANCO WWB S.A.',
            'BANCO AV VILLAS',
            'BANCO DAVIVIENDA S.A.',
            'BANCO AGRARIO DE COLOMBIA S.A.',
            'BANCO CAJA SOCIAL - BCSC S.A.',
            'BANCO DE COMERCIO EXTERIOR DE COLOMBIA S.A. (BANCOLDEX)',
            'BANCO DE OCCIDENTE',
            'RED MULTIBANCA COLPATRIA S.A.',
            'HELM BANK',
            'BBVA COLOMBIA',
            'BANCO GNB SUDAMERIS COLOMBIA',
            'BANCO GNB COLOMBIA S.A.',
            'CITIBANK COLOMBIA',
            'BANCOLOMBIA S.A.',
            'BANCO CORPBANCA COLOMBIA S.A.',
            'BANCO POPULAR',
            'BANCO DE BOGOTÁ',
            'BANCO DE LA REPÚBLICA'
        );

        foreach ($banks as $bank) {
            Banks::create(['name' => $bank]);
        }
    }
}
