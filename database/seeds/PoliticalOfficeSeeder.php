<?php

use Illuminate\Database\Seeder;

class PoliticalOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('political_offices')->insert([
            'name' => 'Presidente(a)',
            'slug' => 'presidente'
        ]);
        DB::table('political_offices')->insert([
            'name' => 'Governador(a)',
            'slug' => 'governador'
        ]);
        DB::table('political_offices')->insert([
            'name' => 'Senador(a)',
            'slug' => 'senador'
        ]);
        DB::table('political_offices')->insert([
            'name' => 'Prefeito(a)',
            'slug' => 'prefeito'
        ]);
        DB::table('political_offices')->insert([
            'name' => 'Vice-Prefeito(a)',
            'slug' => 'vice-prefeito'
        ]);
        DB::table('political_offices')->insert([
            'name' => 'Vereador(a)',
            'slug' => 'vereador'
        ]);
    }
}
