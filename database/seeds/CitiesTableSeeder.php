<?php

/**
 * Loans system - Cities Seeder
 *
 * @author Julio Hernandez <juliohernandezs@gmail.com>
 *
 * @date(Nov 25 - 2015)
 */

use App\Cities;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = array('LETICIA','MEDELLIN','ARAUCA','BARRANQUILLA','CARTAGENA','TUNJA','MANIZALES','FLORENCIA','YOPAL','POPAYAN','VALLEDUPAR','QUIBDO','MONTERIA','BOGOTA','PUERTO INIRIDA','SAN JOSE DEL GUAVIARE','NEIVA','RIOHACHA','SANTA MARTA','VILLAVICENCIO','PASTO','CUCUTA','MOCOA','ARMENIA','PEREIRA','SAN ANDRES','BUCARAMANGA','SINCELEJO','IBAGUE','CALI','MITU'
        );

        foreach ($cities as $city) {
            Cities::create(['name' => $city]);
        }
    }
}
