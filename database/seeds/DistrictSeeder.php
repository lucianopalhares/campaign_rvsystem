<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            'id' => 1,
            'city_id' => null,
            'name' => null,
            'type' => 'Area Urbana - Centro e Bairros'
        ]);
        DB::table('districts')->insert([
            'id' => 2,
            'city_id' => null,
            'name' => null,
            'type' => 'Zona Rural - Povoados,Chacaras,Fazendas e Outros'
        ]);
    }
}
